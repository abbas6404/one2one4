<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Initialize default stats
        $stats = [
            'blood_group' => $user->blood_group ?? 'Not Set',
            'total_donations' => $user->total_blood_donation ?? 0,
            'total_volume' => ($user->total_blood_donation ?? 0) * 0.45, // 450ml per donation
            'lives_saved' => ($user->total_blood_donation ?? 0) * 3, // 3 lives per donation
            'is_eligible' => false,
            'days_until_eligible' => 0,
            'last_donation' => $user->last_donation_date ? Carbon::parse($user->last_donation_date)->format('M d, Y') : 'Never'
        ];
        
        // Calculate eligibility based on last_donation_date from users table
        if ($user->last_donation_date) {
            $nextEligibleDate = Carbon::parse($user->last_donation_date)->addMonths(3);
            $stats['days_until_eligible'] = (int)max(0, now()->diffInDays($nextEligibleDate, false));
            $stats['is_eligible'] = now()->greaterThanOrEqualTo($nextEligibleDate);
        } else {
            $stats['is_eligible'] = true; // No previous donation means eligible
        }
        
        // Get recent donations
        $recentDonations = BloodDonation::where('donor_id', $user->id)
                                 ->where('status', 'completed')
                                 ->latest('donation_date')
                                 ->take(5)
                                 ->get();
        
        // Prepare chart data
        $donationChart = $this->getDonationChartData($user);
        
        return view('frontend.dashboard.index', compact('user', 'stats', 'recentDonations', 'donationChart'));
    }

    protected function getDonationChartData($user)
    {
        // Get start and end dates for last 12 months
        $endDate = now();
        $startDate = now()->subMonths(11)->startOfMonth();

        // Get all donations for the last 12 months
        $donations = BloodDonation::where('donor_id', $user->id)
                           ->where('status', 'completed')
                           ->whereBetween('donation_date', [$startDate, $endDate])
                           ->get()
                           ->groupBy(function($donation) {
                               return Carbon::parse($donation->donation_date)->format('M Y');
                           });

        // Prepare last 12 months labels
        $months = collect(range(11, 0, -1))->map(function($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'label' => $date->format('M Y'),
                'key' => $date->format('M Y')
            ];
        });

        // Count donations per month
        $data = $months->map(function($month) use ($donations) {
            return $donations->get($month['key'], collect())->count();
        });

        return [
            'labels' => $months->pluck('label')->values(),
            'data' => $data->values()
        ];
    }
}
