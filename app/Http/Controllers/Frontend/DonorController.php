<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\Upazila;

class DonorController extends Controller
{
    /**
     * Show the list of donors.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Base query for donors
        $query = User::where('is_donor', true);
        
        // Apply blood type filter (handle both array and single value)
        if ($request->has('blood_type') && !empty($request->blood_type)) {
            $bloodTypes = is_array($request->blood_type) ? $request->blood_type : [$request->blood_type];
            $query->whereIn('blood_group', $bloodTypes);
        }
        
        // Apply location filters
        if ($request->filled('district')) {
            $query->whereHas('locations', function($q) use ($request) {
                $q->where('district_id', $request->district)
                  ->where('type', 'present');
            });
        }

        if ($request->filled('sub_district')) {
            $query->whereHas('locations', function($q) use ($request) {
                $q->where('upazila_id', $request->sub_district)
                  ->where('type', 'present');
            });
        }

        // Apply donation status filter if selected
        if ($request->filled('donation_status') && $request->donation_status !== 'all') {
            if ($request->donation_status === 'donated') {
                $query->where('total_blood_donation', '>', 0);
            } elseif ($request->donation_status === 'never') {
                $query->where('total_blood_donation', 0);
            }
        }
        
        // Get stats
        $totalDonors = User::where('is_donor', true)->count();
        $activeDonors = User::where('is_donor', true)->where('status', 'active')->count();
        $newDonors = User::where('is_donor', true)->where('created_at', '>=', now()->subDays(30))->count();
        $availableTypes = User::where('is_donor', true)->distinct('blood_group')->count('blood_group');
        
        // Get paginated results
        $donors = $query->paginate(15)->withQueryString();
        
        // Get all districts for the filter
        $districts = District::orderBy('name')->get();
        
        // Get sub-districts for the selected district
        $subDistricts = collect();
        if ($request->filled('district')) {
            $subDistricts = Upazila::where('district_id', $request->district)
                ->orderBy('name')
                ->get();
        }
        
        return view('frontend.donors.index', compact(
            'donors', 
            'totalDonors', 
            'activeDonors', 
            'newDonors', 
            'availableTypes', 
            'districts', 
            'subDistricts'
        ));
    }

    /**
     * Get sub-districts/upazilas for a given district
     * 
     * @param int $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubDistricts($districtId)
    {
        $subDistricts = Upazila::where('district_id', $districtId)
            ->orderBy('name')
            ->get();
            
        return response()->json($subDistricts);
    }

    /**
     * Display the specified donor profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $donor = User::findOrFail($id);
        
        // Render the donor profile HTML
        $html = view('frontend.donors.profile', compact('donor'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * Handle contact form submissions for donors.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contact($id, Request $request)
    {
        $donor = User::findOrFail($id);
        
        $request->validate([
            'reason' => 'required|string|in:emergency,scheduled,inquiry',
            'message' => 'required|string|max:1000',
        ]);
        
        // Here you would handle the contact logic
        // e.g., sending an email, creating a notification, etc.
        
        // For now, we'll just return a success response
        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent to the donor successfully!'
        ]);
    }

    /**
     * Show the donor registration page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view('donor-registration'); // Render the 'donor-registration' Blade view
    }

    /**
     * Handle the donor registration form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'blood_group' => 'required|string',
            'last_donation' => 'nullable|date',
        ]);

        // Process the form submission (e.g., save to database)
        // Example: Save to database
        // Donor::create($request->all());

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Registration successful!');
    }
}