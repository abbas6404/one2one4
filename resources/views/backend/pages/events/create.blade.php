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
    
    .card-header {
        background-color: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
    }
    
    .required-field {
        color: red;
        margin-left: 2px;
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
                        
                        <!-- Basic Information Section -->
                        <div class="card-header">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Event Title <span class="required-field">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter event title" value="{{ old('title') }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Event Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter event description">{{ old('description') }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="event_fee">Event Fee (if applicable)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">৳</span>
                                        </div>
                                        <input type="text" class="form-control" id="event_fee" name="event_fee" placeholder="Enter event fee" value="{{ old('event_fee') }}">
                                    </div>
                                    <small class="form-text text-muted">Leave empty if the event is free</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Event Status <span class="required-field">*</span></label>
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
                            </div>
                        </div>
                        
                        <!-- Date and Time Section -->
                        <div class="card-header">
                            <h5 class="mb-0">Date and Time</h5>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date & Time <span class="required-field">*</span></label>
                                    <input type="text" class="form-control datetimepicker" id="start_date" name="start_date" placeholder="Select start date and time" value="{{ old('start_date') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">End Date & Time <span class="required-field">*</span></label>
                                    <input type="text" class="form-control datetimepicker" id="end_date" name="end_date" placeholder="Select end date and time" value="{{ old('end_date') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Location Section -->
                        <div class="card-header">
                            <h5 class="mb-0">Location Details</h5>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="division_id">Division</label>
                                    <select class="form-control" id="division_id" name="division_id">
                                        <option value="">Select Division</option>
                                        @foreach($divisions ?? [] as $division)
                                            <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="district_id">District</label>
                                    <select class="form-control" id="district_id" name="district_id">
                                        <option value="">Select District</option>
                                        @foreach($districts ?? [] as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }} data-division="{{ $district->division_id }}">
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="upazila_id">Upazila</label>
                                    <select class="form-control" id="upazila_id" name="upazila_id">
                                        <option value="">Select Upazila</option>
                                        @foreach($upazilas ?? [] as $upazila)
                                            <option value="{{ $upazila->id }}" {{ old('upazila_id') == $upazila->id ? 'selected' : '' }} data-district="{{ $upazila->district_id }}">
                                                {{ $upazila->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Image Section -->
                        <div class="card-header">
                            <h5 class="mb-0">Event Image</h5>
                                </div>
                                
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Event Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">Recommended size: 800x450 pixels</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                        <img src="#" alt="Image Preview" id="preview-image">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Create Event
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
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
    
    // Handle dependent dropdowns for location
    $(document).ready(function() {
        // Initially hide district and upazila dropdowns
        $('#district_id option').hide();
        $('#upazila_id option').hide();
        
        // Show only districts belonging to selected division
        $('#division_id').change(function() {
            var divisionId = $(this).val();
            
            if (divisionId) {
                $('#district_id option').hide();
                $('#district_id option[value=""]').show();
                $('#district_id option[data-division="' + divisionId + '"]').show();
                $('#district_id').val('');
                
                // Reset upazila dropdown
                $('#upazila_id').val('');
                $('#upazila_id option').hide();
                $('#upazila_id option[value=""]').show();
            } else {
                $('#district_id option').hide();
                $('#district_id option[value=""]').show();
                $('#district_id').val('');
                
                $('#upazila_id option').hide();
                $('#upazila_id option[value=""]').show();
                $('#upazila_id').val('');
            }
        });
        
        // Show only upazilas belonging to selected district
        $('#district_id').change(function() {
            var districtId = $(this).val();
            
            if (districtId) {
                $('#upazila_id option').hide();
                $('#upazila_id option[value=""]').show();
                $('#upazila_id option[data-district="' + districtId + '"]').show();
                $('#upazila_id').val('');
            } else {
                $('#upazila_id option').hide();
                $('#upazila_id option[value=""]').show();
                $('#upazila_id').val('');
            }
        });
    });
</script>
@endsection 