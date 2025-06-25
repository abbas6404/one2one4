@extends('backend.layouts.master')

@section('title')
Blood Request Details - Blood Donation Management System
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
        color: #e84c3d;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumbs a:hover {
        color: #c0392b;
    }

    .main-content-inner {
        padding: 0 30px 30px;
    }

    .details-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 30px;
        background: linear-gradient(45deg, #e84c3d, #e84c3d99);
        color: white;
    }

    .details-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .details-body {
        padding: 30px;
    }

    .info-group {
        margin-bottom: 25px;
    }

    .info-group:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #666;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #333;
        font-size: 16px;
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
        background: #2ecc71;
        color: white;
    }

    .status-pending {
        background: #f1c40f;
        color: white;
    }

    .status-rejected {
        background: #e74c3c;
        color: white;
    }

    .urgency-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 13px;
        font-weight: 500;
    }

    .urgency-low {
        background: #3498db;
        color: white;
    }

    .urgency-medium {
        background: #f39c12;
        color: white;
    }

    .urgency-high {
        background: #c0392b;
        color: white;
    }

    .donor-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .donor-table th {
        background: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #eee;
    }

    .donor-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }

    .donor-table tr:last-child td {
        border-bottom: none;
    }

    .btn-remove {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 6px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: #c0392b;
    }

    .btn-update {
        background: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-update:hover {
        background: #2980b9;
    }

    .status-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
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

    .assign-donor-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
    }

    .donor-select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #333;
    }

    .donor-select option {
        padding: 8px;
    }

    .btn-assign {
        background: #2ecc71;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-assign:hover {
        background: #27ae60;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .error-message {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
    }

    .success-message {
        color: #2ecc71;
        font-size: 14px;
        margin-top: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .alert-danger {
        background-color: #fee;
        border: 1px solid #fcc;
        color: #e74c3c;
    }

    .alert-success {
        background-color: #efe;
        border: 1px solid #cfc;
        color: #27ae60;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .rejection-reason {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 10px;
    }

    .rejection-reason label {
        display: block;
        margin-bottom: 8px;
        color: #666;
        font-weight: 500;
    }

    .rejection-reason textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
    }

    .text-danger {
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .spinner {
        display: inline-block;
        width: 12px;
        height: 12px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
        margin-right: 5px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .btn-assign-top {
        background: #fff;
        color: #e84c3d;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-assign-top:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }

    .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }

    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid #eee;
        padding: 15px 20px;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }

    .modal-title {
        color: #333;
        font-weight: 600;
        margin: 0;
    }

    .close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #666;
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }

    .close:hover {
        opacity: 1;
    }

    .alert {
        margin-top: 15px;
    }

    .notes-section, .rejection-notes {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .notes-content {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin-top: 8px;
    }

    .rejection-notes {
        background: #fff3f3;
    }

    .rejection-notes .notes-content {
        color: #dc3545;
    }

    .urgency-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .urgency-high {
        background: #dc3545;
        color: white;
    }

    .urgency-medium {
        background: #ffc107;
        color: #000;
    }

    .urgency-low {
        background: #28a745;
        color: white;
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-label {
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #333;
        font-size: 15px;
        font-weight: 500;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Blood Request Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.blood_requests.index') }}">Blood Requests</a></li>
                    <li><span>Details</span></li>
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
        <div class="col-12">
            <div class="details-card">
                <div class="details-header">
                    <h2>Request Information</h2>
                    @if($bloodRequest->status !== 'completed' && $bloodRequest->status !== 'cancel' && $bloodRequest->status !== 'rejected')
                    <a href="{{ route('admin.blood_requests.assign_donor_page', $bloodRequest->id) }}" class="btn-assign-top">
                        <i class="fas fa-user-plus"></i> Assign Donor
                    </a>
                    @endif
                </div>
                <div class="details-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="info-label">Requester</div>
                                <div class="info-value">{{ $bloodRequest->user->name }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Blood Type</div>
                                <div class="info-value">{{ $bloodRequest->blood_type }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Units Needed</div>
                                <div class="info-value">{{ $bloodRequest->units_needed }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Hospital</div>
                                <div class="info-value">{{ $bloodRequest->hospital_name }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Hospital Address</div>
                                <div class="info-value">{{ $bloodRequest->hospital_address ?: 'Not provided' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="status-badge status-{{ strtolower($bloodRequest->status) }}">
                                        {{ ucfirst($bloodRequest->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Urgency</div>
                                <div class="info-label">
                                    <span class="urgency-badge urgency-{{ strtolower($bloodRequest->urgency_level) }}">
                                        {{ ucfirst($bloodRequest->urgency_level) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Needed By</div>
                                <div class="info-value">{{ $bloodRequest->needed_date ? $bloodRequest->needed_date->format('M d, Y') : 'Not specified' }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Created</div>
                                <div class="info-value">{{ $bloodRequest->created_at->format('M d, Y h:i A') }}</div>
                            </div>
                        </div>
                    </div>

                    @if($bloodRequest->additional_notes)
                    <div class="notes-section mt-4">
                        <div class="info-label">Additional Notes</div>
                        <div class="notes-content">
                            {{ $bloodRequest->additional_notes }}
                        </div>
                    </div>
                    @endif

                    @if($bloodRequest->rejection_reason)
                    <div class="rejection-notes mt-4">
                        <div class="info-label">Rejection Reason</div>
                        <div class="notes-content text-danger">
                            {{ $bloodRequest->rejection_reason }}
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <h4 class="mb-3">Update Status</h4>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.blood_requests.update_status', $bloodRequest->id) }}" method="POST" id="statusUpdateForm">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <select name="status" class="status-select" required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ $bloodRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $bloodRequest->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $bloodRequest->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="completed" {{ $bloodRequest->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancel" {{ $bloodRequest->status == 'cancel' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group rejection-reason" style="display: none;">
                                <label for="rejection_reason">Reason for Rejection</label>
                                <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3"></textarea>
                                @error('rejection_reason')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-update">Update Status</button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h4>Assigned Donors</h4>
                        <table class="donor-table">
                            <thead>
                                <tr>
                                    <th>Donor</th>
                                    <th>Status</th>
                                    <th>Donation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bloodRequest->donations as $donation)
                                <tr>
                                    <td>{{ $donation->donor->name }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($donation->status) }}">
                                            {{ $donation->status }}
                                        </span>
                                    </td>
                                    <td>{{ $donation->donation_date ?: 'Not Set' }}</td>
                                    <td>
                                        <form action="{{ route('admin.blood_requests.remove_donor', [$bloodRequest->id, $donation->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-remove">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No donors assigned yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const rejectionReasonDiv = document.querySelector('.rejection-reason');
        const rejectionReasonInput = document.querySelector('#rejection_reason');

        function toggleRejectionReason() {
            if (statusSelect.value === 'rejected') {
                rejectionReasonDiv.style.display = 'block';
                rejectionReasonInput.setAttribute('required', 'required');
            } else {
                rejectionReasonDiv.style.display = 'none';
                rejectionReasonInput.removeAttribute('required');
                rejectionReasonInput.value = ''; // Clear the rejection reason when not rejected
            }
        }

        // Initial check
        toggleRejectionReason();

        // Listen for changes
        statusSelect.addEventListener('change', toggleRejectionReason);

        // Form submission handling
        const form = document.getElementById('statusUpdateForm');
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner"></span> Updating...';
        });

        // Show success message in modal if exists
        @if(session('success'))
            $('#assignDonorModal').modal('hide');
        @endif

        // Reset form on modal close
        $('#assignDonorModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('.text-danger').hide();
        });
    });
</script>
@endsection 