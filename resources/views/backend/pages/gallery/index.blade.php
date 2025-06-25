@extends('backend.layouts.master')

@section('title')
Galleries - Admin Panel
@endsection

@section('styles')
<!-- Start datatable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">

<style>
    .gallery-thumbnail {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Galleries</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Galleries</span></li>
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
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Galleries List</h4>
                    <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{ route('admin.gallery.create') }}">Create New Gallery</a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Image</th>
                                    <th width="20%">Title</th>
                                    <th width="15%">Category</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Images Count</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($galleries as $gallery)
                               <tr>
                                    <td>{{ $gallery->id }}</td>
                                    <td>
                                        <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" class="gallery-thumbnail">
                                    </td>
                                    <td>{{ $gallery->title }}</td>
                                    <td>{{ $gallery->category->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($gallery->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $gallery->images_count ?? 0 }}</td>
                                    <td>
                                        <a class="btn btn-info text-white" href="{{ route('admin.gallery.show', $gallery->id) }}">View</a>
                                        <a class="btn btn-success text-white" href="{{ route('admin.gallery.edit', $gallery->id) }}">Edit</a>

                                        <a class="btn btn-danger text-white" href="{{ route('admin.gallery.destroy', $gallery->id) }}"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $gallery->id }}').submit();">
                                            Delete
                                        </a>

                                        <form id="delete-form-{{ $gallery->id }}" action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="display: none;">
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
        <!-- data table end -->
        
    </div>
</div>
@endsection

@section('scripts')
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>
    /*================================
    datatable active
    ==================================*/
    if ($('#dataTable').length) {
        $('#dataTable').DataTable({
            responsive: true
        });
    }
</script>
@endsection 