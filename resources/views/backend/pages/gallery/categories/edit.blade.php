@extends('backend.layouts.master')

@section('title')
Edit Gallery Category - Admin Panel
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit Gallery Category</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.gallery-categories.index') }}">Gallery Categories</a></li>
                    <li><span>Edit Gallery Category - {{ $gallery_category->name }}</span></li>
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
                    <h4 class="header-title">Edit Gallery Category - {{ $gallery_category->name }}</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.gallery-categories.update', $gallery_category->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category Name" value="{{ $gallery_category->name }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description">{{ $gallery_category->description }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="is_active">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $gallery_category->is_active ? 'checked' : '' }}>
                                Active Status
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Category</button>
                        <a href="{{ route('admin.gallery-categories.index') }}" class="btn btn-secondary mt-4 pr-4 pl-4">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection 