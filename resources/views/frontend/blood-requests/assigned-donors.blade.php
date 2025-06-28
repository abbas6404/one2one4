@extends('frontend.layouts.frontend')

@section('title', 'Assigned Donors')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Assigned Donors</h1>
            <p class="text-muted mb-0">Blood Request #{{ $bloodRequest->id }}</p>
        </div>
        <a href="{{ route('user.blood-requests.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Requests
        </a>
    </div>

    <!-- Blood Request Info Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Blood Request Details</h5>
                    <div class="mt-3">
                        <p><strong>Blood Type:</strong> <span class="badge bg-danger">{{ $bloodRequest->blood_type }}</span></p>
                        <p><strong>Units Needed:</strong> {{ $bloodRequest->units_needed }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $bloodRequest->status === 'pending' ? 'warning' : ($bloodRequest->status === 'completed' ? 'success' : 'info') }}">
                                {{ ucfirst($bloodRequest->status) }}
                            </span>
                        </p>
                        <p><strong>Urgency Level:</strong> 
                            <span class="badge bg-{{ $bloodRequest->urgency_level === 'normal' ? 'primary' : 'danger' }}">
                                {{ ucfirst($bloodRequest->urgency_level) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Hospital Information</h5>
                    <div class="mt-3">
                        <p><strong>Hospital Name:</strong> {{ $bloodRequest->hospital_name }}</p>
                        <p><strong>Location:</strong> {{ $bloodRequest->formatted_address }}</p>
                        <p><strong>Needed By:</strong> {{ $bloodRequest->needed_date ? $bloodRequest->needed_date->format('M d, Y') : 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Donors List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-gray-800">Assigned Donors ({{ $bloodRequest->donations->count() }}/{{ $bloodRequest->units_needed }})</h5>
        </div>
        <div class="card-body">
            @if($bloodRequest->donations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Donor Name</th>
                                <th>Blood Group</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Assigned Date</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bloodRequest->donations as $donation)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2 bg-primary">
                                                <span class="initials">{{ substr($donation->donor->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $donation->donor->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-tint me-1"></i>{{ $donation->donor->blood_group }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-0"><i class="fas fa-phone me-1 text-primary"></i> {{ $donation->donor->phone }}</p>
                                            <p class="mb-0"><i class="fas fa-envelope me-1 text-primary"></i> {{ $donation->donor->email }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $donation->status === 'pending' ? 'warning' : 
                                            ($donation->status === 'completed' ? 'success' : 'danger') 
                                        }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $donation->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($donation->status === 'rejected' && $donation->rejection_reason)
                                            <div class="rejection-reason text-danger">
                                                <small><i class="fas fa-exclamation-circle"></i> {{ $donation->rejection_reason }}</small>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-clock fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted">No donors assigned yet</h5>
                    <p class="text-muted">Please wait for the administrator to assign donors to your request.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #8a0303;
        text-align: center;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .initials {
        font-size: 20px;
        line-height: 1;
        color: #fff;
        font-weight: bold;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    /* Add styles for rejection reason */
    .rejection-reason {
        padding: 3px 6px;
        background-color: rgba(220, 53, 69, 0.1);
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
    }
</style>
@endpush
@endsection 