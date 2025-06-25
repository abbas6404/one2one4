@extends('frontend.layouts.frontend')

@section('title', 'Blood Request Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Request Details Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tint me-2"></i>Blood Request Details
                    </h5>
                </div>
                <div class="card-body">
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
                                    <h5 class="mb-0">{{ $bloodRequest->blood_type }}</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-danger me-3">
                                    <i class="fas fa-box text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Units Needed</p>
                                    <h5 class="mb-0">{{ $bloodRequest->units_needed }}</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-danger me-3">
                                    <i class="fas fa-calendar text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Needed By</p>
                                    <h5 class="mb-0">{{ $bloodRequest->needed_date ? $bloodRequest->needed_date->format('M d, Y') : 'Not specified' }}</h5>
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
                                            'in_progress' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'secondary'
                                        ][$bloodRequest->status];
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucfirst($bloodRequest->status) }}
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
                                            'low' => 'success',
                                            'medium' => 'info',
                                            'high' => 'warning',
                                            'critical' => 'danger'
                                        ][$bloodRequest->urgency_level];
                                    @endphp
                                    <span class="badge bg-{{ $urgencyClass }}">
                                        {{ ucfirst($bloodRequest->urgency_level) }}
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
                                    <h5 class="mb-0">{{ $bloodRequest->hospital_name }}</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-danger me-3">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted">Hospital Address</p>
                                    <h5 class="mb-0">{{ $bloodRequest->hospital_address }}</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        @if($bloodRequest->additional_notes)
                        <div class="col-12">
                            <h6 class="text-danger mb-3">Additional Notes</h6>
                            <div class="d-flex align-items-start">
                                <div class="icon-circle bg-danger me-3">
                                    <i class="fas fa-sticky-note text-white"></i>
                                </div>
                                <div>
                                    <p class="mb-0">{{ $bloodRequest->additional_notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Request Info Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Request Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-0 text-muted">Request ID</p>
                            <h6 class="mb-0">#{{ str_pad($bloodRequest->id, 6, '0', STR_PAD_LEFT) }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-0 text-muted">Created By</p>
                            <h6 class="mb-0">{{ $bloodRequest->user->name }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-0 text-muted">Created On</p>
                            <h6 class="mb-0">{{ $bloodRequest->created_at->format('M d, Y h:i A') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0 text-muted">Last Updated</p>
                            <h6 class="mb-0">{{ $bloodRequest->updated_at->format('M d, Y h:i A') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('blood-requests.edit', $bloodRequest->id) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Request
                        </a>
                        @if($bloodRequest->status == 'pending')
                        <form action="{{ route('blood-requests.destroy', $bloodRequest->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this request?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Delete Request
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('blood-requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
@endsection 