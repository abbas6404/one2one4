@extends('backend.layouts.master')

@section('title')
View Gallery - Admin Panel
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    .gallery-header {
        position: relative;
        height: 300px;
        overflow: hidden;
        border-radius: 5px;
        margin-bottom: 30px;
    }
    
    .gallery-header-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .gallery-header-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        padding: 20px;
    }
    
    .gallery-header-overlay h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }
    
    .gallery-meta {
        margin-top: 10px;
        font-size: 14px;
    }
    
    .gallery-meta span {
        margin-right: 15px;
    }
    
    .gallery-meta i {
        margin-right: 5px;
    }
    
    .gallery-description {
        margin-bottom: 30px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }
    
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        grid-gap: 15px;
        margin-top: 20px;
    }
    
    .gallery-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .gallery-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    
    .gallery-image {
        height: 200px;
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
    
    .gallery-info {
        padding: 10px;
        text-align: center;
    }
    
    .gallery-info .badge {
        font-size: 11px;
        padding: 5px 8px;
    }
    
    .gallery-order {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">View Gallery</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.gallery.index') }}">Galleries</a></li>
                    <li><span>View Gallery - {{ $gallery->title }}</span></li>
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
                <div class="card-body">
                    <div class="gallery-header">
                        <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" class="gallery-header-image">
                        <div class="gallery-header-overlay">
                            <h2>{{ $gallery->title }}</h2>
                            <div class="gallery-meta">
                                <span><i class="fa fa-folder-open"></i> {{ $gallery->category->name ?? 'Uncategorized' }}</span>
                                <span><i class="fa fa-images"></i> {{ $gallery->images->count() }} Images</span>
                                <span><i class="fa fa-clock"></i> {{ $gallery->created_at->format('d M Y, h:i A') }}</span>
                                <span>
                                    @if ($gallery->is_active)
                                        <i class="fa fa-check-circle text-success"></i> Active
                                    @else
                                        <i class="fa fa-times-circle text-danger"></i> Inactive
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-primary mr-2">Edit Gallery</a>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                    
                    @if ($gallery->description)
                    <div class="gallery-description">
                        <h5>Description</h5>
                        <p>{{ $gallery->description }}</p>
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <h5>Gallery Images</h5>
                        
                        @if ($gallery->images->count() > 0)
                        <div class="gallery-grid">
                            @foreach($gallery->images as $image)
                                <div class="gallery-item">
                                    <div class="gallery-order">{{ $image->sort_order }}</div>
                                    <a href="{{ asset($image->image) }}" data-lightbox="gallery-{{ $gallery->id }}" data-title="{{ $gallery->title }} - Image {{ $image->sort_order }}">
                                        <div class="gallery-image">
                                            <img src="{{ asset($image->image) }}" alt="Gallery Image">
                                        </div>
                                    </a>
                                    <div class="gallery-info">
                                        @if ($image->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-info">
                            This gallery doesn't have any additional images yet. <a href="{{ route('admin.gallery.edit', $gallery->id) }}">Add some now!</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    $(document).ready(function() {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    });
</script>
@endsection 