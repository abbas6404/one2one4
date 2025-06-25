<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class BloodRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bloodRequests = BloodRequest::where('user_id', $user->id)
                                    ->with('user')
                                    ->latest()
                                    ->paginate(10);
                                    
        return view('frontend.blood-requests.index', compact('bloodRequests'));
    }

    public function create()
    {
        return view('frontend.blood-requests.create');
    }

    public function store(Request $request)
    {
        // Basic field validation
        $baseValidation = [
            'blood_type' => 'required|string',
            'units_needed' => 'required|integer|min:1|max:5',
            'urgency_level' => 'required|in:normal,urgent',
            'hospital_name' => 'required|string|max:255',
            'hospital_division_id' => 'required|exists:divisions,id',
            'hospital_district_id' => 'required|exists:districts,id',
            'hospital_upazila_id' => 'required|exists:upazilas,id',
            'hospital_address' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ];
        
        // Get today's date using Carbon with the app's timezone
        $today = Carbon::now()->startOfDay();
        $tomorrow = Carbon::now()->addDay()->startOfDay();
        
        // Dynamic date validation based on urgency
        if ($request->input('urgency_level') === 'urgent') {
            $baseValidation['needed_date'] = 'nullable|date|after_or_equal:'.$today->format('Y-m-d');
        } else {
            $baseValidation['needed_date'] = 'nullable|date|after:'.$today->format('Y-m-d');
        }

        $validated = $request->validate($baseValidation);

        // Handle needed_date with proper timezone
        if (!empty($validated['needed_date'])) {
            $needed_date = Carbon::parse($validated['needed_date'], config('app.timezone'))->startOfDay();
            $validated['needed_date'] = $needed_date->format('Y-m-d');
        }

        $user = Auth::user();
        $bloodRequest = BloodRequest::create([
            'user_id' => $user->id,
            'status' => 'pending',
            ...$validated
        ]);

        return redirect()->route('user.blood-requests.index')
                        ->with('success', 'Blood request created successfully.');
    }

    public function show(BloodRequest $bloodRequest)
    {
        $user = Auth::user();
        if ($bloodRequest->user_id !== $user->id) {
            return redirect()->route('user.blood-requests.index')
                ->with('error', 'You are not authorized to view this request.');
        }
        return view('frontend.blood-requests.show', compact('bloodRequest'));
    }

    public function edit(BloodRequest $bloodRequest)
    {
        $user = Auth::user();
        if ($bloodRequest->user_id !== $user->id) {
            return redirect()->route('user.blood-requests.index')
                ->with('error', 'You are not authorized to edit this request.');
        }
        return view('frontend.blood-requests.edit', compact('bloodRequest'));
    }

    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $user = Auth::user();
        if ($bloodRequest->user_id !== $user->id) {
            return redirect()->route('user.blood-requests.index')
                ->with('error', 'You are not authorized to update this request.');
        }

        // Basic field validation
        $baseValidation = [
            'blood_type' => 'required|string',
            'units_needed' => 'required|integer|min:1|max:5',
            'urgency_level' => 'required|in:normal,urgent',
            'hospital_name' => 'required|string|max:255',
            'hospital_division_id' => 'required|exists:divisions,id',
            'hospital_district_id' => 'required|exists:districts,id',
            'hospital_upazila_id' => 'required|exists:upazilas,id',
            'hospital_address' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ];
        
        // Get today's date using Carbon with the app's timezone
        $today = Carbon::now()->startOfDay();
        $tomorrow = Carbon::now()->addDay()->startOfDay();
        
        // Dynamic date validation based on urgency
        if ($request->input('urgency_level') === 'urgent') {
            $baseValidation['needed_date'] = 'nullable|date|after_or_equal:'.$today->format('Y-m-d');
        } else {
            $baseValidation['needed_date'] = 'nullable|date|after:'.$today->format('Y-m-d');
        }

        $validated = $request->validate($baseValidation);

        // Handle needed_date with proper timezone
        if (!empty($validated['needed_date'])) {
            $needed_date = Carbon::parse($validated['needed_date'], config('app.timezone'))->startOfDay();
            $validated['needed_date'] = $needed_date->format('Y-m-d');
        }

        $bloodRequest->update($validated);

        return redirect()->route('user.blood-requests.index')
                        ->with('success', 'Blood request updated successfully.');
    }

    public function destroy(BloodRequest $bloodRequest)
    {
        $user = Auth::user();
        if ($bloodRequest->user_id !== $user->id) {
            return redirect()->route('user.blood-requests.index')
                ->with('error', 'You are not authorized to cancel this request.');
        }

        if ($bloodRequest->status !== 'pending') {
            return redirect()->route('user.blood-requests.index')
                ->with('error', 'Only pending requests can be cancelled.');
        }

        $bloodRequest->update(['status' => 'cancel']);

        return redirect()->route('user.blood-requests.index')
            ->with('success', 'Blood request has been cancelled successfully.');
    }

    public function viewAssignedDonors(BloodRequest $bloodRequest)
    {
        // Ensure the user can only view their own blood requests
        $user = Auth::user();
        if ($bloodRequest->user_id !== $user->id) {
            return redirect()->route('user.blood-requests.index')
                ->with('error', 'You are not authorized to view this request.');
        }
        
        // Load the blood request with its donations and donors
        $bloodRequest->load(['donations.donor', 'division', 'district', 'upazila']);
        
        return view('frontend.blood-requests.assigned-donors', compact('bloodRequest'));
    }
} 