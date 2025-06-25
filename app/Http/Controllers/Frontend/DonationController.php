<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    protected function calculateStats($user)
    {
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

        return $stats;
    }

    public function index()
    {
        $user = auth()->user();
        $stats = $this->calculateStats($user);
        
        // Get all donations with recipient and blood request information
        $donations = BloodDonation::with(['bloodRequest.user'])
                                 ->where('donor_id', $user->id)
                                 ->latest('donation_date')
                                 ->paginate(10);
        
        return view('frontend.donation.index', compact('user', 'stats', 'donations'));
    }

    public function schedule()
    {
        $user = auth()->user();
        $stats = $this->calculateStats($user);
        
        return view('frontend.donation.schedule', compact('stats'));
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'donation_date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        $donation = BloodDonation::create([
            'donor_id' => auth()->id(),
            'donation_date' => $validated['donation_date'],
            'location' => $validated['location'],
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        return redirect()->route('donation.index')
            ->with('success', 'Donation scheduled successfully!');
    }
} 