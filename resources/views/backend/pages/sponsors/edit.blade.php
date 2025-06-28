@extends('backend.layouts.master')

@section('title', 'Edit Sponsor')

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
    
    .current-logo {
        max-height: 150px;
        max-width: 100%;
        display: block;
        margin-bottom: 1rem;
    }
    
    /* Payment method styles */
    .payment-method-container {
        margin-bottom: 1.5rem;
    }
    
    .payment-method-option {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 4px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .payment-method-option:hover {
        background-color: #f8f9fa;
    }
    
    .payment-method-option.selected {
        border-color: #007bff;
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .payment-method-option img {
        height: 30px;
        margin-right: 1rem;
    }
    
    .payment-info-container {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 4px;
        margin-top: 1rem;
        border: 1px solid #dee2e6;
    }
    
    .preview-image {
        max-height: 150px;
        max-width: 100%;
        object-fit: contain;
    }
    
    .payment-status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .payment-completed {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .payment-pending {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit Sponsor</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.sponsors.index') }}">Sponsors</a></li>
                    <li><span>Edit Sponsor</span></li>
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
                        <h2 class="page-title">Edit Sponsor: {{ $sponsor->name }}</h2>
                    </div>
                    
                    @include('backend.layouts.partials.messages')
                    
                    <div class="form-container">
                        <form action="{{ route('admin.sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="form-section-title">Sponsor Information</h3>
                                    
                                    <div class="form-group">
                                        <label for="name" class="form-label required-field">Sponsor Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $sponsor->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="url" class="form-label">Website URL</label>
                                        <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url', $sponsor->url) }}" placeholder="https://example.com">
                                        @error('url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-help-text">Enter the sponsor's website URL (optional)</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="phone" class="form-label required-field">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $sponsor->phone) }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $sponsor->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="logo" class="form-label">Sponsor Logo</label>
                                        <div class="preview-container" id="logoPreviewContainer">
                                            @if ($sponsor->logo)
                                                <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="preview-image">
                                            @else
                                                <span class="preview-placeholder">No logo available</span>
                                            @endif
                                        </div>
                                        <div class="file-upload-container">
                                            <label class="file-upload-btn">
                                                <i class="fa fa-cloud-upload-alt mr-2"></i> Change Logo File
                                                <input type="file" name="logo" id="logo" class="file-upload-input" accept="image/*" onchange="previewLogo(this)">
                                            </label>
                                            <div class="selected-file-name" id="logoFileName">No new file selected</div>
                                        </div>
                                        <small class="form-help-text">Upload a new logo to replace the existing one (PNG, JPG, JPEG, SVG). Recommended size: 300x200px</small>
                                        @error('logo')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <h3 class="form-section-title mt-5">Payment Information</h3>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label required-field">Payment Method</label>
                                                <select class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                                    <option value="bKash" {{ old('payment_method', $sponsor->payment_method) == 'bKash' ? 'selected' : '' }}>bKash</option>
                                                    <option value="Nagad" {{ old('payment_method', $sponsor->payment_method) == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                                    <option value="Rocket" {{ old('payment_method', $sponsor->payment_method) == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                                    <option value="Bank_Transfer" {{ old('payment_method', $sponsor->payment_method) == 'Bank_Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                    <option value="Cash" {{ old('payment_method', $sponsor->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                </select>
                                                @error('payment_method')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_amount" class="form-label required-field">Payment Amount (BDT)</label>
                                                <input type="text" class="form-control @error('payment_amount') is-invalid @enderror" id="payment_amount" name="payment_amount" value="{{ old('payment_amount', $sponsor->payment_amount) }}" required>
                                                @error('payment_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_status" class="form-label required-field">Payment Status</label>
                                                <select class="form-control @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                                    <option value="pending" {{ old('payment_status', $sponsor->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="completed" {{ old('payment_status', $sponsor->payment_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                                @error('payment_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_transaction_id" class="form-label">Transaction ID</label>
                                                <input type="text" class="form-control @error('payment_transaction_id') is-invalid @enderror" id="payment_transaction_id" name="payment_transaction_id" value="{{ old('payment_transaction_id', $sponsor->payment_transaction_id) }}">
                                                @error('payment_transaction_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="payment_screenshot" class="form-label">Payment Screenshot</label>
                                        <div class="preview-container" id="screenshotPreviewContainer">
                                            @if ($sponsor->payment_screenshot)
                                                <img src="{{ asset($sponsor->payment_screenshot) }}" alt="Payment Screenshot" class="preview-image">
                                            @else
                                                <span class="preview-placeholder">No screenshot available</span>
                                            @endif
                                        </div>
                                        <small class="form-help-text text-info">Payment screenshots cannot be modified after submission.</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <h3 class="form-section-title">Display Settings</h3>
                                    
                                    <div class="form-group">
                                        <label for="order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $sponsor->order) }}" min="0">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-help-text">Lower numbers will be displayed first</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                            <option value="active" {{ old('status', $sponsor->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $sponsor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-cancel">Cancel</a>
                                <button type="submit" class="btn btn-submit">Update Sponsor</button>
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
    // Logo preview functionality
    function previewLogo(input) {
        const container = document.getElementById('logoPreviewContainer');
        const fileName = document.getElementById('logoFileName');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileName.textContent = file.name;
            
                const reader = new FileReader();
                reader.onload = function(e) {
                container.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Logo Preview">`;
                }
                reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'No new file selected';
        }
    }
    
    // Screenshot preview functionality
    function previewScreenshot(input) {
        const container = document.getElementById('screenshotPreviewContainer');
        const fileName = document.getElementById('screenshotFileName');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileName.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                container.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Screenshot Preview">`;
            }
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'No new file selected';
        }
    }
</script>
@endsection 