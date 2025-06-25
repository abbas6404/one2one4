<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DistrictController extends Controller
{
    /**
     * Get upazilas for a district.
     *
     * @param int $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpazilas($districtId)
    {
        try {
            $district = District::findOrFail($districtId);
            $upazilas = $district->upazilas;
            
            Log::info('Fetched upazilas', [
                'district_id' => $districtId,
                'count' => $upazilas->count(),
                'upazilas' => $upazilas->toArray()
            ]);

            return response()->json($upazilas);
        } catch (\Exception $e) {
            Log::error('Error fetching upazilas', [
                'district_id' => $districtId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Error fetching upazilas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get districts by division ID for the cascading dropdown.
     *
     * @param int $divisionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByDivision($divisionId)
    {
        try {
            $districts = District::where('division_id', $divisionId)
                ->orderBy('name', 'asc')
                ->get(['id', 'name', 'bn_name']);
            
            return response()->json($districts);
        } catch (\Exception $e) {
            Log::error('Error fetching districts by division', [
                'division_id' => $divisionId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Error fetching districts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get upazilas by district ID for the cascading dropdown.
     *
     * @param int $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpazilasByDistrict($districtId)
    {
        try {
            $district = District::findOrFail($districtId);
            $upazilas = $district->upazilas()
                ->orderBy('name', 'asc')
                ->get(['id', 'name', 'bn_name']);
            
            return response()->json($upazilas);
        } catch (\Exception $e) {
            Log::error('Error fetching upazilas by district', [
                'district_id' => $districtId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Error fetching upazilas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 