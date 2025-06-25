<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyDonorsController extends Controller
{
    /**
     * Display a listing of assigned donors for the authenticated user's blood requests.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all blood requests created by the user
        $bloodRequests = BloodRequest::where('user_id', $user->id)
            ->with(['donations.donor'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get all unique donors assigned to the user's blood requests
        $donors = collect();
        foreach ($bloodRequests as $request) {
            foreach ($request->donations as $donation) {
                if ($donation->donor) {
                    $donors->push([
                        'donor' => $donation->donor,
                        'donation' => $donation,
                        'request' => $request
                    ]);
                }
            }
        }
        
        // Group by donor ID to avoid duplicates, but keep the most recent donation
        $uniqueDonors = $donors->groupBy('donor.id')
            ->map(function ($group) {
                return $group->sortByDesc('donation.created_at')->first();
            })
            ->values();
        
        return view('frontend.my-donors.index', compact('bloodRequests', 'uniqueDonors'));
    }
} 