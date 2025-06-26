@extends('backend.layouts.master')

@section('title')
Internal Program Details
@endsection

@section('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f1f1f1;
    }
    .card-title {
        margin-bottom: 0;
        font-weight: 600;
    }
    .detail-row {
        display: flex;
        border-bottom: 1px solid #f1f1f1;
        padding: 15px 0;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        width: 150px;
        font-weight: 600;
        color: #555;
    }
    .detail-value {
        flex: 1;
    }
    .blood-group {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
        background-color: #dc3545;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-approved {
        background-color: #28a745;
        color: #fff;
    }
    .badge-rejected {
        background-color: #dc3545;
        color: #fff;
    }
    .screenshot-container {
        max-width: 100%;
        margin-top: 10px;
    }
    .screenshot-img {
        max-width: 100%;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .status-form {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f1f1f1;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Internal Program Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.internal-programs.index') }}">Internal Programs</a></li>
                    <li><span>View Program</span></li>
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
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Internal Program Details</h4>
                    <div>
                        <a href="{{ route('admin.internal-programs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.internal-programs.edit', $internalProgram->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="program-details">
                        <div class="detail-row">
                            <div class="detail-label">Name</div>
                            <div class="detail-value">{{ $internalProgram->name }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">{{ $internalProgram->phone }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $internalProgram->email ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Blood Group</div>
                            <div class="detail-value">
                                <span class="blood-group">{{ $internalProgram->blood_group }}</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Present Address</div>
                            <div class="detail-value">{{ $internalProgram->present_address }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">T-shirt Size</div>
                            <div class="detail-value">{{ $internalProgram->tshirt_size }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value">{{ $internalProgram->payment_method }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Transaction ID</div>
                            <div class="detail-value">{{ $internalProgram->trx_id ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                @if ($internalProgram->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($internalProgram->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Created At</div>
                            <div class="detail-value">{{ $internalProgram->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Updated At</div>
                            <div class="detail-value">{{ $internalProgram->updated_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Payment Screenshot</div>
                            <div class="detail-value">
                                @if($internalProgram->screenshot)
                                    <div class="screenshot-container">
                                        <img src="{{ $internalProgram->screenshot_url }}" alt="Payment Screenshot" class="screenshot-img">
                                    </div>
                                @else
                                    <span class="text-muted">No screenshot uploaded</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="status-form">
                        <h5>Update Status</h5>
                        <form action="{{ route('admin.internal-programs.update_status', $internalProgram->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $internalProgram->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $internalProgram->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $internalProgram->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 