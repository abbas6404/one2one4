@extends('frontend.layouts.frontend')

@section('title', 'My Donors')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-dark fw-bold mb-0">My Donors</h1>
            <p class="text-muted mb-0">View donors who have been assigned to your blood requests</p>
        </div>
    </div>

    <!-- Donors List Section -->
    <div class="card shadow-sm mb-4 blood-themed-card">
        <div class="card-body p-lg-4 p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($uniqueDonors->count() > 0)
                <div class="row g-4">
                    @foreach($uniqueDonors as $donorData)
                        <div class="col-lg-4 col-md-6">
                            <div class="donor-card h-100">
                                <div class="donor-card-header {{ strtolower($donorData['donor']->blood_group) }}-bg">
                                    <div class="donor-avatar">
                                        @if($donorData['donor']->profile_photo)
                                            <img src="{{ asset('storage/' . $donorData['donor']->profile_photo) }}" alt="Donor">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ substr($donorData['donor']->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="donor-header-content">
                                        <h5 class="donor-name mb-1">{{ $donorData['donor']->name }}</h5>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="blood-badge">{{ $donorData['donor']->blood_group }}</span>
                                            <span class="donor-location">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $donorData['donor']->present_district ?? 'Location not specified' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="donor-card-body">
                                    <div class="donor-details">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="detail-item">
                                                    <div class="detail-label">Donation Date</div>
                                                    <div class="detail-value">
                                                        {{ $donorData['donation']->donation_date ? 
                                                            $donorData['donation']->donation_date->format('M d, Y') : 
                                                            'Not scheduled' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-item">
                                                    <div class="detail-label">Status</div>
                                                    <div class="detail-value">
                                                        @php
                                                            $statusClass = [
                                                                'pending' => 'warning',
                                                                'confirmed' => 'info',
                                                                'approved' => 'primary',
                                                                'completed' => 'success',
                                                                'rejected' => 'danger'
                                                            ][$donorData['donation']->status];
                                                        @endphp
                                                        <span class="status-badge status-{{ $statusClass }}">
                                                            {{ ucfirst($donorData['donation']->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="detail-item">
                                                    <div class="detail-label">For Request</div>
                                                    <div class="detail-value">
                                                        {{ $donorData['request']->hospital_name }} - 
                                                        {{ $donorData['request']->blood_type }} Blood
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="detail-item location-detail">
                                                    <div class="detail-label">
                                                        <i class="fas fa-map-marked-alt me-1"></i> Address
                                                    </div>
                                                    <div class="detail-value">
                                                        @if(isset($donorData['donor']->location))
                                                            {{ $donorData['donor']->location->address }}, 
                                                            {{ optional($donorData['donor']->location->upazila)->name }}, 
                                                            {{ optional($donorData['donor']->location->district)->name }}, 
                                                            {{ optional($donorData['donor']->location->division)->name }}
                                                        @elseif(isset($donorData['donor']->presentLocation))
                                                            {{ $donorData['donor']->presentLocation->address }}, 
                                                            {{ optional($donorData['donor']->presentLocation->upazila)->name }}, 
                                                            {{ optional($donorData['donor']->presentLocation->district)->name }}, 
                                                            {{ optional($donorData['donor']->presentLocation->division)->name }}
                                                        @else
                                                            {{ $donorData['donor']->present_address ?? '' }}
                                                            {{ $donorData['donor']->present_upazila ?? '' }}
                                                            {{ !empty($donorData['donor']->present_upazila) && !empty($donorData['donor']->present_district) ? ', ' : '' }}
                                                            {{ $donorData['donor']->present_district ?? '' }}
                                                            {{ !empty($donorData['donor']->present_district) && !empty($donorData['donor']->present_division) ? ', ' : '' }}
                                                            {{ $donorData['donor']->present_division ?? '' }}
                                                            @if(empty($donorData['donor']->present_address) && empty($donorData['donor']->present_district))
                                                                Address not provided
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="detail-item contact-detail">
                                                    <div class="detail-label">
                                                        <i class="fas fa-phone-alt me-1"></i> Phone
                                                    </div>
                                                    <div class="detail-value phone-container">
                                                        <div>{{ $donorData['donor']->phone }}</div>
                                                        <a href="tel:{{ $donorData['donor']->phone }}" class="call-btn" title="Call donor">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="detail-item contact-detail">
                                                    <div class="detail-label">
                                                        <i class="fas fa-envelope me-1"></i> Email
                                                    </div>
                                                    <div class="detail-value email-container">
                                                        <div class="email-text">{{ $donorData['donor']->email }}</div>
                                                        <a href="mailto:{{ $donorData['donor']->email }}" class="mail-btn" title="Email donor">
                                                            <i class="fas fa-envelope"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="donor-actions">
                                        <button type="button" class="btn btn-view-details"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#donorDetailsModal{{ $donorData['donor']->id }}">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Donor Details Modal -->
                        <div class="modal fade" id="donorDetailsModal{{ $donorData['donor']->id }}" tabindex="-1" 
                            aria-labelledby="donorDetailsModalLabel{{ $donorData['donor']->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header donor-modal-header {{ strtolower($donorData['donor']->blood_group) }}-gradient">
                                        <h5 class="modal-title text-white" id="donorDetailsModalLabel{{ $donorData['donor']->id }}">
                                            <i class="fas fa-user-plus me-2"></i>Donor Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row">
                                            <!-- Donor Personal Information -->
                                            <div class="col-md-6 mb-4">
                                                <h6 class="section-title mb-3">Personal Information</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="modal-donor-avatar me-3">
                                                        @if($donorData['donor']->profile_photo)
                                                            <img src="{{ asset('storage/' . $donorData['donor']->profile_photo) }}" 
                                                                 alt="Donor">
                                                        @else
                                                            <div class="avatar-placeholder">
                                                                {{ substr($donorData['donor']->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">{{ $donorData['donor']->name }}</h5>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="blood-badge modal-blood-badge">{{ $donorData['donor']->blood_group }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Email:</div>
                                                        <div class="modal-detail-value">{{ $donorData['donor']->email }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Phone:</div>
                                                        <div class="modal-detail-value">{{ $donorData['donor']->phone }}</div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div class="modal-detail-label">Address:</div>
                                                        <div class="modal-detail-value">
                                                            @if(isset($donorData['donor']->location))
                                                                {{ $donorData['donor']->location->address }}, 
                                                                {{ optional($donorData['donor']->location->upazila)->name }}, 
                                                                {{ optional($donorData['donor']->location->district)->name }}, 
                                                                {{ optional($donorData['donor']->location->division)->name }}
                                                            @elseif(isset($donorData['donor']->presentLocation))
                                                                {{ $donorData['donor']->presentLocation->address }}, 
                                                                {{ optional($donorData['donor']->presentLocation->upazila)->name }}, 
                                                                {{ optional($donorData['donor']->presentLocation->district)->name }}, 
                                                                {{ optional($donorData['donor']->presentLocation->division)->name }}
                                                            @else
                                                                {{ $donorData['donor']->present_address ?? '' }}
                                                                {{ $donorData['donor']->present_upazila ?? '' }}
                                                                {{ !empty($donorData['donor']->present_upazila) && !empty($donorData['donor']->present_district) ? ', ' : '' }}
                                                                {{ $donorData['donor']->present_district ?? '' }}
                                                                {{ !empty($donorData['donor']->present_district) && !empty($donorData['donor']->present_division) ? ', ' : '' }}
                                                                {{ $donorData['donor']->present_division ?? '' }}
                                                                @if(empty($donorData['donor']->present_address) && empty($donorData['donor']->present_district))
                                                                    Address not provided
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Donation Information -->
                                            <div class="col-md-6 mb-4">
                                                <h6 class="section-title mb-3">Donation Information</h6>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Status:</div>
                                                        <div>
                                                            <span class="status-badge status-{{ $statusClass }} modal-status">
                                                                {{ ucfirst($donorData['donation']->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Blood Type:</div>
                                                        <div class="modal-detail-value">{{ $donorData['request']->blood_type }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Donation Date:</div>
                                                        <div class="modal-detail-value">
                                                            {{ $donorData['donation']->donation_date ? 
                                                                $donorData['donation']->donation_date->format('M d, Y') : 
                                                                'Not scheduled' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Volume:</div>
                                                        <div class="modal-detail-value">{{ $donorData['donation']->volume ?? '0.45' }} liters</div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div class="modal-detail-label">For Request:</div>
                                                        <div class="modal-detail-value">
                                                            <a href="{{ route('user.blood-requests.show', $donorData['request']->id) }}" 
                                                               class="request-link">
                                                                {{ $donorData['request']->hospital_name }} - 
                                                                {{ $donorData['request']->needed_date ? 
                                                                    $donorData['request']->needed_date->format('M d, Y') : 
                                                                    'No date specified' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @if($donorData['donation']->status === 'rejected')
                                                    <div class="col-12 mb-2">
                                                        <div class="modal-detail-label">Rejection Reason:</div>
                                                        <div class="text-danger">
                                                            {{ $donorData['donation']->rejection_reason ?? 'No reason provided' }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Hospital Information -->
                                            <div class="col-12">
                                                <h6 class="section-title mb-3">Hospital Information</h6>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Hospital Name:</div>
                                                        <div class="modal-detail-value">{{ $donorData['request']->hospital_name }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="modal-detail-label">Needed By:</div>
                                                        <div class="modal-detail-value">
                                                            {{ $donorData['request']->needed_date ? 
                                                                $donorData['request']->needed_date->format('M d, Y') : 
                                                                'No date specified' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="modal-detail-label">Hospital Address:</div>
                                                        <div class="modal-detail-value">{{ $donorData['request']->hospital_address }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="d-flex justify-content-between w-100">
                                            <div>
                                                <a href="tel:{{ $donorData['donor']->phone }}" class="btn btn-call">
                                                    <i class="fas fa-phone me-1"></i> Call Donor
                                                </a>
                                                <a href="mailto:{{ $donorData['donor']->email }}" class="btn btn-email">
                                                    <i class="fas fa-envelope me-1"></i> Email
                                                </a>
                                            </div>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="empty-state-title">No donors assigned yet</h5>
                    <p class="empty-state-description">When donors are assigned to your blood requests, they will appear here.</p>
                    <a href="{{ route('user.blood-requests.index') }}" class="btn btn-primary-blood mt-3">
                        <i class="fas fa-tint me-2"></i>Manage Blood Requests
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --blood-red: #dc3545;
        --blood-dark: #a71d2a;
        --blood-light: #f5c2c7;
        --blood-accent: #FF5C72;
        --blood-positive: #28a745;
        --blood-o-pos: #ff4a4a;
        --blood-o-neg: #ff6b6b;
        --blood-a-pos: #d63384;
        --blood-a-neg: #e83e8c;
        --blood-b-pos: #6f42c1;
        --blood-b-neg: #7952b3;
        --blood-ab-pos: #20c997;
        --blood-ab-neg: #0dcaf0;
    }

    /* Main Card Styles */
    .blood-themed-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Donor Card Styles */
    .donor-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background-color: white;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    .donor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .donor-card-header {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        position: relative;
        color: white;
        z-index: 1;
    }

    .donor-card-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
        opacity: 0.9;
    }

    .donor-header-content {
        flex-grow: 1;
        margin-left: 15px;
    }

    .donor-name {
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
    }

    .donor-location {
        font-size: 0.75rem;
        opacity: 0.85;
        color: white;
    }

    .donor-card-body {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .donor-details {
        flex-grow: 1;
        margin-bottom: 15px;
    }
    
    /* Blood group specific backgrounds */
    .a\+-bg::before {
        background: linear-gradient(135deg, var(--blood-a-pos) 0%, #c03071 100%);
    }
    
    .a\--bg::before {
        background: linear-gradient(135deg, var(--blood-a-neg) 0%, #d5317c 100%);
    }
    
    .b\+-bg::before {
        background: linear-gradient(135deg, var(--blood-b-pos) 0%, #5e35a1 100%);
    }
    
    .b\--bg::before {
        background: linear-gradient(135deg, var(--blood-b-neg) 0%, #6944a9 100%);
    }
    
    .ab\+-bg::before {
        background: linear-gradient(135deg, var(--blood-ab-pos) 0%, #19b385 100%);
    }
    
    .ab\--bg::before {
        background: linear-gradient(135deg, var(--blood-ab-neg) 0%, #09b6d4 100%);
    }
    
    .o\+-bg::before {
        background: linear-gradient(135deg, var(--blood-o-pos) 0%, #e03c3c 100%);
    }
    
    .o\--bg::before {
        background: linear-gradient(135deg, var(--blood-o-neg) 0%, #e05e5e 100%);
    }

    /* Blood type gradient for modals */
    .a\+-gradient {
        background: linear-gradient(135deg, var(--blood-a-pos) 0%, #c03071 100%);
    }
    
    .a\--gradient {
        background: linear-gradient(135deg, var(--blood-a-neg) 0%, #d5317c 100%);
    }
    
    .b\+-gradient {
        background: linear-gradient(135deg, var(--blood-b-pos) 0%, #5e35a1 100%);
    }
    
    .b\--gradient {
        background: linear-gradient(135deg, var(--blood-b-neg) 0%, #6944a9 100%);
    }
    
    .ab\+-gradient {
        background: linear-gradient(135deg, var(--blood-ab-pos) 0%, #19b385 100%);
    }
    
    .ab\--gradient {
        background: linear-gradient(135deg, var(--blood-ab-neg) 0%, #09b6d4 100%);
    }
    
    .o\+-gradient {
        background: linear-gradient(135deg, var(--blood-o-pos) 0%, #e03c3c 100%);
    }
    
    .o\--gradient {
        background: linear-gradient(135deg, var(--blood-o-neg) 0%, #e05e5e 100%);
    }

    /* Fallback for unknown blood types */
    [class$="-bg"]::before {
        background: linear-gradient(135deg, var(--blood-red) 0%, var(--blood-dark) 100%);
    }
    
    /* Avatar Styles */
    .donor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
    }
    
    .donor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
    }
    
    /* Blood Badge */
    .blood-badge {
        background-color: rgba(255, 255, 255, 0.25);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        line-height: 1;
    }
    
    /* Detail Items */
    .detail-item {
        background-color: #f8f9fa;
        padding: 12px;
        border-radius: 10px;
        height: 100%;
        margin-bottom: 10px;
        transition: all 0.2s ease;
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .detail-item:hover {
        background-color: #f2f2f2;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    }
    
    .detail-label {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        font-weight: 500;
        font-size: 0.9rem;
        word-break: break-word;
        color: #343a40;
    }
    
    /* Status badges */
    .status-badge {
        font-size: 0.75rem;
        padding: 3px 10px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .status-info {
        background-color: #0dcaf0;
        color: #fff;
    }
    
    .status-primary {
        background-color: #0d6efd;
        color: #fff;
    }
    
    .status-success {
        background-color: #28a745;
        color: #fff;
    }
    
    .status-danger {
        background-color: #dc3545;
        color: #fff;
    }
    
    /* Special styling for location and contact details */
    .location-detail {
        background-color: #f2f7ff;
    }
    
    .contact-detail {
        background-color: #f7f2ff;
    }
    
    /* Contact buttons styling */
    .phone-container, 
    .email-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .email-text {
        max-width: 75%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .call-btn, .mail-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        flex-shrink: 0;
        transition: all 0.2s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border: none;
    }
    
    .call-btn {
        background-color: #28a745;
    }
    
    .mail-btn {
        background-color: #0dcaf0;
    }
    
    .call-btn:hover, .mail-btn:hover {
        transform: scale(1.1);
    }
    
    /* View details button */
    .btn-view-details {
        background: linear-gradient(135deg, var(--blood-red) 0%, var(--blood-dark) 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
    }
    
    .btn-view-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.4);
    }
    
    /* Empty state styling */
    .empty-state-icon {
        background: linear-gradient(135deg, var(--blood-red) 0%, var(--blood-dark) 100%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
        position: relative;
    }
    
    .empty-state-icon::after {
        content: "";
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0) 70%);
        z-index: -1;
    }
    
    .empty-state-title {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 0.5rem;
    }
    
    .empty-state-description {
        color: #6c757d;
        max-width: 400px;
        margin: 0 auto;
    }
    
    .btn-primary-blood {
        background: linear-gradient(135deg, var(--blood-red) 0%, var(--blood-dark) 100%);
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary-blood:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
    
    /* Modal styling */
    .donor-modal-header {
        border: none;
        color: white;
        padding: 1.25rem;
    }
    
    .modal-donor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        background-color: #f1f1f1;
        border: 3px solid white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .modal-donor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .modal-blood-badge {
        background-color: white;
        color: var(--blood-red);
        padding: 4px 10px;
        font-size: 0.8rem;
    }
    
    .modal-status {
        padding: 4px 12px;
        font-size: 0.8rem;
    }
    
    .section-title {
        color: var(--blood-red);
        font-weight: 600;
        position: relative;
        padding-bottom: 8px;
        margin-bottom: 16px;
    }
    
    .section-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: linear-gradient(90deg, var(--blood-red), rgba(220, 53, 69, 0.2));
        border-radius: 2px;
    }
    
    .modal-detail-label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 3px;
        font-weight: 500;
    }
    
    .modal-detail-value {
        font-weight: 500;
        color: #343a40;
    }
    
    .request-link {
        color: var(--blood-red);
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .request-link:hover {
        color: var(--blood-dark);
        text-decoration: underline;
    }
    
    /* Modal Footer Buttons */
    .btn-call, .btn-email {
        border: none;
        padding: 7px 14px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-call {
        background-color: #28a745;
        color: white;
        margin-right: 8px;
    }
    
    .btn-email {
        background-color: #0dcaf0;
        color: white;
    }
    
    .btn-call:hover, .btn-email:hover {
        opacity: 0.9;
        color: white;
    }
    
    /* Mobile specific adjustments */
    @media (max-width: 576px) {
        .donor-details .row {
            margin-right: -5px;
            margin-left: -5px;
        }
        
        .donor-details [class*="col-"] {
            padding-right: 5px;
            padding-left: 5px;
        }
        
        .detail-item {
            padding: 10px;
            margin-bottom: 8px;
        }
        
        .detail-label {
            font-size: 0.7rem;
        }
        
        .detail-value {
            font-size: 0.85rem;
        }
        
        .donor-avatar {
            width: 50px;
            height: 50px;
        }
        
        .avatar-placeholder {
            font-size: 1.2rem;
        }
        
        .donor-card-header {
            padding: 1rem;
        }
        
        .donor-card-body {
            padding: 1rem;
        }
        
        .donor-name {
            font-size: 1rem;
        }
        
        .donor-location {
            font-size: 0.7rem;
        }
        
        .modal-donor-avatar {
            width: 60px;
            height: 60px;
        }
        
        .call-btn, .mail-btn {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }
        
        .modal-footer {
            flex-direction: column;
            align-items: stretch;
        }
        
        .modal-footer > div {
            margin-bottom: 10px;
        }
    }
</style>
@endpush
@endsection 