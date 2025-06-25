@extends('backend.layouts.master')

@section('title', 'Add New Sponsor')

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
    
    /* Updated file input styling */
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
                <h4 class="page-title pull-left">Add New Sponsor</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.sponsors.index') }}">Sponsors</a></li>
                    <li><span>Add New Sponsor</span></li>
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
                        <h2 class="page-title">Add New Sponsor</h2>
                    </div>
                    
                    @include('backend.layouts.partials.messages')
                    
                    <div class="form-container">
                        <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="form-section-title">Sponsor Information</h3>
                                    
                                    <div class="form-group mb-4">
                                        <label for="name" class="form-label required-field">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter sponsor name" value="{{ old('name') }}" required>
                                    </div>
                                    
                                    <div class="form-group mb-4">
                                        <label for="url" class="form-label">Website URL</label>
                                        <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com" value="{{ old('url') }}">
                                        <div class="form-help-text">Enter the full URL including http:// or https://</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <h3 class="form-section-title">Display Settings</h3>
                                    
                                    <div class="form-group mb-4">
                                        <label for="logo" class="form-label required-field">Logo</label>
                                        <div class="preview-container" id="logo-preview">
                                            <span class="preview-placeholder">Logo preview will appear here</span>
                                        </div>
                                        <div class="file-upload-container">
                                            <div class="file-upload-btn">
                                                <i class="fa fa-upload mr-1"></i> Choose Logo File
                                            </div>
                                            <input type="file" class="file-upload-input" id="logo" name="logo" accept="image/*" required>
                                            <div class="selected-file-name">No file selected</div>
                                        </div>
                                        <div class="form-help-text">Upload the sponsor's logo. Max 2MB. Recommended size: 200x100px</div>
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
                                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-cancel">Cancel</a>
                                <button type="submit" class="btn btn-submit">Save Sponsor</button>
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
        // Preview logo before upload
        $('#logo').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo-preview').html('<img src="' + e.target.result + '" style="max-height: 150px; max-width: 100%;">');
                    $('.selected-file-name').text(file.name);
                }
                reader.readAsDataURL(file);
            } else {
                $('#logo-preview').html('<span class="preview-placeholder">Logo preview will appear here</span>');
                $('.selected-file-name').text('No file selected');
            }
        });
    });
</script>
@endsection 