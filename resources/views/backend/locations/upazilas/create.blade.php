@extends('backend.layouts.master')

@section('title')
Create Upazila - Location Management
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
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
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
                <h4 class="page-title pull-left">Create Upazila</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.locations.index') }}">Locations</a></li>
                    <li><a href="{{ route('admin.locations.upazilas') }}">Upazilas</a></li>
                    <li><span>Create Upazila</span></li>
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
                    <h4 class="header-title">Create New Upazila</h4>
                </div>
                <div class="card-body">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.locations.upazilas.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="district_id">District</label>
                            <select class="form-control" id="district_id" name="district_id" required>
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }} ({{ $district->bn_name }}) - {{ $district->division->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Upazila Name (English)</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter upazila name in English" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="bn_name">Upazila Name (Bengali)</label>
                            <input type="text" class="form-control" id="bn_name" name="bn_name" placeholder="Enter upazila name in Bengali" value="{{ old('bn_name') }}" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Create Upazila</button>
                            <a href="{{ route('admin.locations.upazilas') }}" class="btn btn-secondary">Cancel</a>
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
        // You can add JavaScript for cascading dropdown (if needed)
    });
</script>
@endsection 