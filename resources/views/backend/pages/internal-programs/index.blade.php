@extends('backend.layouts.master')

@section('title')
Internal Programs
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
    .blood-group {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 12px;
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
    .action-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        margin-right: 5px;
    }
    .view-btn {
        background-color: #17a2b8;
    }
    .edit-btn {
        background-color: #007bff;
    }
    .delete-btn {
        background-color: #dc3545;
    }
    .search-box {
        position: relative;
    }
    .search-box .form-control {
        padding-left: 35px;
        border-radius: 50px;
    }
    .search-box i {
        position: absolute;
        left: 15px;
        top: 10px;
        color: #6c757d;
    }
    .filter-dropdown {
        min-width: 200px;
    }
    .date-filter {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    .date-filter .form-control {
        border-radius: 4px;
        height: 38px;
    }
    .date-filter .btn {
        height: 38px;
        margin-left: 10px;
    }
    .date-filter-label {
        margin: 0 10px;
        font-weight: 500;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Internal Programs</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Programs</span></li>
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
                    <h4 class="card-title">Internal Programs</h4>
                    <div>
                        <a href="{{ route('admin.internal-programs.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="{{ route('admin.internal-programs.index') }}" method="GET" id="search-form">
                                <div class="search-box">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, phone, email..." value="{{ request('search') }}">
                                    <i class="fa fa-search"></i>
                                </div>
                                
                                <!-- Date filter -->
                                <div class="date-filter">
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                                    <span class="date-filter-label">to</span>
                                    <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    @if(request('start_date') || request('end_date') || request('status') || request('blood_group') || request('search'))
                                        <a href="{{ route('admin.internal-programs.index') }}" class="btn btn-secondary ml-2">Clear</a>
                                    @endif
                                </div>
                                
                                <!-- Hidden fields to preserve other filters -->
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                @if(request('blood_group'))
                                    <input type="hidden" name="blood_group" value="{{ request('blood_group') }}">
                                @endif
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter by Status
                                </button>
                                <div class="dropdown-menu filter-dropdown">
                                    <a class="dropdown-item {{ request('status') == '' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('status', 'page'), ['status' => ''])) }}">All</a>
                                    <a class="dropdown-item {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('status', 'page'), ['status' => 'pending'])) }}">Pending</a>
                                    <a class="dropdown-item {{ request('status') == 'approved' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('status', 'page'), ['status' => 'approved'])) }}">Approved</a>
                                    <a class="dropdown-item {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('status', 'page'), ['status' => 'rejected'])) }}">Rejected</a>
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter by Blood Group
                                </button>
                                <div class="dropdown-menu filter-dropdown">
                                    <a class="dropdown-item {{ request('blood_group') == '' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => ''])) }}">All</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'A+' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'A+'])) }}">A+</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'A-' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'A-'])) }}">A-</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'B+' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'B+'])) }}">B+</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'B-' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'B-'])) }}">B-</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'AB+' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'AB+'])) }}">AB+</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'AB-' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'AB-'])) }}">AB-</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'O+' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'O+'])) }}">O+</a>
                                    <a class="dropdown-item {{ request('blood_group') == 'O-' ? 'active' : '' }}" href="{{ route('admin.internal-programs.index', array_merge(request()->except('blood_group', 'page'), ['blood_group' => 'O-'])) }}">O-</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(request('start_date') || request('end_date'))
                        <div class="alert alert-info">
                            Showing results from 
                            {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : 'the beginning' }} 
                            to 
                            {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : 'today' }}
                            <a href="{{ route('admin.internal-programs.index', array_merge(request()->except(['start_date', 'end_date', 'page']))) }}" class="float-right">Clear date filter</a>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Blood Group</th>
                                    <th>T-shirt Size</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($internalPrograms as $program)
                                    <tr>
                                        <td>{{ $program->id }}</td>
                                        <td>{{ $program->name }}</td>
                                        <td>{{ $program->phone }}</td>
                                        <td><span class="blood-group">{{ $program->blood_group }}</span></td>
                                        <td>{{ $program->tshirt_size }}</td>
                                        <td>{{ $program->payment_method }}</td>
                                        <td>
                                            @if ($program->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($program->status == 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $program->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.internal-programs.show', $program->id) }}" class="action-btn view-btn" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.internal-programs.edit', $program->id) }}" class="action-btn edit-btn" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No internal programs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $internalPrograms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 