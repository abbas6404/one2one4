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
    
    .delete-btn {
        background-color: #dc3545;
        color: white;
    }
    
    .delete-btn:hover {
        background-color: #c82333;
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
                    
                    <div class="sponsors-table">
                        <table id="dataTable" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>URL</th>
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
                                            <a href="{{ $sponsor->url }}" target="_blank" class="sponsor-url">
                                                {{ $sponsor->url }} <i class="fa fa-external-link-alt fa-xs ml-1"></i>
                                            </a>
                                        @else
                                            <span class="empty-url">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $sponsor->order }}</td>
                                    <td>
                                        @if ($sponsor->status == 'active')
                                            <span class="sponsor-status status-active">Active</span>
                                        @else
                                            <span class="sponsor-status status-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.sponsors.show', $sponsor->id) }}" class="btn action-btn view-btn">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            
                                            @if (Auth::guard('admin')->user()->can('sponsor.edit'))
                                                <a class="btn action-btn edit-btn" href="{{ route('admin.sponsors.edit', $sponsor->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            
                                            @if (Auth::guard('admin')->user()->can('sponsor.delete'))
                                                <a class="btn action-btn delete-btn" 
                                                href="{{ route('admin.sponsors.destroy', $sponsor->id) }}"
                                                onclick="event.preventDefault(); 
                                                        document.getElementById('delete-form-{{ $sponsor->id }}').submit();">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form id="delete-form-{{ $sponsor->id }}" action="{{ route('admin.sponsors.destroy', $sponsor->id) }}" method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            "columnDefs": [
                { "orderable": false, "targets": [1, 6] }
            ]
        });
    });
</script>
@endsection 