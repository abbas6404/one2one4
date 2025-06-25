<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get all divisions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDivisions()
    {
        $divisions = Division::orderBy('name')->get();
        return response()->json($divisions);
    }

    /**
     * Get districts for a division.
     *
     * @param  int  $divisionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($divisionId)
    {
        $districts = District::where('division_id', $divisionId)
            ->orderBy('name')
            ->get();
        return response()->json($districts);
    }

    /**
     * Get upazilas for a district.
     *
     * @param  int  $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpazilas($districtId)
    {
        $upazilas = Upazila::where('district_id', $districtId)
            ->orderBy('name')
            ->get();
        return response()->json($upazilas);
    }
} 