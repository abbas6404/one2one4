<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BloodDonationController extends Controller
{
    public function index(): View
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.view']);
        
        $bloodDonations = BloodDonation::with(['donor', 'bloodRequest'])
            ->latest()
            ->get();
            
        return view('backend.pages.blood-donations.index', compact('bloodDonations'));
    }

    public function show(BloodDonation $donation): View
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.view']);
        
        $bloodDonation = $donation->load(['donor', 'bloodRequest']);
        
        return view('backend.pages.blood-donations.show', compact('bloodDonation'));
    }

    public function edit(BloodDonation $donation): View
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.edit']);
        
        $bloodDonation = $donation->load(['donor', 'bloodRequest']);
        $bloodRequests = BloodRequest::where('status', '!=', 'completed')->get();
        $donors = User::where('is_donor', true)->get();
        
        return view('backend.pages.blood-donations.edit', compact('bloodDonation', 'bloodRequests', 'donors'));
    }

    public function update(Request $request, BloodDonation $donation): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.edit']);
        
        $request->validate([
            'donor_id' => 'sometimes|required|exists:users,id',
            'blood_request_id' => 'nullable|exists:blood_requests,id',
            'volume' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,completed',
            'rejection_reason' => 'required_if:status,rejected',
            'donation_date' => 'nullable|date'
        ]);

        $data = $request->only([
            'donor_id', 
            'blood_request_id', 
            'volume', 
            'status',
            'donation_date'
        ]);
        
        if ($request->status === 'rejected') {
            $data['rejection_reason'] = $request->rejection_reason;
            
            // If there's an associated blood request, update its status
            if ($donation->bloodRequest) {
                $donation->bloodRequest->update(['status' => 'approved']);
            }
        }
        
        $donation->update($data);

        // Update blood request status if needed
        if ($request->status === 'completed' && $donation->bloodRequest) {
            $this->checkAndCompleteBloodRequest($donation->bloodRequest);
        }

        return redirect()->route('admin.blood_donations.show', $donation)
            ->with('success', 'Blood donation updated successfully');
    }

    public function create(): View
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.create']);
        
        // Only show pending and approved blood requests
        $bloodRequests = BloodRequest::whereIn('status', ['pending', 'approved'])->get();
        $donors = User::where('is_donor', true)->get();
        
        return view('backend.pages.blood-donations.create', compact('bloodRequests', 'donors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.create']);
        
        $request->validate([
            'donor_id' => 'required|exists:users,id',
            'blood_request_id' => 'nullable|exists:blood_requests,id',
            'volume' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,completed',
            'rejection_reason' => 'required_if:status,rejected',
            'donation_date' => 'nullable|date'
        ]);

        $data = $request->only([
            'donor_id', 
            'blood_request_id', 
            'volume', 
            'status',
            'donation_date'
        ]);
        
        if ($request->status === 'rejected') {
            $data['rejection_reason'] = $request->rejection_reason;
        }

        $bloodDonation = BloodDonation::create($data);

        // Update blood request status if needed
        if ($bloodDonation->bloodRequest) {
            $bloodDonation->bloodRequest->update(['status' => 'in_progress']);
        }

        return redirect()->route('admin.blood_donations.index')
            ->with('success', 'Blood donation created successfully');
    }

    public function destroy(BloodDonation $donation): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.delete']);
        
        $donation->delete();
        
        return redirect()->route('admin.blood_donations.index')
            ->with('success', 'Blood donation deleted successfully');
    }

    public function updateStatus(Request $request, BloodDonation $bloodDonation): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['blood.donation.edit']);
        
        $request->validate([
            'status' => 'required|in:pending,completed,cancel',
            'rejection_reason' => 'required_if:status,cancel',
            'donation_date' => 'required_if:status,completed|date'
        ]);

        $bloodDonation->update([
            'status' => $request->status === 'cancel' ? 'rejected' : $request->status,
            'rejection_reason' => $request->status === 'cancel' ? $request->rejection_reason : null,
            'donation_date' => $request->status === 'completed' ? $request->donation_date : null
        ]);

        // Update blood request status if needed
        if ($request->status === 'cancel' && $bloodDonation->bloodRequest) {
            // Update blood request status when donation is rejected/cancelled
            $bloodDonation->bloodRequest->update(['status' => 'approved']);
        } elseif ($request->status === 'completed' && $bloodDonation->bloodRequest) {
            $this->checkAndCompleteBloodRequest($bloodDonation->bloodRequest);
        }

        return back()->with('success', 'Blood donation status updated successfully');
    }

    private function updateBloodRequestStatus(BloodRequest $bloodRequest): void
    {
        // If all donations are cancelled, set request back to pending
        if ($bloodRequest->donations()->where('status', '!=', 'cancel')->count() === 0) {
            $bloodRequest->update(['status' => 'pending']);
        } else {
            $bloodRequest->update(['status' => 'in_progress']);
        }
    }

    private function checkAndCompleteBloodRequest(BloodRequest $bloodRequest): void
    {
        // If all needed donations are completed, mark request as completed
        $completedDonations = $bloodRequest->donations()->where('status', 'completed')->count();
        if ($completedDonations >= $bloodRequest->units_needed) {
            $bloodRequest->update(['status' => 'completed']);
        }
    }
} 