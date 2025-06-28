<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BloodRequestSearchController extends Controller
{
    /**
     * Search for blood requests by ID, patient name, or hospital
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([]);
        }
        
        $bloodRequests = BloodRequest::whereIn('status', ['pending', 'approved'])
            ->where(function($q) use ($query) {
                $q->where('id', 'like', "%$query%")
                  ->orWhere('patient_name', 'like', "%$query%")
                  ->orWhere('hospital_name', 'like', "%$query%")
                  ->orWhere('blood_type', 'like', "%$query%")
                  ->orWhere('contact_number', 'like', "%$query%");
            })
            ->limit(10)
            ->get();
            
        return response()->json($bloodRequests);
    }
    
    /**
     * Get a blood request by ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $id = $request->get('id');
        
        $bloodRequest = BloodRequest::find($id);
            
        if (!$bloodRequest) {
            return response()->json(['error' => 'Blood request not found'], 404);
        }
        
        return response()->json($bloodRequest);
    }
} 