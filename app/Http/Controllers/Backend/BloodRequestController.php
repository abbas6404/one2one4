<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\BloodDonation;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Mail\DonorAssignmentNotification;

class BloodRequestController extends Controller
{
    public function index(Request $request): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['blood.request.view']);
        
        $query = BloodRequest::with(['user', 'donations.donor', 'division', 'district', 'upazila']);
        
        // Apply filters if provided
        if ($request->filled('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('urgency_level')) {
            $query->where('urgency_level', $request->urgency_level);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', $searchTerm)
                              ->orWhere('phone', 'like', $searchTerm);
                })
                ->orWhere('hospital_name', 'like', $searchTerm)
                ->orWhere('hospital_address', 'like', $searchTerm)
                ->orWhere('blood_type', 'like', $searchTerm);
            });
        }
        
        // Sort by urgency and date
        $query->orderByRaw("CASE WHEN urgency_level = 'urgent' THEN 0 ELSE 1 END")
              ->latest();
        
        // Paginate the results
        $bloodRequests = $query->paginate(10)->withQueryString();
            
        return view('backend.pages.blood-requests.index', compact('bloodRequests'));
    }

    public function show(BloodRequest $bloodRequest): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['blood.request.view']);
        
        $bloodRequest->load(['user', 'donations.donor']);
        
        // Get potential donors (users) with matching blood type and last donation >= 3 months ago or never donated
        $threeMonthsAgo = now()->subMonths(3);
        $potentialDonors = User::where('blood_group', $bloodRequest->blood_type)
            ->whereDoesntHave('donations', function($query) use ($bloodRequest) {
                $query->where('blood_request_id', $bloodRequest->id);
            })
            ->where(function($query) use ($threeMonthsAgo) {
                $query->whereDoesntHave('donations')
                      ->orWhereHas('donations', function($q) use ($threeMonthsAgo) {
                          $q->where(function($subQ) use ($threeMonthsAgo) {
                              $subQ->whereNull('donation_date')
                                   ->orWhere('donation_date', '<=', $threeMonthsAgo);
                          });
                      });
            })
            ->with(['donations' => function($q) {
                $q->orderByDesc('donation_date');
            }])
            ->get();
        
        return view('backend.pages.blood-requests.show', compact('bloodRequest', 'potentialDonors'));
    }

    /**
     * Assign a donor to a blood request.
     */
    public function assignDonor(Request $request, BloodRequest $bloodRequest): RedirectResponse|JsonResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['blood.request.edit']);
        
        // Handle AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $validated = $request->validate([
                    'donor_id' => 'required|exists:users,id',
                ]);

                // Check if we haven't exceeded the units needed
                $currentDonations = $bloodRequest->donations()->count();
                if ($currentDonations >= $bloodRequest->units_needed) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum number of donors already assigned'
                    ], 400);
                }

                // Create new donation record
                $donation = BloodDonation::create([
                    'donor_id' => $request->donor_id,
                    'blood_request_id' => $bloodRequest->id,
                    'status' => 'pending'
                ]);

                // Update blood request status if this is the first donor
                if ($bloodRequest->status === 'pending') {
                    $bloodRequest->update(['status' => 'approved']);
                }

                // Check if we've assigned all needed donors
                if (($currentDonations + 1) >= $bloodRequest->units_needed) {
                    $bloodRequest->update(['status' => 'completed']);
                }

                // Send email notifications
                try {
                    // Get the donor and requester
                    $donor = User::findOrFail($request->donor_id);
                    $requester = $bloodRequest->user;
                    
                    // Send email to donor
                    if ($donor && $donor->email) {
                        try {
                            Mail::to($donor->email)->send(new DonorAssignmentNotification($donation, true));
                            Log::info('Donor notification email sent successfully', [
                                'donor_id' => $donor->id,
                                'blood_request_id' => $bloodRequest->id
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Failed to send donor notification email', [
                                'error' => $e->getMessage(),
                                'donor_id' => $donor->id,
                                'blood_request_id' => $bloodRequest->id
                            ]);
                        }
                    }
                    
                    // Send email to requester
                    if ($requester && $requester->email) {
                        try {
                            Mail::to($requester->email)->send(new DonorAssignmentNotification($donation, false));
                            Log::info('Requester notification email sent successfully', [
                                'requester_id' => $requester->id,
                                'blood_request_id' => $bloodRequest->id
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Failed to send requester notification email', [
                                'error' => $e->getMessage(),
                                'requester_id' => $requester->id,
                                'blood_request_id' => $bloodRequest->id
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    // Log the error but don't stop the process
                    Log::error('Failed to send donor assignment notification emails', [
                        'error' => $e->getMessage(),
                        'donor_id' => $request->donor_id,
                        'blood_request_id' => $bloodRequest->id
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Donor assigned successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error assigning donor: ' . $e->getMessage()
                ], 500);
            }
        }
        
        // Handle regular form submissions
        $request->validate([
            'donor_id' => 'required|exists:users,id',
        ]);

        // Check if we haven't exceeded the units needed
        $currentDonations = $bloodRequest->donations()->count();
        if ($currentDonations >= $bloodRequest->units_needed) {
            return back()->with('error', 'Maximum number of donors already assigned');
        }

        // Create new donation record
        $donation = BloodDonation::create([
            'donor_id' => $request->donor_id,
            'blood_request_id' => $bloodRequest->id,
            'status' => 'pending'
        ]);

        // Update blood request status if this is the first donor
        if ($bloodRequest->status === 'pending') {
            $bloodRequest->update(['status' => 'approved']);
        }

        // Check if we've assigned all needed donors
        if (($currentDonations + 1) >= $bloodRequest->units_needed) {
            $bloodRequest->update(['status' => 'completed']);
        }

        // Send email notifications
        try {
            // Get the donor and requester
            $donor = User::findOrFail($request->donor_id);
            $requester = $bloodRequest->user;
            
            // Send email to donor
            if ($donor && $donor->email) {
                try {
                    Mail::to($donor->email)->send(new DonorAssignmentNotification($donation, true));
                    Log::info('Donor notification email sent successfully', [
                        'donor_id' => $donor->id,
                        'blood_request_id' => $bloodRequest->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send donor notification email', [
                        'error' => $e->getMessage(),
                        'donor_id' => $donor->id,
                        'blood_request_id' => $bloodRequest->id
                    ]);
                }
            }
            
            // Send email to requester
            if ($requester && $requester->email) {
                try {
                    Mail::to($requester->email)->send(new DonorAssignmentNotification($donation, false));
                    Log::info('Requester notification email sent successfully', [
                        'requester_id' => $requester->id,
                        'blood_request_id' => $bloodRequest->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send requester notification email', [
                        'error' => $e->getMessage(),
                        'requester_id' => $requester->id,
                        'blood_request_id' => $bloodRequest->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't stop the process
            Log::error('Failed to send donor assignment notification emails', [
                'error' => $e->getMessage(),
                'donor_id' => $request->donor_id,
                'blood_request_id' => $bloodRequest->id
            ]);
        }

        return back()->with('success', 'Donor assigned successfully');
    }

    public function removeDonor(BloodRequest $bloodRequest, BloodDonation $donation): RedirectResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['blood.request.edit']);
        
        if ($donation->blood_request_id !== $bloodRequest->id) {
            return back()->with('error', 'Invalid donation record');
        }

        $donation->delete();

        // Update blood request status if needed
        if ($bloodRequest->donations()->count() === 0) {
            $bloodRequest->update(['status' => 'pending']);
        } else {
            $bloodRequest->update(['status' => 'approved']);
        }

        return back()->with('success', 'Donor removed successfully');
    }

    /**
     * Update the status of a blood request.
     */
    public function updateStatus(Request $request, BloodRequest $bloodRequest): RedirectResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['blood.request.edit']);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed,cancel',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500'
        ]);

        $data = ['status' => $request->status];
        
        if ($request->status === 'rejected') {
            $data['rejection_reason'] = $request->rejection_reason;
        }

        $bloodRequest->update($data);

        $statusMessages = [
            'pending' => 'Blood request marked as pending',
            'approved' => 'Blood request approved successfully',
            'rejected' => 'Blood request rejected successfully',
            'completed' => 'Blood request marked as completed',
            'cancel' => 'Blood request cancelled successfully'
        ];

        return back()->with('success', $statusMessages[$request->status] ?? 'Status updated successfully');
    }

    public function assignDonorPage(BloodRequest $bloodRequest, Request $request): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['blood.request.edit']);
        $bloodRequest->load(['user', 'donations.donor']);

        $divisions = Division::all();
        $districts = District::all();
        $upazilas = Upazila::all();

        $divisionId = $request->input('division_id');
        $districtId = $request->input('district_id');
        $upazilaId = $request->input('upazila_id');

        $threeMonthsAgo = now()->subMonths(3);

        $potentialDonorsQuery = User::where('blood_group', $bloodRequest->blood_type)
            ->whereDoesntHave('donations', function($query) use ($bloodRequest) {
                $query->where('blood_request_id', $bloodRequest->id);
            })
            ->where(function($query) use ($threeMonthsAgo) {
                $query->whereDoesntHave('donations')
                      ->orWhereHas('donations', function($q) use ($threeMonthsAgo) {
                          $q->where(function($subQ) use ($threeMonthsAgo) {
                              $subQ->whereNull('donation_date')
                                   ->orWhere('donation_date', '<=', $threeMonthsAgo);
                          });
                      });
            });

        // Add search filter for name or phone
        if ($request->filled('search')) {
            $potentialDonorsQuery->where(function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($divisionId) {
            $potentialDonorsQuery->whereHas('presentLocation', function($query) use ($divisionId) {
                $query->where('division_id', $divisionId);
            });
        }
        if ($districtId) {
            $potentialDonorsQuery->whereHas('presentLocation', function($query) use ($districtId) {
                $query->where('district_id', $districtId);
            });
        }
        if ($upazilaId) {
            $potentialDonorsQuery->whereHas('presentLocation', function($query) use ($upazilaId) {
                $query->where('upazila_id', $upazilaId);
            });
        }

        $potentialDonors = $potentialDonorsQuery
            ->with(['donations' => function($q) {
                $q->orderByDesc('donation_date');
            }, 'presentLocation.division', 'presentLocation.district', 'presentLocation.upazila'])
            ->get();

        return view('backend.pages.blood-requests.assign-donor', compact(
            'bloodRequest', 'potentialDonors', 'divisions', 'districts', 'upazilas', 'divisionId', 'districtId', 'upazilaId'
        ));
    }

    /**
     * API endpoint to get potential donors for quick assign feature
     */
    public function getPotentialDonors(Request $request): JsonResponse
    {
        try {
            // Check authentication first
            if (!auth('admin')->check()) {
                Log::warning('Unauthenticated access to getPotentialDonors API');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login again.'
                ], 401);
            }
            
            $this->checkAuthorization(auth('admin')->user(), ['blood.request.edit']);

            // Validate the request
            $validated = $request->validate([
                'blood_type' => 'required|string',
                'request_id' => 'required|exists:blood_requests,id'
            ]);

            // Find the blood request with location details
            $bloodRequest = BloodRequest::with(['division', 'district', 'upazila'])->findOrFail($request->request_id);
            $threeMonthsAgo = now()->subMonths(3);

            // Select required columns
            $selectColumns = ['id', 'name', 'phone', 'blood_group', 'last_donation_date'];

            // We'll get location data through relationships

            // Find eligible donors using a simpler approach without complex joins
            $query = User::where('blood_group', $request->blood_type)
                ->where('is_donor', true)
                ->whereDoesntHave('donations', function($query) use ($bloodRequest) {
                    $query->where('blood_request_id', $bloodRequest->id);
                })
                ->where(function($query) use ($threeMonthsAgo) {
                    $query->whereDoesntHave('donations')
                          ->orWhereHas('donations', function($q) use ($threeMonthsAgo) {
                              $q->where(function($subQ) use ($threeMonthsAgo) {
                                  $subQ->whereNull('donation_date')
                                       ->orWhere('donation_date', '<=', $threeMonthsAgo);
                              });
                          });
                })
                ->with('presentLocation.division', 'presentLocation.district', 'presentLocation.upazila')
                ->limit(50) // Get more donors than needed to allow for sorting
                ->get();
            
            // Get request location IDs (if available)
            $requestDivisionId = $bloodRequest->division ? $bloodRequest->division->id : null;
            $requestDistrictId = $bloodRequest->district ? $bloodRequest->district->id : null;
            $requestUpazilaId = $bloodRequest->upazila ? $bloodRequest->upazila->id : null;
            
            // Sort donors by location proximity (in PHP instead of SQL)
            $sortedDonors = $query->map(function($donor) use ($requestDivisionId, $requestDistrictId, $requestUpazilaId) {
                // Create the result array with basic info
                $result = [
                    'id' => $donor->id,
                    'name' => $donor->name,
                    'phone' => $donor->phone,
                    'blood_group' => $donor->blood_group,
                    'last_donation_date' => $donor->last_donation_date ? $donor->last_donation_date->format('M d, Y') : null,
                    'location_match' => 0 // Default to no match
                ];
                
                // Calculate location match for sorting
                if ($donor->presentLocation) {
                    // Add location data to result
                    $result['present_division'] = $donor->presentLocation->division ? $donor->presentLocation->division->name : null;
                    $result['present_district'] = $donor->presentLocation->district ? $donor->presentLocation->district->name : null;
                    $result['present_upazila'] = $donor->presentLocation->upazila ? $donor->presentLocation->upazila->name : null;
                    $result['present_address'] = $donor->presentLocation->address;
                    
                    // Calculate priority score
                    if ($requestUpazilaId && $donor->presentLocation->upazila_id == $requestUpazilaId) {
                        $result['location_match'] = 3; // Same upazila (highest match)
                        $result['sort_priority'] = 1;
                    } else if ($requestDistrictId && $donor->presentLocation->district_id == $requestDistrictId) {
                        $result['location_match'] = 2; // Same district
                        $result['sort_priority'] = 2;
                    } else if ($requestDivisionId && $donor->presentLocation->division_id == $requestDivisionId) {
                        $result['location_match'] = 1; // Same division
                        $result['sort_priority'] = 3;
                    } else {
                        $result['sort_priority'] = 4;
                    }
                } else {
                    // Fallback to accessor methods if location relationship doesn't exist
                    $result['present_division'] = $donor->getPresentDivisionAttribute();
                    $result['present_district'] = $donor->getPresentDistrictAttribute();
                    $result['present_upazila'] = $donor->getPresentSubDistrictAttribute();
                    $result['present_address'] = $donor->getPresentAddressAttribute();
                    $result['sort_priority'] = 4;
                }
                
                return $result;
            })
            ->sortBy('sort_priority') // Sort by our calculated priority
            ->take(20)  // Limit to 20 donors
            ->values();  // Re-index array
            
            $donors = $sortedDonors;

            return response()->json([
                'success' => true,
                'donors' => $donors
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Log::error('Authorization error in getPotentialDonors: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in getPotentialDonors: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . collect($e->errors())->first()[0],
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error loading potential donors: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading donors: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint to get nearby hospital requests for quick assign feature
     */
    public function getNearbyHospitalRequests(Request $request): JsonResponse
    {
        try {
            // Check authentication first
            if (!auth('admin')->check()) {
                Log::warning('Unauthenticated access to getNearbyHospitalRequests API');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login again.'
                ], 401);
            }
            
            $this->checkAuthorization(auth('admin')->user(), ['blood.request.view']);

            // Validate the request
            $validated = $request->validate([
                'blood_type' => 'required|string',
                'current_request_id' => 'required|exists:blood_requests,id'
            ]);

            $currentRequest = BloodRequest::findOrFail($request->current_request_id);
            
            // Get the current hospital location (district and division)
            $hospitalDistrict = $currentRequest->district ? $currentRequest->district->id : null;
            $hospitalDivision = $currentRequest->division ? $currentRequest->division->id : null;
            
            // Find other pending or approved blood requests with the same blood type
            // that are not completely filled (donations < units_needed)
            $query = BloodRequest::where('id', '!=', $currentRequest->id)
                ->where('blood_type', $request->blood_type)
                ->whereIn('status', ['pending', 'approved'])
                ->whereRaw('(SELECT COUNT(*) FROM blood_donations WHERE blood_request_id = blood_requests.id) < blood_requests.units_needed')
                ->with(['user', 'division', 'district', 'upazila', 'donations']);
                
            // Get the requests
            $requests = $query->latest()->take(20)->get();
            
            // Calculate "distance" based on location similarity
            $requests = $requests->map(function($request) use ($hospitalDistrict, $hospitalDivision) {
                // Basic distance calculation - this should be enhanced with actual coordinates
                // if available in the database
                $distance = 0;
                
                // If in same district, very close
                if ($hospitalDistrict && $request->hospital_district_id == $hospitalDistrict) {
                    $distance = rand(1, 5); // 1-5 km if in same district
                } 
                // If in same division but different district, farther
                else if ($hospitalDivision && $request->hospital_division_id == $hospitalDivision) {
                    $distance = rand(5, 20); // 5-20 km if in same division
                } 
                // Otherwise, quite far
                else {
                    $distance = rand(20, 50); // 20-50 km if in different division
                }
                
                // Add the distance to the request
                $request->distance = $distance;
                
                // Format the donation count
                $request->donations_count = $request->donations->count();
                
                // Format the needed date
                $request->needed_date = $request->needed_date ? $request->needed_date->format('M d, Y') : null;
                
                return $request;
            });
            
            return response()->json([
                'success' => true,
                'requests' => $requests
            ]);
            
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Log::error('Authorization error in getNearbyHospitalRequests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in getNearbyHospitalRequests: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . collect($e->errors())->first()[0],
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error loading nearby hospital requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading nearby hospital requests: ' . $e->getMessage()
            ], 500);
        }
    }
} 