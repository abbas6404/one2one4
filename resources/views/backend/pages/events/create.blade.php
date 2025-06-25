@extends('backend.layouts.master')

@section('title', 'Create Event')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .custom-file-label::after {
        content: "Browse";
    }
    
    .image-preview {
        max-width: 300px;
        margin-top: 20px;
    }
    
    .image-preview img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Create Event</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.events.index') }}">Events</a></li>
                    <li><span>Create Event</span></li>
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
                    <h4 class="header-title">Create New Event</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter event title" value="{{ old('title') }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Event Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter event description">{{ old('description') }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="location">Event Location</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter event location" value="{{ old('location') }}">
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date">Start Date & Time <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control datetimepicker" id="start_date" name="start_date" placeholder="Select start date and time" value="{{ old('start_date') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date">End Date & Time <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control datetimepicker" id="end_date" name="end_date" placeholder="Select end date and time" value="{{ old('end_date') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Event Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="d-block">Featured Event</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_featured">Mark as featured</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Event Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">Recommended size: 800x450 pixels</small>
                                    <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                        <img src="#" alt="Image Preview" id="preview-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Create Event</button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize datetime picker
    flatpickr(".datetimepicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        minDate: "today"
    });
    
    // Image preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            
            reader.readAsDataURL(input.files[0]);
            
            // Update file input label
            var fileName = input.files[0].name;
            $(input).next('.custom-file-label').html(fileName);
        }
    }
</script>
@endsection 