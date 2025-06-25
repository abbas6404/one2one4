@extends('backend.layouts.master')

@section('title')
Edit Blood Donation - Blood Donation Management System
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

    .edit-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: linear-gradient(45deg, #4e73df, #4e73df99);
        color: white;
    }

    .edit-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .edit-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d3e2;
        border-radius: 4px;
        font-size: 14px;
        color: #333;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .form-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d3e2;
        border-radius: 4px;
        font-size: 14px;
        color: #333;
        transition: border-color 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: #4e73df;
        color: white;
    }

    .btn-primary:hover {
        background: #2e59d9;
    }

    .btn-secondary {
        background: #858796;
        color: white;
    }

    .btn-secondary:hover {
        background: #6e707e;
    }

    .rejection-reason {
        display: none;
    }

    .rejection-reason.show {
        display: block;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 5px;
        font-size: 12px;
        color: #e74a3b;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit Blood Donation</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.blood_donations.index') }}">Blood Donations</a></li>
                    <li><span>Edit Blood Donation #{{ $bloodDonation->id }}</span></li>
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
            <div class="edit-card">
                <div class="edit-header">
                    <h2>Edit Blood Donation #{{ $bloodDonation->id }}</h2>
                </div>
                <div class="edit-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.blood_donations.update', ['donation' => $bloodDonation->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Preserve the original donor_id and blood_request_id as hidden fields -->
                        <input type="hidden" name="donor_id" value="{{ $bloodDonation->donor_id }}">
                        <input type="hidden" name="blood_request_id" value="{{ $bloodDonation->blood_request_id }}">
                        <input type="hidden" name="volume" value="{{ $bloodDonation->volume }}">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="donation_date">Donation Date</label>
                                    <input type="date" class="form-control" id="donation_date" name="donation_date" value="{{ old('donation_date', $bloodDonation->donation_date ? $bloodDonation->donation_date->format('Y-m-d') : '') }}">
                                    @error('donation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="pending" {{ $bloodDonation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $bloodDonation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $bloodDonation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="completed" {{ $bloodDonation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="rejection_reason_group" class="form-group rejection-reason {{ $bloodDonation->status == 'rejected' ? 'show' : '' }}">
                            <label class="form-label" for="rejection_reason">Rejection Reason</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3">{{ old('rejection_reason', $bloodDonation->rejection_reason) }}</textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Blood Donation
                            </button>
                            <a href="{{ route('admin.blood_donations.show', ['donation' => $bloodDonation->id]) }}" class="btn btn-secondary ml-2">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Show/hide rejection reason based on status
        $('#status').change(function() {
            if ($(this).val() === 'rejected') {
                $('#rejection_reason_group').addClass('show');
            } else {
                $('#rejection_reason_group').removeClass('show');
            }
        });
    });
</script>
@endsection 