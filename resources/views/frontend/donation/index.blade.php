@extends('frontend.layouts.frontend')

@section('title', 'Donation History')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-none d-lg-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Donation History</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
            @if($stats['is_eligible'])
                <a href="{{ route('user.donation.schedule') }}" class="btn btn-sm btn-danger">
                    <i class="fas fa-tint me-1"></i> Donate Now
                </a>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Donations</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['total_donations'] }}</h2>
                            <small class="opacity-75">Last: {{ $stats['last_donation'] }}</small>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-tint fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Volume</h6>
                            <h2 class="mt-2 mb-0">{{ number_format($stats['total_volume'], 1) }}L</h2>
                            <small class="opacity-75">450ml per donation</small>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-flask fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card {{ $stats['is_eligible'] ? 'bg-success' : 'bg-warning' }} text-white shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Next Eligible</h6>
                            <h2 class="mt-2 mb-0">
                                @if($stats['is_eligible'])
                                    Now
                                @else
                                    {{ (int)$stats['days_until_eligible'] }} Days
                                @endif
                            </h2>
                            <small class="opacity-75">3 months between donations</small>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Lives Saved</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['lives_saved'] }}</h2>
                            <small class="opacity-75">3 lives per donation</small>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Donation History with Recipients -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Donation History</h5>
                </div>
                
                <!-- Table view for desktop -->
                <div class="card-body p-0 d-none d-lg-block">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Recipient</th>
                                    <th>Blood Group</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($donations as $donation)
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">#{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ Carbon\Carbon::parse($donation->donation_date)->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            @if($donation->bloodRequest)
                                                <div class="fw-bold">{{ $donation->bloodRequest->hospital_name }}</div>
                                                <small class="text-muted">
                                                    {{ $donation->bloodRequest->hospital_address }}
                                                    @if($donation->bloodRequest->hospital_upazila_id || $donation->bloodRequest->hospital_district_id || $donation->bloodRequest->hospital_division_id)
                                                    <br>
                                                    @if($donation->bloodRequest->upazila)
                                                        {{ $donation->bloodRequest->upazila->name }},
                                                    @endif
                                                    @if($donation->bloodRequest->district)
                                                        {{ $donation->bloodRequest->district->name }},
                                                    @endif
                                                    @if($donation->bloodRequest->division)
                                                        {{ $donation->bloodRequest->division->name }}
                                                    @endif
                                                    @endif
                                                </small>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($donation->bloodRequest && $donation->bloodRequest->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @if($donation->bloodRequest->user->profile_picture)
                                                            <img src="{{ asset('storage/profile_pictures/' . $donation->bloodRequest->user->profile_picture) }}" 
                                                                 alt="Profile Picture" 
                                                                 class="rounded-circle"
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" 
                                                                 style="width: 32px; height: 32px;">
                                                                {{ strtoupper(substr($donation->bloodRequest->user->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <div class="fw-bold">{{ $donation->bloodRequest->user->name }}</div>
                                                        <small class="text-muted">{{ $donation->bloodRequest->user->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-tint me-1"></i> 
                                                @if($donation->bloodRequest)
                                                    {{ $donation->bloodRequest->blood_type }}
                                                @elseif($donation->recipient)
                                                    {{ $donation->recipient->blood_group }}
                                                @else
                                                    {{ $user->blood_group }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $donation->status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#donationDetailsModal{{ $donation->id }}">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-0">No donations recorded yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Card view for mobile -->
                <div class="card-body d-block d-lg-none">
                    @forelse($donations as $donation)
                        <div class="donation-card mb-3 border rounded p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-secondary">#{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="badge bg-{{ $donation->status === 'completed' ? 'success' : ($donation->status === 'rejected' ? 'danger' : ($donation->status === 'approved' ? 'warning' : 'info')) }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </div>
                            
                            <div class="mb-2">
                                <div class="fw-bold">{{ Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}</div>
                                <small class="text-muted">{{ Carbon\Carbon::parse($donation->donation_date)->format('h:i A') }}</small>
                            </div>
                            
                            <div class="mb-2">
                                <div class="text-muted small">Location:</div>
                                @if($donation->bloodRequest)
                                    <div class="fw-bold">{{ $donation->bloodRequest->hospital_name }}</div>
                                    <small class="text-muted">
                                        {{ $donation->bloodRequest->hospital_address }}
                                        @if($donation->bloodRequest->hospital_upazila_id || $donation->bloodRequest->hospital_district_id || $donation->bloodRequest->hospital_division_id)
                                        <br>
                                        @if($donation->bloodRequest->upazila)
                                            {{ $donation->bloodRequest->upazila->name }},
                                        @endif
                                        @if($donation->bloodRequest->district)
                                            {{ $donation->bloodRequest->district->name }},
                                        @endif
                                        @if($donation->bloodRequest->division)
                                            {{ $donation->bloodRequest->division->name }}
                                        @endif
                                        @endif
                                    </small>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <div class="text-muted small">Recipient:</div>
                                @if($donation->bloodRequest && $donation->bloodRequest->user)
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($donation->bloodRequest->user->profile_picture)
                                                <img src="{{ asset('storage/profile_pictures/' . $donation->bloodRequest->user->profile_picture) }}" 
                                                     alt="Profile Picture" 
                                                     class="rounded-circle"
                                                     style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" 
                                                     style="width: 32px; height: 32px;">
                                                    {{ strtoupper(substr($donation->bloodRequest->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <div class="fw-bold">{{ $donation->bloodRequest->user->name }}</div>
                                            <small class="text-muted">{{ $donation->bloodRequest->user->email }}</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </div>
                            
                            <div class="mb-3 d-flex align-items-center">
                                <div class="text-muted small me-2">Blood Group:</div>
                                <span class="badge bg-danger">
                                    <i class="fas fa-tint me-1"></i> 
                                    @if($donation->bloodRequest)
                                        {{ $donation->bloodRequest->blood_type }}
                                    @elseif($donation->recipient)
                                        {{ $donation->recipient->blood_group }}
                                    @else
                                        {{ $user->blood_group }}
                                    @endif
                                </span>
                            </div>
                            
                            <div class="text-center">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary w-100" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#donationDetailsModal{{ $donation->id }}">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No donations recorded yet.</p>
                        </div>
                    @endforelse
                </div>
                
                @if($donations->hasPages())
                    <div class="card-footer bg-white">
                        {{ $donations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Donation Details Modal -->
@foreach($donations as $donation)
<div class="modal fade" id="donationDetailsModal{{ $donation->id }}" tabindex="-1" aria-labelledby="donationDetailsModalLabel{{ $donation->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donationDetailsModalLabel{{ $donation->id }}">
                    Donation #{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }} - {{ Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Recipient Details -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Recipient Information</h6>
                        @if($donation->bloodRequest && $donation->bloodRequest->user)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    @if($donation->bloodRequest->user->profile_picture)
                                        <img src="{{ asset('storage/profile_pictures/' . $donation->bloodRequest->user->profile_picture) }}" 
                                             alt="Profile Picture" 
                                             class="rounded-circle"
                                             style="width: 64px; height: 64px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" 
                                             style="width: 64px; height: 64px;">
                                            {{ strtoupper(substr($donation->bloodRequest->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{ $donation->bloodRequest->user->name }}</h5>
                                    <p class="mb-1 text-muted">{{ $donation->bloodRequest->user->email }}</p>
                                    <p class="mb-0 text-muted">{{ $donation->bloodRequest->user->phone }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-2">Contact Information</h6>
                                <p class="mb-1"><strong>Phone:</strong> {{ $donation->bloodRequest->user->phone }}</p>
                                <p class="mb-1"><strong>Address:</strong> {{ $donation->bloodRequest->user->present_address }}</p>
                            </div>
                        @else
                            <p class="text-muted">No recipient information available.</p>
                        @endif
                    </div>

                    <!-- Hospital Details -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Hospital Information</h6>
                        @if($donation->bloodRequest)
                            <div class="mb-3">
                                <h5 class="mb-2">{{ $donation->bloodRequest->hospital_name }}</h5>
                                <p class="mb-1"><strong>Address:</strong> {{ $donation->bloodRequest->hospital_address }}</p>
                                @if($donation->bloodRequest->hospital_upazila_id || $donation->bloodRequest->hospital_district_id || $donation->bloodRequest->hospital_division_id)
                                <p class="mb-1">
                                    <strong>Location:</strong>
                                    @if($donation->bloodRequest->upazila)
                                        {{ $donation->bloodRequest->upazila->name }},
                                    @endif
                                    @if($donation->bloodRequest->district)
                                        {{ $donation->bloodRequest->district->name }},
                                    @endif
                                    @if($donation->bloodRequest->division)
                                        {{ $donation->bloodRequest->division->name }}
                                    @endif
                                </p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-2">Request Details</h6>
                                <p class="mb-1"><strong>Blood Type:</strong> {{ $donation->bloodRequest->blood_type }}</p>
                                <p class="mb-1"><strong>Units Needed:</strong> {{ $donation->bloodRequest->units_needed }}</p>
                                <p class="mb-1"><strong>Urgency:</strong> 
                                    <span class="badge bg-{{ $donation->bloodRequest->urgency_level === 'critical' ? 'danger' : ($donation->bloodRequest->urgency_level === 'high' ? 'warning' : 'info') }}">
                                        {{ ucfirst($donation->bloodRequest->urgency_level) }}
                                    </span>
                                </p>
                                @if($donation->bloodRequest->needed_date)
                                    <p class="mb-1"><strong>Needed By:</strong> {{ Carbon\Carbon::parse($donation->bloodRequest->needed_date)->format('M d, Y') }}</p>
                                @endif
                            </div>
                        @else
                            <p class="text-muted">No hospital information available.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('styles')
<style>
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border: none;
    border-radius: 10px;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.bg-danger {
    background-color: #dc3545 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.table > :not(caption) > * > * {
    padding: 1rem;
}

.pagination {
    margin-bottom: 0;
    justify-content: center;
}

.modal-content {
    border-radius: 10px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid #eee;
}

.modal-footer {
    border-top: 1px solid #eee;
}

/* Mobile Donation Card Styles */
.donation-card {
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border-radius: 10px;
    transition: transform 0.2s;
}

.donation-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

@media (max-width: 767px) {
    .donation-card .badge {
        font-size: 0.7rem;
    }
}
</style>
@endpush
@endsection 