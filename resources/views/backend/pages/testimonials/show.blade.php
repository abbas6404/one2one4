@extends('backend.layouts.master')

@section('title', 'View Testimonial')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">View Testimonial</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                    <li><span>View Testimonial</span></li>
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
                    <h4 class="header-title">Testimonial Details</h4>
                    <div class="mb-4">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">Back to List</a>
                        
                        @if (Auth::guard('admin')->user()->can('testimonial.edit'))
                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-success">Edit</a>
                        @endif
                        
                        @if (Auth::guard('admin')->user()->can('testimonial.delete'))
                            <a class="btn btn-danger text-white" 
                               href="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                               onclick="event.preventDefault(); 
                                     document.getElementById('delete-form-{{ $testimonial->id }}').submit();">
                                Delete
                            </a>
                            <form id="delete-form-{{ $testimonial->id }}" action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if ($testimonial->avatar)
                                <img src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="img-fluid rounded" style="max-width: 200px;">
                            @else
                                <img src="{{ asset('images/avatar.png') }}" alt="Default Avatar" class="img-fluid rounded" style="max-width: 200px;">
                            @endif
                        </div>
                        
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Name</th>
                                    <td>{{ $testimonial->name }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ ucfirst($testimonial->type) }}</td>
                                </tr>
                                <tr>
                                    <th>Blood Group</th>
                                    <td>{{ $testimonial->blood_group ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $testimonial->location ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($testimonial->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Display Order</th>
                                    <td>{{ $testimonial->order }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $testimonial->created_at->format('d F, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $testimonial->updated_at->format('d F, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Testimonial Content:</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $testimonial->content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 