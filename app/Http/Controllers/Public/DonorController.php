<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\WebsiteContent;
use Illuminate\Support\Facades\DB;

class DonorController extends Controller
{
    /**
     * Show the list of donors.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get donors per page limit from website content
        $perPage = (int) WebsiteContent::where('key', 'donors.per_page')
                              ->where('is_active', true)
                              ->first()
                              ->content ?? 15;
        
        $donors = User::where('is_donor', true)
                      ->where('status', 'active')
                      ->paginate($perPage);
        
        $total_donor = User::where('is_donor', true)
                          ->where('status', 'active')
                          ->count();
        
        // Get all divisions for the location filter
        $divisions = Division::orderBy('name')->get();
        
        return view('donor-list', compact('donors', 'total_donor', 'divisions'));
    }

    /**
     * Search for donors based on criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        // Get donors per page limit from website content
        $perPage = (int) WebsiteContent::where('key', 'donors.per_page')
                              ->where('is_active', true)
                              ->first()
                              ->content ?? 15;
        
        // Get the search parameters
        $bloodGroup = $request->input('blood_group');
        $divisionId = $request->input('division_id');
        $districtId = $request->input('district_id');
        $upazilaId = $request->input('upazila_id');
        $gender = $request->input('gender');
        $keywords = $request->input('keywords');

        // Start with a base query for donors
        $query = User::where('is_donor', true)
                     ->where('status', 'active');

        // Apply filters based on search parameters
        if ($bloodGroup) {
            $query->where('blood_group', $bloodGroup);
        }

        // Filter by location using hierarchical approach
        if ($upazilaId) {
            $query->whereHas('locations', function($q) use ($upazilaId) {
                $q->where('upazila_id', $upazilaId);
            });
        } elseif ($districtId) {
            $query->whereHas('locations', function($q) use ($districtId) {
                $q->where('district_id', $districtId);
            });
        } elseif ($divisionId) {
            $query->whereHas('locations', function($q) use ($divisionId) {
                $q->where('division_id', $divisionId);
            });
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($keywords) {
            $query->where(function($q) use ($keywords) {
                $q->where('name', 'like', '%' . $keywords . '%')
                  ->orWhere('email', 'like', '%' . $keywords . '%')
                  ->orWhere('phone', 'like', '%' . $keywords . '%')
                  ->orWhere('occupation', 'like', '%' . $keywords . '%');
            });
        }

        // Get the eligible donors based on last donation date
        // A donor is eligible if they haven't donated in the last 3 months
        $query->where(function($q) {
            $q->whereNull('last_donation_date')
              ->orWhere('last_donation_date', '<=', now()->subMonths(3));
        });

        // Get the search results
        $donors = $query->paginate($perPage);
        
        // Get total donor count for statistics
        $total_donor = User::where('is_donor', true)
                          ->where('status', 'active')
                          ->count();
        
        // Get all divisions for the location filter
        $divisions = Division::orderBy('name')->get();
        
        // Get districts if a division is selected
        $districts = null;
        if ($divisionId) {
            $districts = District::where('division_id', $divisionId)->orderBy('name')->get();
        }
        
        // Get upazilas if a district is selected
        $upazilas = null;
        if ($districtId) {
            $upazilas = Upazila::where('district_id', $districtId)->orderBy('name')->get();
        }

        // Return the view with the search results and hierarchical location data
        return view('donor-list', compact(
            'donors', 
            'total_donor', 
            'divisions', 
            'districts', 
            'upazilas',
            'bloodGroup',
            'divisionId',
            'districtId',
            'upazilaId',
            'gender',
            'keywords'
        ));
    }
    
    /**
     * Get districts for a given division ID.
     *
     * @param  int  $divisionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($divisionId)
    {
        $districts = District::where('division_id', $divisionId)->orderBy('name')->get();
        return response()->json($districts);
    }
    
    /**
     * Get upazilas for a given district ID.
     *
     * @param  int  $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpazilas($districtId)
    {
        $upazilas = Upazila::where('district_id', $districtId)->orderBy('name')->get();
        return response()->json($upazilas);
    }
} 