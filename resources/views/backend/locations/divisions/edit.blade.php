@extends('backend.layouts.master')

@section('title')
Edit Division - Location Management
@endsection

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(34, 39, 46, 0.1);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }
    .required:after {
        content: " *";
        color: red;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>
@endsection

@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit Division</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.locations.index') }}">Locations</a></li>
                    <li><a href="{{ route('admin.locations.divisions') }}">Divisions</a></li>
                    <li><span>Edit Division</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Edit Division: {{ $division->name }}</h4>
                </div>
                <div class="card-body">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.locations.divisions.update', $division->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="required">Division Name (English)</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter division name in English" value="{{ old('name', $division->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="bn_name" class="required">Division Name (Bangla)</label>
                                    <input type="text" class="form-control" id="bn_name" name="bn_name" placeholder="Enter division name in Bangla" value="{{ old('bn_name', $division->bn_name) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Division</button>
                            <a href="{{ route('admin.locations.divisions') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 