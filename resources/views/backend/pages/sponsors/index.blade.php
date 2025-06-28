@extends('backend.layouts.master')

@section('title', 'Sponsors')

@section('styles')
<style>
    .sponsors-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .sponsors-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .breadcrumb-wrapper {
        background: #f8f9fa;
        border-radius: 4px;
        padding: 0.5rem 1rem;
    }
    
    .add-sponsor-btn {
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .add-sponsor-btn:hover {
        background-color: #0069d9;
        color: white;
    }
    
    .sponsors-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    .sponsors-table thead {
        background-color: #f8f9fa;
    }
    
    .sponsors-table th {
        font-weight: 600;
        color: #495057;
        padding: 1rem;
    }
    
    .sponsors-table td {
        vertical-align: middle;
        padding: 1rem;
    }
    
    .sponsor-logo {
        height: 60px;
        object-fit: contain;
        border-radius: 4px;
    }
    
    .sponsor-status {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .status-active {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .status-inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .payment-status {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
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
    
    .action-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        font-size: 0.875rem;
        margin-right: 0.25rem;
        transition: all 0.3s;
    }
    
    .view-btn {
        background-color: #17a2b8;
        color: white;
    }
    
    .view-btn:hover {
        background-color: #138496;
        color: white;
    }
    
    .edit-btn {
        background-color: #28a745;
        color: white;
    }
    
    .edit-btn:hover {
        background-color: #218838;
        color: white;
    }
    
    .empty-url {
        color: #6c757d;
        font-style: italic;
    }
    
    .sponsor-url {
        max-width: 250px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .payment-amount {
        font-weight: 500;
    }
    
    .filter-section {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 4px;
    }
    
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }
    
    .filter-form .form-group {
        margin-bottom: 0;
    }
    
    .filter-form .form-control {
        min-width: 150px;
    }
    
    .filter-form .btn {
        padding: 0.375rem 0.75rem;
    }
    
    .filter-form .btn-reset {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Sponsors</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Sponsors</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<!-- Sponsors list -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="sponsors-header">
                        <h2 class="sponsors-title">Sponsors List</h2>
                        @if (Auth::guard('admin')->user()->can('sponsor.create'))
                            <a class="btn add-sponsor-btn" href="{{ route('admin.sponsors.create') }}">
                                <i class="fa fa-plus-circle mr-1"></i> Add New Sponsor
                            </a>
                        @endif
                    </div>
                    
                    @include('backend.layouts.partials.messages')

                    

                    <!-- Sponsors Summary -->
                    <div class="mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sponsors Summary</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h6>Total Sponsors</h6>
                                                <h3>{{ $sponsors->total() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h6>Active Sponsors</h6>
                                                <h3>{{ App\Models\Sponsor::where('status', 'active')->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning">
                                            <div class="card-body text-center">
                                                <h6>Pending Payments</h6>
                                                <h3>{{ App\Models\Sponsor::where('payment_status', 'pending')->count() }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center">
                                                <h6>Total Contributions</h6>
                                                <h3>{{ number_format(App\Models\Sponsor::sum('payment_amount')) }} BDT</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <form action="{{ route('admin.sponsors.index') }}" method="GET" class="filter-form">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control">
                                    <option value="">All Payment Status</option>
                                    <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="search">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                            </div>
                            
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.sponsors.index') }}" class="btn filter-form btn-reset">Reset</a>
                            </div>
                        </form>
                    </div>
                    
                    <div class="sponsors-table">
                        <table id="dataTable" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Payment</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sponsors as $sponsor)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        @if ($sponsor->logo)
                                            <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="sponsor-logo">
                                        @else
                                            <span class="badge bg-warning text-dark">No Logo</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $sponsor->name }}</strong></td>
                                    <td>
                                        @if ($sponsor->url)
                                            <a href="{{ $sponsor->url }}" target="_blank" class="sponsor-url">{{ $sponsor->url }}</a>
                                        @else
                                            <span class="empty-url">No URL</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="payment-amount">{{ number_format($sponsor->payment_amount) }} BDT</div>
                                        <div>
                                            <span class="payment-status payment-{{ $sponsor->payment_status }}">{{ ucfirst($sponsor->payment_status) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $sponsor->order }}</td>
                                    <td>
                                        <span class="sponsor-status status-{{ $sponsor->status }}">{{ ucfirst($sponsor->status) }}</span>
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('sponsor.view'))
                                            <a href="{{ route('admin.sponsors.show', $sponsor->id) }}" class="btn action-btn view-btn" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('sponsor.edit'))
                                            <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}" class="btn action-btn edit-btn" title="Edit Sponsor">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $sponsors->appends(request()->query())->links() }}
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            "ordering": true,
            "paging": false,
            "info": false,
            "searching": false,
            "columnDefs": [
                { "orderable": false, "targets": [1, 6] }
            ]
        });
    });
</script>
@endsection 