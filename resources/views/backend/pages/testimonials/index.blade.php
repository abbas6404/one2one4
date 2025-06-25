@extends('backend.layouts.master')

@section('title', 'Testimonials')

@section('styles')
<style>
    .testimonials-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .testimonials-title {
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
    
    .add-testimonial-btn {
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .add-testimonial-btn:hover {
        background-color: #0069d9;
        color: white;
    }
    
    .testimonials-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    .testimonials-table thead {
        background-color: #f8f9fa;
    }
    
    .testimonials-table th {
        font-weight: 600;
        color: #495057;
        padding: 1rem;
    }
    
    .testimonials-table td {
        vertical-align: middle;
        padding: 1rem;
    }
    
    .avatar-image {
        height: 60px;
        width: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #e9ecef;
    }
    
    .testimonial-content {
        max-width: 250px;
        display: block;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .testimonial-status {
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
    
    .badge-donor {
        background-color: #28a745;
        color: white;
    }
    
    .badge-recipient {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-volunteer {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-other {
        background-color: #6c757d;
        color: white;
    }
    
    .badge-type {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Testimonials</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Testimonials</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<!-- Testimonials list -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="testimonials-header">
                        <h2 class="testimonials-title">Testimonials List</h2>
                        @if (Auth::guard('admin')->user()->can('testimonial.create'))
                            <a class="btn add-testimonial-btn" href="{{ route('admin.testimonials.create') }}">
                                <i class="fa fa-plus-circle mr-1"></i> Add New Testimonial
                            </a>
                        @endif
                    </div>
                    
                    @include('backend.layouts.partials.messages')
                    
                    <div class="testimonials-table">
                        <table id="dataTable" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Content</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Blood Group</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>
                                        @if ($testimonial->avatar)
                                            <img src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="avatar-image">
                                        @else
                                            <img src="{{ asset('images/avatar.png') }}" alt="Default Avatar" class="avatar-image">
                                        @endif
                                    </td>
                                    <td><strong>{{ $testimonial->name }}</strong></td>
                                    <td>
                                        <div class="testimonial-content">
                                            {{ Str::limit($testimonial->content, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-type badge-{{ $testimonial->type }}">
                                            {{ ucfirst($testimonial->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $testimonial->location ?? 'N/A' }}</td>
                                    <td>{{ $testimonial->blood_group ?? 'N/A' }}</td>
                                    <td>{{ $testimonial->order }}</td>
                                    <td>
                                        @if ($testimonial->status == 'active')
                                            <span class="testimonial-status status-active">Active</span>
                                        @else
                                            <span class="testimonial-status status-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.testimonials.show', $testimonial->id) }}" class="btn action-btn view-btn">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            
                                            @if (Auth::guard('admin')->user()->can('testimonial.edit'))
                                                <a class="btn action-btn edit-btn" href="{{ route('admin.testimonials.edit', $testimonial->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            
                                            @if (Auth::guard('admin')->user()->can('testimonial.delete'))
                                                <a class="btn action-btn delete-btn" 
                                                   href="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                                                   onclick="event.preventDefault(); 
                                                         document.getElementById('delete-form-{{ $testimonial->id }}').submit();">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form id="delete-form-{{ $testimonial->id }}" action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display: none;">
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
                { "orderable": false, "targets": [1, 9] }
            ]
        });
    });
</script>
@endsection 