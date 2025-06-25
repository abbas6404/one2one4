<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DonorListController extends Controller
{
    public function index(Request $request)
    {
        // Base query for donors
        $baseQuery = User::where('status', 'active')
                    ->where('is_donor', 1);

        // Apply blood type filter (handles multiple blood types)
        if ($request->has('blood_type') && !empty($request->blood_type)) {
            $baseQuery->whereIn('blood_group', $request->blood_type);
        }

        // Apply location filters
        if ($request->has('district')) {
            $baseQuery->where('present_district', 'like', '%' . $request->district . '%');
        }

        if ($request->has('sub_district')) {
            $baseQuery->where('present_sub_district', 'like', '%' . $request->sub_district . '%');
        }

        // Apply donation status filter if selected
        if ($request->has('donation_status') && $request->donation_status !== 'all') {
            if ($request->donation_status === 'donated') {
                $baseQuery->where('total_blood_donation', '>', 0);
            } elseif ($request->donation_status === 'never') {
                $baseQuery->where('total_blood_donation', 0);
            }
        }

        // Get statistics
        $totalDonors = User::where('status', 'active')
                          ->where('is_donor', 1)
                          ->count();
        $activeDonors = User::where('status', 'active')
                          ->where('is_donor', 1)
                          ->where('total_blood_donation', '>', 0)
                          ->count();
        $newDonors = User::where('status', 'active')
                       ->where('is_donor', 1)
                       ->where('created_at', '>=', now()->subMonth())
                       ->count();
        $availableTypes = User::where('status', 'active')
                           ->where('is_donor', 1)
                           ->pluck('blood_group')
                           ->unique()
                           ->count();

        // Get paginated results with proper ordering
        // Default ordering: show donors with donations first, then order by registration date
        $donors = $baseQuery->orderBy('total_blood_donation', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        return view('frontend.donors.index', compact(
            'donors',
            'totalDonors',
            'activeDonors',
            'newDonors',
            'availableTypes'
        ));
    }

    public function show($id)
    {
        try {
            $donor = User::where('status', 'active')
                        ->where('is_donor', 1)
                        ->findOrFail($id);

            // Calculate age from dob if available
            if ($donor->dob) {
                $donor->age = Carbon::parse($donor->dob)->age;
            }

            $html = view('frontend.donors.modal', compact('donor'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Donor not found:', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Donor not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error loading donor profile:', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error loading profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function contact(Request $request, $id)
    {
        try {
            $donor = User::findOrFail($id);
            
            // Validate the request
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string'
            ]);
            
            // Add your contact logic here
            // For example, sending email or saving to messages table
            
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Donor not found for contact:', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Donor not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error sending message:', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }
} 