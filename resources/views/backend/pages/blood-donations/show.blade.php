@extends('backend.layouts.master')

@section('title')
Blood Donation Details - Blood Donation Management System
@endsection

@section('styles')
<style>
    .page-title-area {
        padding: 30px 30px 20px;
        background: #f8f9fa;
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .breadcrumbs-area h4 {
        margin: 0 0 10px;
        font-size: 24px;
        color: #333;
    }

    .breadcrumbs {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .breadcrumbs li {
        display: flex;
        align-items: center;
        color: #666;
    }

    .breadcrumbs li:not(:last-child):after {
        content: '/';
        margin-left: 8px;
        color: #ccc;
    }

    .breadcrumbs a {
        color: #4e73df;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumbs a:hover {
        color: #2e59d9;
    }

    .main-content-inner {
        padding: 0 30px 30px;
    }

    .details-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: linear-gradient(45deg, #4e73df, #4e73df99);
        color: white;
    }

    .details-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .details-body {
        padding: 25px;
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-group:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #666;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #333;
        font-size: 15px;
        font-weight: 500;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-approved {
        background: #1cc88a;
        color: white;
    }

    .status-pending {
        background: #f6c23e;
        color: white;
    }

    .status-rejected {
        background: #e74a3b;
        color: white;
    }

    .status-completed {
        background: #1cc88a;
        color: white;
    }

    .blood-type {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 700;
        background-color: #e74a3b;
        color: white;
    }

    .notes-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .notes-section p {
        margin: 0;
        color: #666;
        font-style: italic;
    }

    .btn-action {
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-right: 8px;
        margin-bottom: 10px;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #4e73df;
        color: white;
    }

    .btn-edit:hover {
        background: #2e59d9;
    }

    .btn-approve {
        background: #1cc88a;
        color: white;
    }

    .btn-approve:hover {
        background: #17a673;
    }

    .btn-reject {
        background: #e74a3b;
        color: white;
    }

    .btn-reject:hover {
        background: #c52b1a;
    }

    .btn-complete {
        background: #1cc88a;
        color: white;
    }

    .btn-complete:hover {
        background: #17a673;
    }

    .btn-back {
        background: #858796;
        color: white;
    }

    .btn-back:hover {
        background: #6e707e;
    }

    .donor-details, .request-details {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .donor-details h4, .request-details h4 {
        margin-top: 0;
        color: #4e73df;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .donation-meta {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    .action-buttons {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Blood Donation Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.blood_donations.index') }}">Blood Donations</a></li>
                    <li><span>Blood Donation #{{ $bloodDonation->id }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="details-card">
                <div class="details-header">
                    <h2>Blood Donation #{{ $bloodDonation->id }}</h2>
                    <span class="status-badge status-{{ strtolower($bloodDonation->status) }}">
                        {{ ucfirst($bloodDonation->status) }}
                    </span>
                </div>
                <div class="details-body">
                    <!-- Donor Information -->
                    <div class="donor-details">
                        <h4><i class="fa fa-user-md"></i> Donor Information</h4>
                        @if($bloodDonation->donor)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Donor Name</div>
                                    <div class="info-value">{{ $bloodDonation->donor->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Blood Type</div>
                                    <div class="info-value">
                                        @if($bloodDonation->donor->blood_group)
                                            <span class="blood-type">{{ $bloodDonation->donor->blood_group }}</span>
                                        @else
                                            <span class="blood-type bg-light text-muted">Unknown</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Contact Number</div>
                                    <div class="info-value">{{ $bloodDonation->donor->phone ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">{{ $bloodDonation->donor->email }}</div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> No donor information available
                        </div>
                        @endif
                    </div>

                    <!-- Blood Request Information if linked to a request -->
                    @if($bloodDonation->bloodRequest)
                    <div class="request-details">
                        <h4><i class="fa fa-medkit"></i> Request Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Request ID</div>
                                    <div class="info-value">
                                        <a href="{{ route('admin.blood_requests.show', $bloodDonation->bloodRequest->id) }}">
                                            Request #{{ $bloodDonation->bloodRequest->id }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Patient Name</div>
                                    <div class="info-value">{{ $bloodDonation->bloodRequest->patient_name ?? 'Not specified' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Hospital Name</div>
                                    <div class="info-value">{{ $bloodDonation->bloodRequest->hospital_name ?? 'Not specified' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Required Date</div>
                                    <div class="info-value">{{ $bloodDonation->bloodRequest->required_date ? $bloodDonation->bloodRequest->required_date->format('M d, Y') : 'Not specified' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Hospital Address</div>
                                    <div class="info-value">{{ $bloodDonation->bloodRequest->hospital_address ?? 'Not specified' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Contact Number</div>
                                    <div class="info-value">{{ $bloodDonation->bloodRequest->contact_number ?? 'Not specified' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Donation Details -->
                    <div class="donation-meta">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Donation Date</div>
                                    <div class="info-value">{{ $bloodDonation->donation_date ? $bloodDonation->donation_date->format('M d, Y') : 'Not donated yet' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Blood Volume (ml)</div>
                                    <div class="info-value">{{ $bloodDonation->volume ?? 'Not specified' }}</div>
                                </div>
                            </div>
                        </div>

                        @if($bloodDonation->status === 'rejected' && $bloodDonation->rejection_reason)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notes-section">
                                    <div class="info-label">Rejection Reason</div>
                                    <p>{{ $bloodDonation->rejection_reason }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons based on current status -->
                    <div class="action-buttons">
                        <!-- Back button -->
                        <a href="{{ route('admin.blood_donations.index') }}" class="btn-action btn-back">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                        
                        @if(Auth::guard('admin')->user()->can('blood.donation.edit'))
                        <a href="{{ route('admin.blood_donations.edit', ['donation' => $bloodDonation->id]) }}" class="btn-action btn-edit">
                            <i class="fa fa-edit"></i> Edit Details
                        </a>
                        @endif

                        <!-- Status Change Buttons -->
                        @if(Auth::guard('admin')->user()->can('blood.donation.edit'))
                            @if($bloodDonation->status === 'pending')
                            <form method="POST" action="{{ route('admin.blood_donations.update', ['donation' => $bloodDonation->id]) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn-action btn-approve">
                                    <i class="fa fa-check"></i> Approve Donation
                                </button>
                            </form>

                            <button type="button" class="btn-action btn-reject" data-toggle="modal" data-target="#rejectModal">
                                <i class="fa fa-times"></i> Reject Donation
                            </button>
                            @endif

                            @if($bloodDonation->status === 'approved')
                            <form method="POST" action="{{ route('admin.blood_donations.update', ['donation' => $bloodDonation->id]) }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn-action btn-complete">
                                    <i class="fa fa-flag-checkered"></i> Mark as Completed
                                </button>
                            </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Donation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.blood_donations.update', ['donation' => $bloodDonation->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="status" value="rejected">
                    <div class="form-group">
                        <label for="rejection_reason">Reason for Rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize any needed plugins
    });
</script>
@endsection 