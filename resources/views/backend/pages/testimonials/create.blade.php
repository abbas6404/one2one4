@extends('backend.layouts.master')

@section('title', 'Create Testimonial')

@section('styles')
<style>
    .page-header {
        padding: 1.5rem 0;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    .form-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        padding: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .required-field::after {
        content: '*';
        color: #dc3545;
        margin-left: 4px;
    }
    
    .form-control {
        border-radius: 4px;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        transition: border-color 0.3s;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    
    .preview-container {
        border: 1px dashed #ced4da;
        border-radius: 4px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .preview-placeholder {
        color: #6c757d;
        font-style: italic;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }
    
    .btn-submit {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .btn-submit:hover {
        background-color: #0069d9;
    }
    
    .btn-cancel {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        font-weight: 500;
        margin-right: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .btn-cancel:hover {
        background-color: #5a6268;
    }
    
    .file-upload-container {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .file-upload-btn {
        display: inline-block;
        background: #007bff;
        color: white;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        text-align: center;
    }
    
    .file-upload-btn:hover {
        background: #0069d9;
    }
    
    .file-upload-input {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .selected-file-name {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #495057;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Create Testimonial</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                    <li><span>Create Testimonial</span></li>
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
                    <div class="page-header">
                        <h2 class="page-title">Add New Testimonial</h2>
                    </div>
                    
                    @include('backend.layouts.partials.messages')
                    
                    <div class="form-container">
                        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="form-section-title">Testimonial Information</h3>
                                    
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label required-field">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="content" class="form-label required-field">Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Enter Testimonial Content" required>{{ old('content') }}</textarea>
                                        <div class="form-help-text">Enter the testimonial message from this person</div>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="{{ old('location') }}">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="blood_group" class="form-label">Blood Group</label>
                                                <select class="form-control" id="blood_group" name="blood_group">
                                                    <option value="">Select Blood Group</option>
                                                    @foreach($bloodGroups as $key => $value)
                                                        <option value="{{ $key }}" {{ old('blood_group') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="type" class="form-label required-field">Type</label>
                                                <select class="form-control" id="type" name="type" required>
                                                    @foreach($types as $key => $value)
                                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-help-text">Donor, recipient, volunteer, etc.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <h3 class="form-section-title">Display Settings</h3>
                                    
                                    <div class="form-group mb-4">
                                        <label for="avatar" class="form-label">Avatar</label>
                                        <div class="preview-container" id="avatar-preview">
                                            <span class="preview-placeholder">Avatar preview will appear here</span>
                                        </div>
                                        <div class="file-upload-container">
                                            <div class="file-upload-btn">
                                                <i class="fa fa-upload mr-1"></i> Choose Avatar Image
                                            </div>
                                            <input type="file" class="file-upload-input" id="avatar" name="avatar" accept="image/*">
                                            <div class="selected-file-name">No file selected</div>
                                        </div>
                                        <div class="form-help-text">Upload a photo of the person. Max 2MB.</div>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="order" class="form-label required-field">Display Order</label>
                                        <input type="number" class="form-control" id="order" name="order" min="1" value="{{ old('order', 1) }}" required>
                                        <div class="form-help-text">Lower numbers will be displayed first</div>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="status" class="form-label required-field">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-cancel">Cancel</a>
                                <button type="submit" class="btn btn-submit">Save Testimonial</button>
                            </div>
                        </form>
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
        // Preview avatar before upload
        $('#avatar').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview').html('<img src="' + e.target.result + '" style="max-height: 150px; max-width: 100%; border-radius: 50%;">');
                    $('.selected-file-name').text(file.name);
                }
                reader.readAsDataURL(file);
            } else {
                $('#avatar-preview').html('<span class="preview-placeholder">Avatar preview will appear here</span>');
                $('.selected-file-name').text('No file selected');
            }
        });
    });
</script>
@endsection 