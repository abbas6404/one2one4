@extends('backend.layouts.master')

@section('title')
Edit District - Location Management
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
    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }
</style>
@endsection

@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit District</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.locations.index') }}">Locations</a></li>
                    <li><a href="{{ route('admin.locations.districts') }}">Districts</a></li>
                    <li><span>Edit District</span></li>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Edit District: {{ $district->name }}</h4>
                    <form action="{{ route('admin.locations.districts.destroy', $district->id) }}" method="POST" id="deleteForm" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fa fa-trash"></i> Delete District
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.locations.districts.update', $district->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="division_id">Division</label>
                            <select class="form-control" id="division_id" name="division_id" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id', $district->division_id) == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }} ({{ $division->bn_name }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">District Name (English)</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter district name in English" value="{{ old('name', $district->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="bn_name">District Name (Bengali)</label>
                            <input type="text" class="form-control" id="bn_name" name="bn_name" placeholder="Enter district name in Bengali" value="{{ old('bn_name', $district->bn_name) }}" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update District</button>
                            <a href="{{ route('admin.locations.districts') }}" class="btn btn-secondary">Cancel</a>
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
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this district? This action cannot be undone.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection 