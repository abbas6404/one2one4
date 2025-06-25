<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\BloodRequest;
use App\Models\BloodDonation;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $this->checkAuthorization($admin, ['dashboard.view']);

        // Get basic counts
        $totalAdmins = Admin::count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalUsers = User::count();
        $totalDonors = User::where('is_donor', true)->count();
        
        // Get blood donation statistics
        $totalRequests = BloodRequest::count();
        $totalDonations = BloodDonation::count();
        $completedDonations = BloodDonation::where('status', 'completed')->count();
        $pendingRequests = BloodRequest::where('status', 'pending')->count();
        $inProgressRequests = BloodRequest::where('status', 'in_progress')->count();
        $approvedRequests = BloodRequest::where('status', 'approved')->count();
        $completedRequests = BloodRequest::where('status', 'completed')->count();
        $totalBloodVolume = BloodDonation::where('status', 'completed')->count() * 0.45; // 450ml per donation
        
        // Get urgency statistics
        $urgentRequests = BloodRequest::where('urgency_level', 'urgent')->count();
        $regularRequests = BloodRequest::where('urgency_level', 'regular')->count();
        
        // Get recent statistics
        $recentRequests = BloodRequest::latest()->take(5)->get();
        $recentDonations = BloodDonation::with(['donor', 'bloodRequest'])->latest()->take(5)->get();
        
        // Get requests by blood type
        $requestsByBloodType = BloodRequest::select('blood_type', DB::raw('count(*) as count'))
            ->groupBy('blood_type')
            ->get()
            ->pluck('count', 'blood_type')
            ->toArray();
            
        // Get donors by blood type
        $donorsByBloodType = User::where('is_donor', true)
            ->select('blood_group', DB::raw('count(*) as count'))
            ->groupBy('blood_group')
            ->get()
            ->pluck('count', 'blood_group')
            ->toArray();
            
        // Get monthly donation statistics for the chart
        $monthlyStats = $this->getMonthlyDonationStats();

        return view(
            'backend.pages.dashboard.index',
            [
                'total_admins' => $totalAdmins,
                'total_roles' => $totalRoles,
                'total_permissions' => $totalPermissions,
                'total_users' => $totalUsers,
                'total_donors' => $totalDonors,
                'total_requests' => $totalRequests,
                'total_donations' => $totalDonations,
                'completed_donations' => $completedDonations,
                'pending_requests' => $pendingRequests,
                'in_progress_requests' => $inProgressRequests,
                'approved_requests' => $approvedRequests,
                'completed_requests' => $completedRequests,
                'urgent_requests' => $urgentRequests,
                'regular_requests' => $regularRequests,
                'total_blood_volume' => $totalBloodVolume,
                'recent_requests' => $recentRequests,
                'recent_donations' => $recentDonations,
                'requests_by_blood_type' => $requestsByBloodType,
                'donors_by_blood_type' => $donorsByBloodType,
                'monthly_stats' => $monthlyStats,
            ]
        );
    }
    
    /**
     * Get monthly donation statistics for the past 6 months
     * 
     * @return array
     */
    private function getMonthlyDonationStats(): array
    {
        $stats = [];
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subMonths(5);
        
        // Get donations by month
        $donationsByMonth = BloodDonation::where('status', 'completed')
            ->whereBetween('donation_date', [$startDate, $endDate])
            ->select(
                DB::raw('MONTH(donation_date) as month'),
                DB::raw('YEAR(donation_date) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->get();
            
        // Get requests by month
        $requestsByMonth = BloodRequest::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->get();
            
        // Format the data for the chart
        $months = [];
        $donationData = [];
        $requestData = [];
        
        // Prepare the last 6 months
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('n');
            $yearKey = $date->format('Y');
            $monthLabel = $date->format('M Y');
            
            $months[] = $monthLabel;
            
            // Get donation count for this month
            $donationCount = $donationsByMonth->first(function ($item) use ($monthKey, $yearKey) {
                return $item->month == $monthKey && $item->year == $yearKey;
            });
            
            $donationData[] = $donationCount ? $donationCount->count : 0;
            
            // Get request count for this month
            $requestCount = $requestsByMonth->first(function ($item) use ($monthKey, $yearKey) {
                return $item->month == $monthKey && $item->year == $yearKey;
            });
            
            $requestData[] = $requestCount ? $requestCount->count : 0;
        }
        
        // Reverse the arrays to show oldest to newest
        $months = array_reverse($months);
        $donationData = array_reverse($donationData);
        $requestData = array_reverse($requestData);
        
        return [
            'months' => $months,
            'donations' => $donationData,
            'requests' => $requestData
        ];
    }
}