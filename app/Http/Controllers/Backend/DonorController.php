<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DonorController extends Controller
{
    /**
     * Search for donors by ID, name, or phone
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
        
        $donors = User::where('is_donor', true)
            ->where(function($q) use ($query) {
                $q->where('id', 'like', "%$query%")
                  ->orWhere('name', 'like', "%$query%")
                  ->orWhere('phone', 'like', "%$query%")
                  ->orWhere('email', 'like', "%$query%")
                  ->orWhere('blood_group', 'like', "%$query%");
            })
            ->limit(10)
            ->get();
            
        return response()->json($donors);
    }
    
    /**
     * Get a donor by ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $id = $request->get('id');
        
        $donor = User::where('id', $id)
            ->where('is_donor', true)
            ->first();
            
        if (!$donor) {
            return response()->json(['error' => 'Donor not found'], 404);
        }
        
        return response()->json($donor);
    }
} 