@extends('backend.layouts.master')

@section('title')
Divisions - Location Management
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
    .table thead {
        background-color: #f8f9fa;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .btn-circle {
        border-radius: 100%;
        height: 2.5rem;
        width: 2.5rem;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-circle.btn-sm {
        height: 1.8rem;
        width: 1.8rem;
        font-size: 0.75rem;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-success {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }
    .btn-info {
        background-color: #36b9cc;
        border-color: #36b9cc;
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
                <h4 class="page-title pull-left">Divisions</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.locations.index') }}">Locations</a></li>
                    <li><span>Divisions</span></li>
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
                    <h4 class="header-title">All Divisions</h4>
                    <a href="{{ route('admin.locations.divisions.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> Add New Division
                    </a>
                </div>
                <div class="card-body">
                    @include('backend.layouts.partials.messages')

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="5%">SL</th>
                                    <th width="10%">ID</th>
                                    <th width="35%">Name (EN)</th>
                                    <th width="35%">Name (BN)</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($divisions as $division)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $division->id }}</td>
                                    <td>{{ $division->name }}</td>
                                    <td>{{ $division->bn_name }}</td>
                                    <td>
                                        <a href="{{ route('admin.locations.divisions.edit', $division->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="event.preventDefault(); 
                                                document.getElementById('delete-form-{{ $division->id }}').submit();" 
                                                class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-form-{{ $division->id }}" action="{{ route('admin.locations.divisions.destroy', $division->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
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
        });
    });
</script>
@endsection 