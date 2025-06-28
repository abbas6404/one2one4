@extends('backend.layouts.master')

@section('title', 'View Sponsor')

@section('styles')
<style>
    .sponsor-details-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    .sponsor-logo-container {
        border: 1px solid #dee2e6;
        padding: 1rem;
        border-radius: 4px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .sponsor-logo {
        max-height: 200px;
        max-width: 100%;
        object-fit: contain;
    }
    
    .sponsor-info-table th {
        width: 180px;
        background-color: #f8f9fa;
    }
    
    .payment-details-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        border: 1px solid #dee2e6;
    }
    
    .payment-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .payment-completed {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .payment-pending {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .payment-failed {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .payment-screenshot {
        max-width: 100%;
        max-height: 300px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        cursor: pointer;
        transition: transform 0.3s;
    }
    
    .payment-screenshot:hover {
        transform: scale(1.02);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .verify-payment-btn {
        background-color: #28a745;
        color: white;
    }
    
    .verify-payment-btn:hover {
        background-color: #218838;
        color: white;
    }
    
    .reject-payment-btn {
        background-color: #dc3545;
        color: white;
    }
    
    .reject-payment-btn:hover {
        background-color: #c82333;
        color: white;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">View Sponsor</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.sponsors.index') }}">Sponsors</a></li>
                    <li><span>View Sponsor</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Sponsor Details</h4>
                    
                    <div class="action-buttons mb-4">
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-primary">
                            <i class="fa fa-list mr-1"></i> Back to List
                        </a>
                        
                        @if (Auth::guard('admin')->user()->can('sponsor.edit'))
                            <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}" class="btn btn-success">
                                <i class="fa fa-edit mr-1"></i> Edit
                            </a>
                        @endif
                    </div>
                    
                    @include('backend.layouts.partials.messages')
                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="sponsor-logo-container">
                            @if ($sponsor->logo)
                                    <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="sponsor-logo">
                                @else
                                    <div class="alert alert-warning mb-0">
                                        <i class="fa fa-exclamation-triangle mr-2"></i> No logo available
                                    </div>
                                @endif
                            </div>
                            
                            <div class="payment-details-card">
                                <h5 class="mb-3">Payment Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Amount:</strong></p>
                                        <h4>{{ number_format($sponsor->payment_amount) }} BDT</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Status:</strong></p>
                                        <span class="payment-status payment-{{ $sponsor->payment_status }}">
                                            {{ ucfirst($sponsor->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Method:</strong></p>
                                        <p>{{ $sponsor->payment_method }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Transaction ID:</strong></p>
                                        <p>{{ $sponsor->payment_transaction_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                @if ($sponsor->payment_screenshot)
                                <div class="mt-4">
                                    <p class="mb-2"><strong>Payment Screenshot:</strong></p>
                                    <img src="{{ asset($sponsor->payment_screenshot) }}" alt="Payment Screenshot" class="payment-screenshot img-fluid" style="max-height: 300px;" data-toggle="modal" data-target="#screenshotModal">
                                </div>
                            @endif
                            </div>
                        </div>
                        
                        <div class="col-md-7">
                            <table class="table table-bordered sponsor-info-table">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $sponsor->name }}</td>
                                </tr>
                                <tr>
                                    <th>Website URL</th>
                                    <td>
                                        @if ($sponsor->url)
                                            <a href="{{ $sponsor->url }}" target="_blank">{{ $sponsor->url }} <i class="fa fa-external-link-alt"></i></a>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $sponsor->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $sponsor->email }}</td>
                                </tr>
                                <tr>
                                    <th>Display Order</th>
                                    <td>{{ $sponsor->order }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($sponsor->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $sponsor->created_at->format('d F, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $sponsor->updated_at->format('d F, Y h:i A') }}</td>
                                </tr>
                            </table>
                    
                    <div class="mt-4">
                        <div class="alert alert-info">
                            <strong>Note:</strong> This sponsor will be displayed on the homepage and other pages where sponsors are shown.
                            Make sure the logo is of good quality and appropriate dimensions.
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Screenshot Modal -->
<div class="modal fade" id="screenshotModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Screenshot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @if ($sponsor->payment_screenshot)
                    <img src="{{ asset($sponsor->payment_screenshot) }}" alt="Payment Screenshot" class="img-fluid" style="max-height: 70vh;">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 