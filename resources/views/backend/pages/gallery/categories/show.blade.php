@extends('backend.layouts.master')

@section('title')
View Gallery Category - Admin Panel
@endsection

@section('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        grid-gap: 15px;
    }
    
    .gallery-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    
    .gallery-image {
        height: 180px;
        overflow: hidden;
    }
    
    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover .gallery-image img {
        transform: scale(1.05);
    }
    
    .gallery-content {
        padding: 15px;
    }
    
    .gallery-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 40px;
    }
    
    .gallery-status {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 12px;
        margin-bottom: 10px;
    }
    
    .gallery-description {
        color: #666;
        font-size: 13px;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 36px;
    }
    
    .gallery-actions {
        display: flex;
        justify-content: space-between;
    }
    
    .gallery-actions a {
        flex: 1;
        padding: 5px;
        text-align: center;
        font-size: 13px;
        margin: 0 2px;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">View Gallery Category</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.gallery-categories.index') }}">Gallery Categories</a></li>
                    <li><span>View Category - {{ $gallery_category->name }}</span></li>
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="header-title">Category Details</h4>
                        <div>
                            <a href="{{ route('admin.gallery-categories.edit', $gallery_category->id) }}" class="btn btn-primary">Edit Category</a>
                            <a href="{{ route('admin.gallery-categories.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID</th>
                                    <td>{{ $gallery_category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $gallery_category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $gallery_category->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($gallery_category->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Gallery Count</th>
                                    <td>{{ $gallery_category->galleries->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $gallery_category->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $gallery_category->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $gallery_category->description ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Galleries in this Category</h4>
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">Add New Gallery</a>
                        </div>
                        
                        <div class="gallery-grid">
                            @forelse($gallery_category->galleries as $gallery)
                                <div class="gallery-item">
                                    <div class="gallery-image">
                                        <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}">
                                    </div>
                                    <div class="gallery-content">
                                        <h5 class="gallery-title">{{ $gallery->title }}</h5>
                                        <div>
                                            @if ($gallery->is_active)
                                                <span class="gallery-status badge-success">Active</span>
                                            @else
                                                <span class="gallery-status badge-danger">Inactive</span>
                                            @endif
                                        </div>
                                        <p class="gallery-description">{{ $gallery->description }}</p>
                                        <div class="gallery-actions">
                                            <a href="{{ route('admin.gallery.show', $gallery->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-success">Edit</a>
                                            
                                            <a href="{{ route('admin.gallery.destroy', $gallery->id) }}" class="btn btn-sm btn-danger"
                                            onclick="event.preventDefault(); document.getElementById('delete-gallery-form-{{ $gallery->id }}').submit();">
                                                Delete
                                            </a>
                                            <form id="delete-gallery-form-{{ $gallery->id }}" action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">No galleries found in this category.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection 