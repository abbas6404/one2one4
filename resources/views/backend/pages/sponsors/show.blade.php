@extends('backend.layouts.master')

@section('title', 'View Sponsor')

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
                    <div class="mb-4">
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-primary">Back to List</a>
                        
                        @if (Auth::guard('admin')->user()->can('sponsor.edit'))
                            <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}" class="btn btn-success">Edit</a>
                        @endif
                        
                        @if (Auth::guard('admin')->user()->can('sponsor.delete'))
                            <a class="btn btn-danger text-white" 
                               href="{{ route('admin.sponsors.destroy', $sponsor->id) }}"
                               onclick="event.preventDefault(); 
                                     document.getElementById('delete-form-{{ $sponsor->id }}').submit();">
                                Delete
                            </a>
                            <form id="delete-form-{{ $sponsor->id }}" action="{{ route('admin.sponsors.destroy', $sponsor->id) }}" method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 text-center mb-4">
                            @if ($sponsor->logo)
                                <div class="border p-3 bg-light">
                                    <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="img-fluid" style="max-height: 200px;">
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    No logo available
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">Name</th>
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
                        </div>
                    </div>
                    
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
@endsection 