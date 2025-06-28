@extends('layouts.public-layout')

@section('title', app('website-content')->get('internal_program.title', 'Internal Programs Registration'))

@push('styles')
<style>
    .internal-program-section {
        padding: 60px 0;
        background-color: #f8f9fa;
    }
    
    .program-header {
        margin-bottom: 40px;
        text-align: center;
    }
    
    .program-title {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .program-subtitle {
        font-size: 1.2rem;
        color: var(--dark-gray);
        margin-bottom: 20px;
    }
    
    .program-description {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .registration-form-container {
        background-color: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    
    .form-section-title {
        margin-bottom: 25px;
        color: var(--dark);
        font-weight: 600;
        text-align: center;
    }
    
    .required-field::after {
        content: "*";
        color: var(--danger);
        margin-left: 4px;
    }
    
    .blood-group-select {
        color: var(--dark);
    }
    
    .submit-btn {
        padding: 10px 30px;
        font-weight: 600;
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .submit-btn:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }
    
    .contact-info {
        text-align: center;
        font-size: 0.9rem;
        color: var(--gray);
    }
    
    .payment-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border-left: 4px solid var(--primary);
    }
    
    .screenshot-preview {
        max-width: 100%;
        max-height: 200px;
        margin-top: 10px;
        display: none;
        border-radius: 5px;
    }
    
    /* Event Details Styles */
    .event-details-container {
        margin: 15px 0 25px;
        transition: all 0.3s ease;
    }
    
    .event-details-container .card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: none;
    }
    
    .event-image-container {
        height: 200px;
        overflow: hidden;
        background-color: #f5f5f5;
    }
    
    .event-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .event-details-container .card-body {
        padding: 1.25rem;
    }
    
    .event-details-container .card-title {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .event-details-container .card-text {
        color: var(--dark-gray);
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .event-meta {
        font-size: 0.9rem;
        color: var(--dark-gray);
    }
    
    .event-meta p {
        margin-bottom: 0.5rem;
    }
    
    .event-meta strong {
        color: var(--dark);
        font-weight: 600;
    }
    
    .event-meta-header {
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        margin-bottom: 1rem !important;
    }
    
    #event-location {
        margin-bottom: 0;
        color: var(--dark-gray);
    }
    
    /* Featured event styles */
    select option.featured-event {
        font-weight: bold;
        color: var(--primary);
        background-color: rgba(178, 34, 34, 0.05);
    }
    
    .event-badge {
        display: inline-block;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        margin-left: 0.5rem;
        vertical-align: middle;
    }
    
    .event-badge.featured {
        background-color: var(--primary);
        color: white;
    }
    
    /* Success message styles */
    .registration-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        text-align: center;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-radius: 8px;
    }
    
    .registration-success .success-icon {
        font-size: 3rem;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .registration-success .alert-heading {
        color: #155724;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .registration-success p {
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    
    /* Success modal styles */
    #successModal .success-icon {
        font-size: 4rem;
        color: #28a745;
    }
    
    #successModal .success-message {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    
    #successModal .modal-header {
        border-top-left-radius: calc(0.3rem - 1px);
        border-top-right-radius: calc(0.3rem - 1px);
    }
    
    #successModal .modal-content {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    #successModal .btn-success {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    #successModal .btn-success:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }
    
    /* Registration status check styles */
    .registration-status-check {
        margin-top: 2rem;
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    
    .registration-status-check h4 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .registration-status-check .card {
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .registration-status-check .input-group {
        margin-bottom: 0.5rem;
    }
    
    .registration-status-check .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .registration-status-check .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }
    
    #statusResult .alert {
        margin-bottom: 0;
        border-radius: 8px;
    }
    
    #statusResult .alert-heading {
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .registration-details p {
        margin-bottom: 0.5rem;
    }
    
    .registration-details p:last-child {
        margin-bottom: 0;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@section('content')
<section class="internal-program-section">
    <div class="container">
        <div class="program-header">
            <h1 class="program-title">{{ app('website-content')->get('internal_program.title', 'Internal Programs Registration') }}</h1>
            <p class="program-subtitle">{{ app('website-content')->get('internal_program.subtitle', 'Join our exclusive internal programs for SSC-12 & HSC-14 batch members') }}</p>
            <div class="program-description">
                <p>{{ app('website-content')->get('internal_program.description', 'Our internal programs are designed specifically for our batch members to strengthen our community bonds, promote blood donation awareness, and engage in social welfare activities. Register below to participate in upcoming events and receive your exclusive batch T-shirt.') }}</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="registration-form-container">
                    <h3 class="form-section-title">{{ app('website-content')->get('internal_program.registration.title', 'Program Registration') }}</h3>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('internal-program.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label required-field">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label required-field">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address (Optional)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label required-field">Blood Group</label>
                                <select class="form-select blood-group-select @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" required>
                                    <option value="" selected disabled>Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="division_id" class="form-label required-field">Division</label>
                                <select class="form-select @error('division_id') is-invalid @enderror" id="division_id" name="division_id" required>
                                    <option value="" selected disabled>Select Division</option>
                                    @foreach($divisions ?? [] as $division)
                                        <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="district_id" class="form-label required-field">District</label>
                                <select class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id" required disabled>
                                    <option value="" selected disabled>Select District</option>
                                </select>
                                @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="upazila_id" class="form-label required-field">Upazila</label>
                                <select class="form-select @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id" required disabled>
                                    <option value="" selected disabled>Select Upazila</option>
                                </select>
                                @error('upazila_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tshirt_size" class="form-label required-field">T-shirt Size</label>
                            <select class="form-select @error('tshirt_size') is-invalid @enderror" id="tshirt_size" name="tshirt_size" required>
                                <option value="" selected disabled>Select T-shirt Size</option>
                                <option value="S" {{ old('tshirt_size') == 'S' ? 'selected' : '' }}>Small (S)</option>
                                <option value="M" {{ old('tshirt_size') == 'M' ? 'selected' : '' }}>Medium (M)</option>
                                <option value="L" {{ old('tshirt_size') == 'L' ? 'selected' : '' }}>Large (L)</option>
                                <option value="XL" {{ old('tshirt_size') == 'XL' ? 'selected' : '' }}>Extra Large (XL)</option>
                                <option value="XXL" {{ old('tshirt_size') == 'XXL' ? 'selected' : '' }}>Double XL (XXL)</option>
                            </select>
                            @error('tshirt_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Featured Events Dropdown -->
                        <div class="mb-3">
                            <label for="featured_event" class="form-label">Select Event</label>
                            <select class="form-select" id="featured_event" name="event_id">
                                <option value="">Select an Event (Optional)</option>
                                @if(isset($activeEvents) && count($activeEvents) > 0)
                                    @foreach($activeEvents as $event)
                                        <option value="{{ $event->id }}" 
                                            data-title="{{ $event->title }}"
                                            data-description="{{ $event->description }}"
                                            data-fee="{{ $event->event_fee }}"
                                            data-start="{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('M d, Y h:i A') : '' }}"
                                            data-end="{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('M d, Y h:i A') : '' }}"
                                            data-location="{{ ($event->division->name ?? '') . ' ' . ($event->district->name ?? '') . ' ' . ($event->upazila->name ?? '') }}"
                                            data-featured="{{ $event->is_featured ? 'true' : 'false' }}"
                                            {{ isset($defaultEvent) && $defaultEvent->id == $event->id ? 'selected' : '' }}
                                            {{ old('event_id') == $event->id ? 'selected' : '' }}
                                            class="{{ $event->is_featured ? 'featured-event' : '' }}">
                                            {{ $event->title }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No events available at this time</option>
                                @endif
                            </select>
                        </div>
                        
                        <!-- Hidden field for event fee -->
                        <input type="hidden" id="payment_amount" name="payment_amount" value="{{ old('payment_amount') }}">
                        
                        <!-- Event Details Container -->
                        <div class="event-details-container mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="event-meta-header d-flex flex-wrap align-items-center mb-3">
                                        <span id="event-fee" style="display: none;" class="me-3"><strong>Fee:</strong> <span></span></span>
                                        <span id="event-start" style="display: none;" class="me-3"><strong>Starts:</strong> <span></span></span>
                                        <span id="event-end" style="display: none;"><strong>Ends:</strong> <span></span></span>
                                    </div>
                                    <p id="event-description" class="card-text">Select an event to see details about the event including fees, location, and dates.</p>
                                    <p id="event-location" style="display: none;"><strong>Location:</strong> <span></span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label required-field">Payment Method</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="" selected disabled>Select Payment Method</option>
                                    <option value="bKash" {{ old('payment_method') == 'bKash' ? 'selected' : '' }}>bKash</option>
                                    <option value="Nagad" {{ old('payment_method') == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                    <option value="Rocket" {{ old('payment_method') == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank_Transfer" {{ old('payment_method') == 'Bank_Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="trx_id" class="form-label">Transaction ID (Optional)</label>
                                <input type="text" class="form-control @error('trx_id') is-invalid @enderror" id="trx_id" name="trx_id" value="{{ old('trx_id') }}">
                                @error('trx_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Payment Information Display -->
                        <div class="mb-3 payment-info-container" style="display: none;">
                            <div class="alert alert-info payment-details">
                                <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Payment Information</h6>
                                <div id="payment-details">
                                    <!-- Payment details will be loaded here -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="screenshot" class="form-label required-field">Payment Screenshot</label>
                            <input type="file" class="form-control @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot" accept="image/*" required>
                            <img id="screenshot-preview" class="screenshot-preview" alt="Payment Screenshot Preview">
                            @error('screenshot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary submit-btn">Submit Registration</button>
                        </div>
                    </form>
                </div>
                
                <div class="registration-status-check">
                    <h4 class="text-center mb-3">Check Registration Status</h4>
                    <div class="card">
                        <div class="card-body">
                            <form id="statusCheckForm" action="{{ route('internal-program.check-status') }}" method="POST" class="mb-0">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
                                    <button class="btn btn-primary" type="submit">Check Status</button>
                                </div>
                                <small class="form-text text-muted">Enter the phone number you used during registration to check your status.</small>
                            </form>
                        </div>
                    </div>
                    
                    <div id="statusResult" class="mt-3" style="display: none;">
                        <!-- Status results will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Registration Successful!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="success-icon mb-4">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="success-message">{{ session('success') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Initialize event details on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Show success modal if it exists
        var successModal = document.getElementById('successModal');
        if (successModal) {
            var modal = new bootstrap.Modal(successModal);
            modal.show();
        }
        
        const eventSelect = document.getElementById('featured_event');
        
        // Check if there's a selected event
        if (eventSelect.selectedIndex > 0) {
            // Trigger the change event to populate event details
            const changeEvent = new Event('change');
            eventSelect.dispatchEvent(changeEvent);
        } else {
            // No event selected, show default message
            document.getElementById('event-description').textContent = 'Select an event to see details about the event including fees, location, and dates.';
            document.getElementById('event-fee').style.display = 'none';
            document.getElementById('event-location').style.display = 'none';
            document.getElementById('event-start').style.display = 'none';
            document.getElementById('event-end').style.display = 'none';
        }
        
        // Highlight featured events in the dropdown with a different style
        Array.from(eventSelect.options).forEach(option => {
            if (option.getAttribute('data-featured') === 'true') {
                option.classList.add('text-primary', 'fw-bold');
            }
        });
    });

    // Preview uploaded screenshot
    document.getElementById('screenshot').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('screenshot-preview');
                preview.src = event.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Handle featured event selection
    document.getElementById('featured_event').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const eventDetailsContainer = document.querySelector('.event-details-container');
        
        if (this.value === '') {
            // No event selected, reset to default content
            document.getElementById('event-description').textContent = 'Select an event to see details about the event including fees, location, and dates.';
            document.getElementById('event-fee').style.display = 'none';
            document.getElementById('event-location').style.display = 'none';
            document.getElementById('event-start').style.display = 'none';
            document.getElementById('event-end').style.display = 'none';
            document.getElementById('payment_amount').value = '';
            return;
        }
        
        // Update event description
        document.getElementById('event-description').textContent = selectedOption.getAttribute('data-description');
        
        // Update event fee if available
        const eventFeeElement = document.getElementById('event-fee');
        const feeValue = selectedOption.getAttribute('data-fee');
        if (feeValue) {
            eventFeeElement.style.display = 'inline-block';
            eventFeeElement.querySelector('span').textContent = feeValue;
            // Set the hidden payment_amount field
            document.getElementById('payment_amount').value = feeValue;
        } else {
            eventFeeElement.style.display = 'none';
            document.getElementById('payment_amount').value = '';
        }
        
        // Update event location if available
        const eventLocationElement = document.getElementById('event-location');
        const locationValue = selectedOption.getAttribute('data-location').trim();
        if (locationValue) {
            eventLocationElement.style.display = 'block';
            eventLocationElement.querySelector('span').textContent = locationValue;
        } else {
            eventLocationElement.style.display = 'none';
        }
        
        // Update event start time if available
        const eventStartElement = document.getElementById('event-start');
        const startValue = selectedOption.getAttribute('data-start');
        if (startValue) {
            eventStartElement.style.display = 'inline-block';
            eventStartElement.querySelector('span').textContent = startValue;
        } else {
            eventStartElement.style.display = 'none';
        }
        
        // Update event end time if available
        const eventEndElement = document.getElementById('event-end');
        const endValue = selectedOption.getAttribute('data-end');
        if (endValue) {
            eventEndElement.style.display = 'inline-block';
            eventEndElement.querySelector('span').textContent = endValue;
        } else {
            eventEndElement.style.display = 'none';
        }
    });
    
    // Handle division, district, and upazila selection
    document.getElementById('division_id').addEventListener('change', function() {
        const divisionId = this.value;
        const districtSelect = document.getElementById('district_id');
        const upazilaSelect = document.getElementById('upazila_id');
        
        // Reset district and upazila dropdowns
        districtSelect.innerHTML = '<option value="" selected disabled>Select District</option>';
        upazilaSelect.innerHTML = '<option value="" selected disabled>Select Upazila</option>';
        upazilaSelect.disabled = true;
        
        if (!divisionId) {
            districtSelect.disabled = true;
            return;
        }
        
        // Enable district dropdown and show loading
        districtSelect.disabled = false;
        districtSelect.innerHTML = '<option value="" selected disabled>Loading districts...</option>';
        
        // Fetch districts for the selected division
        fetch(`/api/divisions/${divisionId}/districts`)
            .then(response => response.json())
            .then(districts => {
                districtSelect.innerHTML = '<option value="" selected disabled>Select District</option>';
                
                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching districts:', error);
                districtSelect.innerHTML = '<option value="" selected disabled>Error loading districts</option>';
            });
    });
    
    document.getElementById('district_id').addEventListener('change', function() {
        const districtId = this.value;
        const upazilaSelect = document.getElementById('upazila_id');
        
        // Reset upazila dropdown
        upazilaSelect.innerHTML = '<option value="" selected disabled>Select Upazila</option>';
        
        if (!districtId) {
            upazilaSelect.disabled = true;
            return;
        }
        
        // Enable upazila dropdown and show loading
        upazilaSelect.disabled = false;
        upazilaSelect.innerHTML = '<option value="" selected disabled>Loading upazilas...</option>';
        
        // Fetch upazilas for the selected district
        fetch(`/api/districts/${districtId}/upazilas`)
            .then(response => response.json())
            .then(upazilas => {
                upazilaSelect.innerHTML = '<option value="" selected disabled>Select Upazila</option>';
                
                upazilas.forEach(upazila => {
                    const option = document.createElement('option');
                    option.value = upazila.id;
                    option.textContent = upazila.name;
                    upazilaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching upazilas:', error);
                upazilaSelect.innerHTML = '<option value="" selected disabled>Error loading upazilas</option>';
            });
    });
    
    // Handle payment method change
    document.getElementById('payment_method').addEventListener('change', function() {
        const paymentMethod = this.value;
        
        // Hide payment info container by default
        document.querySelector('.payment-info-container').style.display = 'none';
        
        if (!paymentMethod) {
            return; // No payment method selected
        }
        
        // Show the container
        document.querySelector('.payment-info-container').style.display = 'block';
        
        // Handle Cash payment method directly
        if (paymentMethod === 'Cash') {
            document.getElementById('payment-details').innerHTML = `
                <div class="d-flex align-items-center mb-2">
                    <div class="payment-icon me-2">
                        <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Cash Payment</div>
                        <div class="text-muted">In-person payment</div>
                    </div>
                </div>
                <p class="mb-0 text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Please bring cash payment when you visit our office. Our team will provide you with a receipt.
                </p>
            `;
            return;
        }
        
        // For other payment methods, fetch from server
        document.getElementById('payment-details').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading payment information...</div>';
        
        // Fetch payment info via AJAX
        fetch('/sponsor/payment-info/' + paymentMethod)
            .then(response => response.json())
            .then(data => {
                let detailsHtml = '';
                
                if (paymentMethod === 'bKash' || paymentMethod === 'Nagad' || paymentMethod === 'Rocket') {
                    detailsHtml = `
                        <p class="mb-1">Please send your payment to:</p>
                        <div class="d-flex align-items-center mb-2">
                            <div class="payment-icon me-2">
                                <img src="/images/payment-icons/${paymentMethod.toLowerCase()}.${paymentMethod === 'Nagad' ? 'webp' : 'png'}" alt="${paymentMethod}" width="40" height="40">
                            </div>
                            <div>
                                <div class="fw-bold">${paymentMethod} Number:</div>
                                <div class="payment-number fs-5">${data.number}</div>
                                <div class="text-muted small">${data.type} Account</div>
                            </div>
                        </div>
                        <p class="mb-1 text-muted small">
                            <i class="fas fa-info-circle me-1"></i> 
                            After sending payment, please take a screenshot of the transaction and upload it below.
                        </p>
                    `;
                } else if (paymentMethod === 'Bank_Transfer') {
                    detailsHtml = `
                        <p class="mb-1">Please transfer your payment to:</p>
                        <div class="d-flex align-items-center mb-2">
                            <div class="payment-icon me-2">
                                <i class="fas fa-university fa-2x text-info"></i>
                            </div>
                            <div>
                                <div class="fw-bold">${data.bank_name}</div>
                                <div class="text-muted small">Bank Transfer</div>
                            </div>
                        </div>
                        <div class="bank-details p-2 mb-2 bg-light rounded">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold">Account Name:</td>
                                    <td>${data.account_name}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Account Number:</td>
                                    <td class="payment-number">${data.account_number}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Branch:</td>
                                    <td>${data.branch}</td>
                                </tr>
                            </table>
                        </div>
                        <p class="mb-1 text-muted small">
                            <i class="fas fa-info-circle me-1"></i> 
                            After making the transfer, please take a screenshot or photo of the receipt and upload it below.
                        </p>
                    `;
                }
                
                document.getElementById('payment-details').innerHTML = detailsHtml;
            })
            .catch(error => {
                document.querySelector('.payment-info-container').style.display = 'none';
                console.error('Error fetching payment info:', error);
            });
    });

    // Handle registration status check form submission
    document.getElementById('statusCheckForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const phoneNumber = document.getElementById('phone_number').value;
        const statusResult = document.getElementById('statusResult');
        const submitButton = this.querySelector('button[type="submit"]');
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking...';
        
        // Make AJAX request
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ phone_number: phoneNumber })
        })
        .then(response => response.json())
        .then(data => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = 'Check Status';
            
            // Show result
            statusResult.style.display = 'block';
            
            if (data.success) {
                let statusBadge = '';
                
                // Set badge color based on status
                if (data.registration.status === 'approved') {
                    statusBadge = '<span class="badge bg-success">Approved</span>';
                } else if (data.registration.status === 'rejected') {
                    statusBadge = '<span class="badge bg-danger">Rejected</span>';
                } else {
                    statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                }
                
                // Format the registration date
                const registrationDate = new Date(data.registration.created_at);
                const formattedDate = registrationDate.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                // Build the result HTML
                statusResult.innerHTML = `
                    <div class="alert alert-success">
                        <h5 class="alert-heading">Registration Found</h5>
                        <div class="registration-details">
                            <p><strong>Name:</strong> ${data.registration.name}</p>
                            <p><strong>Status:</strong> ${statusBadge}</p>
                            <p><strong>Registration Date:</strong> ${formattedDate}</p>
                            ${data.registration.event ? `<p><strong>Event:</strong> ${data.registration.event.title}</p>` : ''}
                        </div>
                    </div>
                `;
            } else {
                statusResult.innerHTML = `
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">No Registration Found</h5>
                        <p>We couldn't find any registration with the provided phone number. Please check the number and try again.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            submitButton.disabled = false;
            submitButton.textContent = 'Check Status';
            
            statusResult.style.display = 'block';
            statusResult.innerHTML = `
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Error</h5>
                    <p>An error occurred while checking your registration status. Please try again later.</p>
                </div>
            `;
        });
    });
</script>
@endpush 