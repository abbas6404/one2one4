@extends('frontend.layouts.frontend')

@section('title', 'Blood Requests')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Blood Requests</h1>
            <p class="text-muted mb-0">Manage your blood donation requests</p>
        </div>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createBloodRequestModal">
            <i class="fas fa-plus me-2"></i>New Request
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-danger mb-0">Pending Requests</h6>
                            <h3 class="mb-0">{{ $bloodRequests->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="icon-circle bg-danger-soft text-danger">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success mb-0">Completed</h6>
                            <h3 class="mb-0">{{ $bloodRequests->where('status', 'completed')->count() }}</h3>
                        </div>
                        <div class="icon-circle bg-success-soft text-success">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info mb-0">In Progress</h6>
                            <h3 class="mb-0">{{ $bloodRequests->where('status', 'approved')->count() }}</h3>
                        </div>
                        <div class="icon-circle bg-info-soft text-info">
                            <i class="fas fa-sync"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card stat-card shadow-sm h-100 border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning mb-0">Total Requests</h6>
                            <h3 class="mb-0">{{ $bloodRequests->count() }}</h3>
                        </div>
                        <div class="icon-circle bg-warning-soft text-warning">
                            <i class="fas fa-tint"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests Section -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($bloodRequests->count() > 0)
                <!-- Blood Requests Card Grid -->
                <div class="row">
                    @foreach($bloodRequests as $request)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="modern-card shadow-sm border-0 h-100" style="min-height: 250px;">
                                <div class="card-body position-relative p-4">
                                    <!-- Top Section with Blood Type and Status -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="blood-type-circle">
                                            {{ $request->blood_type }}
                                        </div>
                                        
                                        @php
                                            $statusClass = $request->status === 'pending' ? 'warning' : 
                                                        ($request->status === 'completed' ? 'success' : 
                                                        ($request->status === 'approved' ? 'info' : 
                                                        ($request->status === 'cancel' ? 'secondary' : 'danger')));
                                            
                                            $statusDisplay = $request->status === 'approved' ? 'Approve' : ucfirst($request->status);
                                        @endphp
                                        
                                        <div class="status-pill bg-{{ $statusClass }}">
                                            {{ $statusDisplay }}
                                        </div>
                                    </div>
                                    
                                    <!-- Hospital and Request ID -->
                                    <h5 class="mb-1">{{ $request->hospital_name }}</h5>
                                    <p class="text-muted mb-4">Request ID: #{{ $request->id }}</p>
                                    
                                    <!-- Information Grid -->
                                    <div class="row mb-4">
                                        <!-- Units Needed -->
                                        <div class="col-6 mb-3">
                                            <div class="info-box">
                                                <span class="info-label">Units Needed</span>
                                                <span class="info-value">{{ $request->units_needed }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Urgency -->
                                        <div class="col-6 mb-3">
                                            <div class="info-box">
                                                <span class="info-label">Urgency</span>
                                                @php
                                                    $urgencyClass = [
                                                        'normal' => 'primary',
                                                        'urgent' => 'danger',
                                                        'low' => 'success',
                                                        'medium' => 'info',
                                                        'high' => 'warning',
                                                        'critical' => 'danger'
                                                    ][$request->urgency_level];
                                                @endphp
                                                <span class="urgency-pill bg-{{ $urgencyClass }}">
                                                    {{ ucfirst($request->urgency_level) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Needed By -->
                                        <div class="col-6 mb-3">
                                            <div class="info-box">
                                                <span class="info-label">Needed By</span>
                                                <span class="info-value">{{ $request->needed_date ? $request->needed_date->format('M d, Y') : 'Not specified' }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Posted -->
                                        <div class="col-6 mb-3">
                                            <div class="info-box">
                                                <span class="info-label">Posted</span>
                                                <span class="info-value">{{ $request->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Assigned Donors Section (only for approved/completed) -->
                                    @if($request->status === 'approved' || $request->status === 'completed')
                                        @if($request->donations && $request->donations->count() > 0)
                                            <div class="assigned-donor-section mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-user-friends text-danger me-2"></i>
                                                    <span class="text-muted">Assigned Donor</span>
                                                </div>
                                                
                                                @foreach($request->donations as $donation)
                                                    <div class="donor-info d-flex align-items-center p-2">
                                                        <div class="donor-avatar me-3">
                                                            @if($donation->donor->profile_photo)
                                                                <img src="{{ asset('storage/' . $donation->donor->profile_photo) }}" alt="Donor">
                                                            @else
                                                                <div class="avatar-placeholder">
                                                                    {{ substr($donation->donor->name, 0, 1) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="donor-details flex-grow-1">
                                                            <div class="donor-name">{{ $donation->donor->name }}</div>
                                                            <div class="donation-date">Donation: {{ $donation->donation_date ? \Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') : 'Not scheduled' }}</div>
                                                        </div>
                                                        <div class="donation-status">
                                                            <span class="status-pill {{ $donation->status === 'completed' ? 'bg-success' : 'bg-info' }}">
                                                                {{ ucfirst($donation->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                    
                                    <!-- Action Buttons -->
                                    <div class="action-buttons text-end">
                                        <button type="button" class="btn btn-action btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewRequestModal{{ $request->id }}"
                                                title="View Details">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        
                                        @if($request->status === 'pending')
                                        <button type="button" 
                                                class="btn btn-action btn-outline-warning" 
                                                title="Edit Request"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal{{ $request->id }}"
                                                data-division-id="{{ $request->hospital_division_id }}"
                                                data-district-id="{{ $request->hospital_district_id }}"
                                                data-upazila-id="{{ $request->hospital_upazila_id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        
                                        <button type="button" 
                                                class="btn btn-action btn-outline-danger" 
                                                title="Cancel Request"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#cancelModal{{ $request->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        @endif
                                        
                                        @if($request->status === 'approved' || $request->status === 'completed')
                                        <a href="{{ route('user.blood-requests.view-donors', $request->id) }}" 
                                           class="btn btn-action btn-outline-info" 
                                           title="View Assigned Donors">
                                            <i class="fas fa-user-friends"></i> Donors
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- View Request Modal -->
                        <div class="modal fade" id="viewRequestModal{{ $request->id }}" tabindex="-1" aria-labelledby="viewRequestModalLabel{{ $request->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="viewRequestModalLabel{{ $request->id }}">
                                            <i class="fas fa-tint me-2"></i>Blood Request Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Blood Information -->
                                            <div class="col-md-6 mb-4">
                                                <h6 class="text-danger mb-3">Blood Information</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-tint text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Blood Type</p>
                                                        <h5 class="mb-0">{{ $request->blood_type }}</h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-box text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Units Needed</p>
                                                        <h5 class="mb-0">{{ $request->units_needed }}</h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-calendar text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Needed By</p>
                                                        <h5 class="mb-0">{{ $request->needed_date ? $request->needed_date->format('M d, Y') : 'Not specified' }}</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Request Status -->
                                            <div class="col-md-6 mb-4">
                                                <h6 class="text-danger mb-3">Request Status</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-info-circle text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Status</p>
                                                        @php
                                                            $statusClass = [
                                                                'pending' => 'warning',
                                                                'approved' => 'info',
                                                                'completed' => 'success',
                                                                'rejected' => 'secondary',
                                                                'cancel' => 'secondary'
                                                            ][$request->status];
                                                        @endphp
                                                        <span class="badge bg-{{ $statusClass }}">
                                                            {{ $request->status === 'approved' ? 'Approve' : ucfirst($request->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-exclamation-circle text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Urgency Level</p>
                                                        @php
                                                            $urgencyClass = [
                                                                'normal' => 'primary',
                                                                'urgent' => 'danger',
                                                                'low' => 'success',
                                                                'medium' => 'info',
                                                                'high' => 'warning',
                                                                'critical' => 'danger'
                                                            ][$request->urgency_level];
                                                        @endphp
                                                        <span class="badge bg-{{ $urgencyClass }}">
                                                            {{ ucfirst($request->urgency_level) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hospital Information -->
                                            <div class="col-12 mb-4">
                                                <h6 class="text-danger mb-3">Hospital Information</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-hospital text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Hospital Name</p>
                                                        <h5 class="mb-0">{{ $request->hospital_name }}</h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-map-marker-alt text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-muted">Hospital Address</p>
                                                        <h5 class="mb-0">{{ $request->hospital_address }}</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Additional Notes -->
                                            @if($request->additional_notes)
                                            <div class="col-12">
                                                <h6 class="text-danger mb-3">Additional Notes</h6>
                                                <div class="d-flex align-items-start">
                                                    <div class="icon-circle bg-danger me-3">
                                                        <i class="fas fa-sticky-note text-white"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0">{{ $request->additional_notes }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="w-100">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-plus me-1"></i>
                                                        Created: {{ $request->created_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-check me-1"></i>
                                                        Updated: {{ $request->updated_at->format('M d, Y h:i A') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('user.blood-requests.edit', $request->id) }}" class="btn btn-warning">
                                                    <i class="fas fa-edit me-2"></i>Edit Request
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $bloodRequests->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tint fa-3x text-danger mb-3"></i>
                    <h5 class="text-muted">No blood requests found</h5>
                    <p class="text-muted">Click the "New Request" button to create your first blood request.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Request Modal -->
<div class="modal fade" id="createBloodRequestModal" tabindex="-1" aria-labelledby="createBloodRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="createBloodRequestModalLabel">
                    <i class="fas fa-tint me-2"></i>Create New Blood Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.blood-requests.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Blood Information -->
                    <div class="row mb-4">
                        <h6 class="text-danger mb-3">Blood Information</h6>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="blood_type" class="form-label">Blood Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type" required>
                                    <option value="">Select Blood Type</option>
                                    <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                    <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                </select>
                                @error('blood_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="units_needed" class="form-label">Units Needed <span class="text-danger">*</span></label>
                                <select class="form-select @error('units_needed') is-invalid @enderror" id="units_needed" name="units_needed" required>
                                    <option value="">Select Units</option>
                                    <option value="1" {{ old('units_needed') == '1' ? 'selected' : '' }}>1 Unit</option>
                                    <option value="2" {{ old('units_needed') == '2' ? 'selected' : '' }}>2 Units</option>
                                    <option value="3" {{ old('units_needed') == '3' ? 'selected' : '' }}>3 Units</option>
                                    <option value="4" {{ old('units_needed') == '4' ? 'selected' : '' }}>4 Units</option>
                                    <option value="5" {{ old('units_needed') == '5' ? 'selected' : '' }}>5 Units</option>
                                </select>
                                @error('units_needed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="needed_date" class="form-label">Needed By Date</label>
                                <input type="date" class="form-control @error('needed_date') is-invalid @enderror" 
                                       id="needed_date" name="needed_date" value="{{ old('needed_date') }}"
                                       min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                <div id="needed_date_help" class="form-text text-muted">
                                    The needed date must be a date after today for normal requests.
                                </div>
                                @error('needed_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Urgency Level -->
                    <div class="row mb-4">
                        <h6 class="text-danger mb-3">Urgency Level</h6>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="d-flex justify-content-between gap-3">
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check urgency-radio" name="urgency_level" id="urgency_normal" 
                                               value="normal" {{ old('urgency_level') == 'normal' ? 'checked' : '' }} checked>
                                        <label class="btn btn-outline-primary w-100" for="urgency_normal">
                                            <i class="fas fa-clock me-2"></i>Normal
                                        </label>
                                    </div>
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check urgency-radio" name="urgency_level" id="urgency_urgent" 
                                               value="urgent" {{ old('urgency_level') == 'urgent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger w-100" for="urgency_urgent">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Urgent
                                        </label>
                                    </div>
                                </div>
                                @error('urgency_level')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Hospital Information -->
                    <div class="row mb-4">
                        <h6 class="text-danger mb-3">Hospital Information</h6>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hospital_name" class="form-label">Hospital Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('hospital_name') is-invalid @enderror" 
                                       id="hospital_name" name="hospital_name" value="{{ old('hospital_name') }}" required>
                                @error('hospital_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="hospital_address" class="form-label">Hospital Address Details <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('hospital_address') is-invalid @enderror" 
                                          id="hospital_address" name="hospital_address" rows="1">{{ old('hospital_address') }}</textarea>
                                <small class="form-text text-muted">Additional address details like building name, room number, etc.</small>
                                @error('hospital_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Location Dropdowns -->
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="hospital_division_id" class="form-label">Division <span class="text-danger">*</span></label>
                                <select class="form-select location-division @error('hospital_division_id') is-invalid @enderror" 
                                        id="hospital_division_id" name="hospital_division_id" required>
                                    <option value="">Select Division</option>
                                </select>
                                @error('hospital_division_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="hospital_district_id" class="form-label">District <span class="text-danger">*</span></label>
                                <select class="form-select location-district @error('hospital_district_id') is-invalid @enderror" 
                                        id="hospital_district_id" name="hospital_district_id" disabled required>
                                    <option value="">Select District</option>
                                </select>
                                @error('hospital_district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="hospital_upazila_id" class="form-label">Upazila <span class="text-danger">*</span></label>
                                <select class="form-select location-upazila @error('hospital_upazila_id') is-invalid @enderror" 
                                        id="hospital_upazila_id" name="hospital_upazila_id" disabled required>
                                    <option value="">Select Upazila</option>
                                </select>
                                @error('hospital_upazila_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="row mb-4">
                        <h6 class="text-danger mb-3">Additional Information</h6>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="additional_notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control @error('additional_notes') is-invalid @enderror" 
                                          id="additional_notes" name="additional_notes" rows="3"
                                          placeholder="Any additional information that might help donors...">{{ old('additional_notes') }}</textarea>
                                @error('additional_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-paper-plane me-2"></i>Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Request Modal -->
@foreach($bloodRequests as $request)
@if($request->status === 'pending')
<div class="modal fade" id="editModal{{ $request->id }}" tabindex="-1" 
     aria-labelledby="editModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editModalLabel{{ $request->id }}">
                    <i class="fas fa-edit me-2"></i>Edit Blood Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.blood-requests.update', $request->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="blood_type" class="form-label">Blood Type <span class="text-danger">*</span></label>
                            <select name="blood_type" id="blood_type" class="form-select" required>
                                <option value="">Select Blood Type</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                    <option value="{{ $type }}" {{ $request->blood_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="units_needed" class="form-label">Units Needed <span class="text-danger">*</span></label>
                            <select class="form-select @error('units_needed') is-invalid @enderror" id="units_needed" name="units_needed" required>
                                <option value="">Select Units</option>
                                <option value="1" {{ $request->units_needed == 1 ? 'selected' : '' }}>1 Unit</option>
                                <option value="2" {{ $request->units_needed == 2 ? 'selected' : '' }}>2 Units</option>
                                <option value="3" {{ $request->units_needed == 3 ? 'selected' : '' }}>3 Units</option>
                                <option value="4" {{ $request->units_needed == 4 ? 'selected' : '' }}>4 Units</option>
                                <option value="5" {{ $request->units_needed == 5 ? 'selected' : '' }}>5 Units</option>
                            </select>
                            @error('units_needed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="urgency_level" class="form-label">Urgency Level <span class="text-danger">*</span></label>
                            <select name="urgency_level" id="urgency_level" class="form-select" required>
                                <option value="">Select Urgency Level</option>
                                @foreach(['normal', 'urgent', 'low', 'medium', 'high', 'critical'] as $level)
                                    <option value="{{ $level }}" {{ $request->urgency_level == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="needed_date" class="form-label">Needed By Date</label>
                            <input type="date" class="form-control" id="needed_date" name="needed_date" value="{{ $request->needed_date ? $request->needed_date->format('Y-m-d') : '' }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <h6 class="text-danger mb-3">Hospital Information</h6>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hospital_name" class="form-label">Hospital Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('hospital_name') is-invalid @enderror" 
                                       id="hospital_name" name="hospital_name" value="{{ $request->hospital_name }}" required>
                                @error('hospital_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="hospital_address" class="form-label">Hospital Address Details <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('hospital_address') is-invalid @enderror" 
                                          id="hospital_address" name="hospital_address" rows="1">{{ $request->hospital_address }}</textarea>
                                <small class="form-text text-muted">Additional address details like building name, room number, etc.</small>
                                @error('hospital_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Location Dropdowns -->
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="hospital_division_id" class="form-label">Division <span class="text-danger">*</span></label>
                                <select class="form-select location-division @error('hospital_division_id') is-invalid @enderror" 
                                        id="hospital_division_id" name="hospital_division_id" required>
                                    <option value="">Select Division</option>
                                </select>
                                @error('hospital_division_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="hospital_district_id" class="form-label">District <span class="text-danger">*</span></label>
                                <select class="form-select location-district @error('hospital_district_id') is-invalid @enderror" 
                                        id="hospital_district_id" name="hospital_district_id" disabled required>
                                    <option value="">Select District</option>
                                </select>
                                @error('hospital_district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="hospital_upazila_id" class="form-label">Upazila <span class="text-danger">*</span></label>
                                <select class="form-select location-upazila @error('hospital_upazila_id') is-invalid @enderror" 
                                        id="hospital_upazila_id" name="hospital_upazila_id" disabled required>
                                    <option value="">Select Upazila</option>
                                </select>
                                @error('hospital_upazila_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="additional_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3">{{ $request->additional_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Cancel Confirmation Modal -->
@if($request->status === 'pending')
<div class="modal fade" id="cancelModal{{ $request->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cancelModalLabel{{ $request->id }}">
                    <i class="fas fa-exclamation-triangle me-2"></i>Cancel Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this blood request?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    This action cannot be undone. The request will be marked as cancelled.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Request</button>
                <form action="{{ route('user.blood-requests.destroy', $request->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Yes, Cancel Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@push('styles')
<style>
    /* Stat Cards */
    .stat-card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        min-height: 120px;
    }
    
    /* Mobile fix for modals to ensure submit button is visible */
    @media (max-width: 767.98px) {
        .modal-body {
            padding-bottom: 10px;
        }
        
        .modal-dialog {
            margin-bottom: 80px;
        }
        
        .modal {
            padding-bottom: 300px;
        }
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    /* Icon Circles */
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    
    /* Soft Background Colors */
    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.15);
    }
    
    .bg-success-soft {
        background-color: rgba(40, 167, 69, 0.15); 
    }
    
    .bg-info-soft {
        background-color: rgba(23, 162, 184, 0.15);
    }
    
    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.15);
    }
    
    /* Modern Card Design */
    .modern-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
        background-color: white;
        min-height: 250px;
        display: flex;
        flex-direction: column;
    }
    
    .modern-card .card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    
    .modern-card .action-buttons {
        margin-top: auto;
        padding-top: 15px;
    }
    
    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }
    
    /* Blood Type Circle */
    .blood-type-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #dc3545;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    /* Status Pill */
    .status-pill {
        display: inline-block;
        padding: 6px 12px;
        color: white;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    /* Urgency Pill */
    .urgency-pill {
        display: inline-block;
        padding: 3px 10px;
        color: white;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    /* Info Box */
    .info-box {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        color: #6c757d;
        font-size: 0.8rem;
        margin-bottom: 4px;
    }
    
    .info-value {
        font-weight: 600;
        font-size: 1rem;
    }
    
    /* Assigned Donor Section */
    .assigned-donor-section {
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
    }
    
    .donor-info {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .donor-avatar {
        width: 36px;
        height: 36px;
        overflow: hidden;
        border-radius: 50%;
    }
    
    .donor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 36px;
        height: 36px;
        background-color: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 700;
    }
    
    .donor-name {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .donation-date {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    /* Action Buttons */
    .btn-action {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.85rem;
        margin-left: 5px;
        font-weight: 500;
    }
    
    /* Animation for cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .modern-card {
        animation: fadeIn 0.5s ease forwards;
    }
    
    /* Mobile-specific styling */
    @media (max-width: 767.98px) {
        .stat-card {
            margin-bottom: 20px;
        }
        
        .col-md-3.col-sm-6 {
            margin-bottom: 20px;
        }
        
        .modern-card {
            margin-bottom: 25px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize division dropdowns for the create form
        loadDivisions();
        
        // Store buttons and their data for later use
        const editButtons = document.querySelectorAll('button[data-bs-target^="#editModal"]');
        let locationData = {};
        
        // Extract location data from each edit button
        editButtons.forEach(button => {
            const modalId = button.getAttribute('data-bs-target');
            const requestId = modalId.replace('#editModal', '');
            
            locationData[requestId] = {
                divisionId: button.getAttribute('data-division-id'),
                districtId: button.getAttribute('data-district-id'),
                upazilaId: button.getAttribute('data-upazila-id')
            };
            
            console.log(`Stored data for request ${requestId}:`, locationData[requestId]);
        });
        
        // Handle edit modals
        document.querySelectorAll('[id^="editModal"]').forEach(modal => {
            modal.addEventListener('show.bs.modal', function(event) {
                const requestId = this.id.replace('editModal', '');
                const data = locationData[requestId];
                
                if (!data) {
                    console.error(`No location data found for request ${requestId}`);
                    return;
                }
                
                const divisionId = data.divisionId;
                const districtId = data.districtId;
                const upazilaId = data.upazilaId;
                
                console.log(`Loading locations for request ${requestId}:`, {
                    divisionId, districtId, upazilaId
                });
                
                const divisionSelect = this.querySelector('.location-division');
                const districtSelect = this.querySelector('.location-district');
                const upazilaSelect = this.querySelector('.location-upazila');
                
                // First load all divisions
                fetch('{{ route("get.divisions") }}')
                    .then(response => response.json())
                    .then(data => {
                        divisionSelect.innerHTML = '<option value="">Select Division</option>';
                        
                        data.forEach(division => {
                            const option = document.createElement('option');
                            option.value = division.id;
                            option.textContent = division.name;
                            divisionSelect.appendChild(option);
                        });
                        
                        // Set selected division
                        if (divisionId) {
                            divisionSelect.value = divisionId;
                            
                            // Load districts for the selected division
                            fetch(`{{ url('/get-districts') }}/${divisionId}`)
                                .then(response => response.json())
                                .then(data => {
                                    districtSelect.innerHTML = '<option value="">Select District</option>';
                                    
                                    data.forEach(district => {
                                        const option = document.createElement('option');
                                        option.value = district.id;
                                        option.textContent = district.name;
                                        districtSelect.appendChild(option);
                                    });
                                    
                                    // Enable district select
                                    districtSelect.disabled = false;
                                    
                                    // Set selected district
                                    if (districtId) {
                                        districtSelect.value = districtId;
                                        
                                        // Load upazilas for the selected district
                                        fetch(`{{ url('/get-upazilas') }}/${districtId}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
                                                
                                                data.forEach(upazila => {
                                                    const option = document.createElement('option');
                                                    option.value = upazila.id;
                                                    option.textContent = upazila.name;
                                                    upazilaSelect.appendChild(option);
                                                });
                                                
                                                // Enable upazila select
                                                upazilaSelect.disabled = false;
                                                
                                                // Set selected upazila
                                                if (upazilaId) {
                                                    upazilaSelect.value = upazilaId;
                                                }
                                            })
                                            .catch(error => console.error('Error loading upazilas:', error));
                                    }
                                })
                                .catch(error => console.error('Error loading districts:', error));
                        }
                    })
                    .catch(error => console.error('Error loading divisions:', error));
            });
        });
        
        // Add event listeners to division and district selects
        document.querySelectorAll('.location-division').forEach(select => {
            select.addEventListener('change', function() {
                const modal = this.closest('.modal');
                const districtSelect = modal ? modal.querySelector('.location-district') : document.getElementById('hospital_district_id');
                const upazilaSelect = modal ? modal.querySelector('.location-upazila') : document.getElementById('hospital_upazila_id');
                
                // Reset and disable dependent dropdowns
                resetSelect(districtSelect);
                resetSelect(upazilaSelect);
                
                if (this.value) {
                    loadDistricts(this.value, districtSelect);
                    districtSelect.disabled = false;
                }
            });
        });

        document.querySelectorAll('.location-district').forEach(select => {
            select.addEventListener('change', function() {
                const modal = this.closest('.modal');
                const upazilaSelect = modal ? modal.querySelector('.location-upazila') : document.getElementById('hospital_upazila_id');
                
                // Reset and disable dependent dropdown
                resetSelect(upazilaSelect);
                
                if (this.value) {
                    loadUpazilas(this.value, upazilaSelect);
                    upazilaSelect.disabled = false;
                }
            });
        });

        // Functions to load dropdown options
        function loadDivisions() {
            fetch('{{ route("get.divisions") }}')
                .then(response => response.json())
                .then(data => {
                    const divisionSelect = document.getElementById('hospital_division_id');
                    
                    data.forEach(division => {
                        const option = document.createElement('option');
                        option.value = division.id;
                        option.textContent = division.name;
                        divisionSelect.appendChild(option);
                    });

                    // Set selected values if available
                    @if(old('hospital_division_id'))
                        divisionSelect.value = '{{ old('hospital_division_id') }}';
                        divisionSelect.dispatchEvent(new Event('change'));
                    @endif
                })
                .catch(error => console.error('Error loading divisions:', error));
        }

        function loadDistricts(divisionId, districtSelect = null) {
            if (!districtSelect) {
                districtSelect = document.getElementById('hospital_district_id');
            }
            
            fetch(`{{ url('/get-districts') }}/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">Select District</option>';
                    
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });

                    // Set selected value if available
                    @if(old('hospital_district_id'))
                        if (districtSelect.id === 'hospital_district_id') {
                            districtSelect.value = '{{ old('hospital_district_id') }}';
                            districtSelect.dispatchEvent(new Event('change'));
                        }
                    @endif
                })
                .catch(error => console.error('Error loading districts:', error));
        }

        function loadUpazilas(districtId, upazilaSelect = null) {
            if (!upazilaSelect) {
                upazilaSelect = document.getElementById('hospital_upazila_id');
            }
            
            fetch(`{{ url('/get-upazilas') }}/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
                    
                    data.forEach(upazila => {
                        const option = document.createElement('option');
                        option.value = upazila.id;
                        option.textContent = upazila.name;
                        upazilaSelect.appendChild(option);
                    });

                    // Set selected value if available
                    @if(old('hospital_upazila_id'))
                        if (upazilaSelect.id === 'hospital_upazila_id') {
                            upazilaSelect.value = '{{ old('hospital_upazila_id') }}';
                        }
                    @endif
                })
                .catch(error => console.error('Error loading upazilas:', error));
        }

        function resetSelect(select) {
            select.innerHTML = '<option value="">Select</option>';
            select.disabled = true;
        }

        // Handle urgency level change affecting the needed date validation
        document.querySelectorAll('.urgency-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const neededDateInput = document.getElementById('needed_date');
                const helpText = document.getElementById('needed_date_help');
                // Use server-provided dates with proper timezone
                const today = '{{ \Carbon\Carbon::today()->format('Y-m-d') }}';
                const tomorrow = '{{ \Carbon\Carbon::today()->addDay()->format('Y-m-d') }}';
                
                if (this.value === 'urgent') {
                    // For urgent requests, allow today's date
                    neededDateInput.min = today;
                    helpText.textContent = 'For urgent requests, today\'s date is allowed.';
                    helpText.classList.add('text-danger');
                } else {
                    // For normal requests, require a future date
                    neededDateInput.min = tomorrow;
                    helpText.textContent = 'The needed date must be a date after today for normal requests.';
                    helpText.classList.remove('text-danger');
                }
                
                // If current value is invalid with new constraints, reset it
                if (neededDateInput.value && new Date(neededDateInput.value) < new Date(neededDateInput.min)) {
                    neededDateInput.value = '';
                }
            });
        });

        // Initialize the date validation based on the currently selected urgency
        const initUrgencyDateValidation = () => {
            const selectedUrgency = document.querySelector('.urgency-radio:checked');
            if (selectedUrgency) {
                selectedUrgency.dispatchEvent(new Event('change'));
            }
        };

        // Call initialization when modal is shown
        document.getElementById('createBloodRequestModal').addEventListener('shown.bs.modal', function() {
            initUrgencyDateValidation();
        });
    });
</script>
@endpush
@endsection 