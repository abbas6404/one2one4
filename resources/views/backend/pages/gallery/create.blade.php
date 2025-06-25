@extends('backend.layouts.master')

@section('title')
Create Gallery - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .preview-container {
        margin-top: 15px;
    }
    
    .main-preview {
        width: 100%;
        height: 200px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    
    .main-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .additional-previews {
        display: flex;
        flex-wrap: wrap;
        margin-top: 15px;
        gap: 10px;
    }
    
    .additional-preview {
        width: 100px;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        position: relative;
    }
    
    .additional-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .remove-preview {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(0,0,0,0.5);
        color: white;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .upload-placeholder {
        color: #6c757d;
        font-size: 14px;
        text-align: center;
    }
    
    .upload-placeholder i {
        font-size: 32px;
        display: block;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Create Gallery</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.gallery.index') }}">Galleries</a></li>
                    <li><span>Create Gallery</span></li>
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
                    <h4 class="header-title">Create New Gallery</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Gallery Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Gallery Title" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Description"></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="main_image">Main Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" id="main_image" name="main_image" accept="image/*" required>
                                <div class="preview-container">
                                    <div class="main-preview" id="main-preview">
                                        <div class="upload-placeholder">
                                            <i class="fa fa-cloud-upload-alt"></i>
                                            <p>Click to select main image</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="additional_images">Additional Images</label>
                                <input type="file" class="form-control-file" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                                <small class="form-text text-muted">You can select multiple images (maximum 10)</small>
                                <div class="additional-previews" id="additional-previews"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active">Active Status</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Gallery</button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary mt-4 pr-4 pl-4">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize select2
        $('.select2').select2();
        
        // Handle main image preview
        $('#main_image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#main-preview').html('<img src="' + e.target.result + '" alt="Preview">');
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Handle additional images preview
        $('#additional_images').change(function() {
            const files = this.files;
            $('#additional-previews').empty();
            
            if (files.length > 10) {
                alert('You can only select up to 10 additional images');
                this.value = '';
                return;
            }
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewDiv = $('<div class="additional-preview"></div>');
                    previewDiv.html('<img src="' + e.target.result + '" alt="Preview">');
                    $('#additional-previews').append(previewDiv);
                }
                
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection 