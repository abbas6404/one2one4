@extends('layouts.public-layout')

@section('title', 'Registration')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="color: #8a0303;">Create Your Account</h2>
                <p class="text-muted">Join our blood donation community and help save lives</p>
            </div>
            
            <div class="card border-0 shadow-lg registration-card">
                <div class="card-body p-md-5">
                    <form method="POST" action="{{ route('register.submit') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            <label for="name">
                                <span class="label-text">Full Name</span>
                                <span class="required-mark">*</span>
                            </label>
                            @error('name')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            <label for="email">
                                <span class="label-text">Email Address</span>
                                <span class="required-mark">*</span>
                            </label>
                            @error('email')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            <label for="phone">
                                <span class="label-text">Phone Number</span>
                                <span class="required-mark">*</span>
                            </label>
                            @error('phone')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender Field -->
                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-venus-mars"></i>
                            </div>
                            <select class="form-control @error('gender') is-invalid @enderror" 
                                    id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <label for="gender">
                                <span class="label-text">Gender</span>
                                <span class="required-mark">*</span>
                            </label>
                            @error('gender')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Blood Group Field -->
                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                            <select class="form-control @error('blood_group') is-invalid @enderror" 
                                    id="blood_group" name="blood_group" required>
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            <label for="blood_group">
                                <span class="label-text">Blood Group</span>
                                <span class="required-mark">*</span>
                            </label>
                            @error('blood_group')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Donation Date Field -->
                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-calendar-day"></i>
                            </div>
                            <input type="date" class="form-control @error('last_donation') is-invalid @enderror" 
                                   id="last_donation" name="last_donation" value="{{ old('last_donation') }}">
                            <label for="last_donation">
                                <span class="label-text">Last Donation Date</span>
                            </label>
                            @error('last_donation')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Present Address Section -->
                        <div class="address-section mb-4">
                            <div class="section-header mb-3">
                                <span class="section-icon"><i class="fa-solid fa-building"></i></span>
                                <h5 class="section-title">Present Address</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group custom-form-group">
                                        <div class="input-icon">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <select class="form-control @error('present_division_id') is-invalid @enderror" 
                                               id="present_division_id" name="present_division_id" required>
                                            <option value="">Select Division</option>
                                            @foreach(\App\Models\Division::all() as $division)
                                                <option value="{{ $division->id }}" 
                                                    {{ old('present_division_id') == $division->id ? 'selected' : '' }}>
                                                    {{ $division->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="present_division_id">
                                            <span class="label-text">Division</span>
                                            <span class="required-mark">*</span>
                                        </label>
                                        @error('present_division_id')
                                            <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group custom-form-group">
                                        <div class="input-icon">
                                            <i class="fa-solid fa-map-marker-alt"></i>
                                        </div>
                                        <select class="form-control @error('present_district_id') is-invalid @enderror" 
                                               id="present_district_id" name="present_district_id" required>
                                            <option value="">Select District</option>
                                        </select>
                                        <label for="present_district_id">
                                            <span class="label-text">District</span>
                                            <span class="required-mark">*</span>
                                        </label>
                                        @error('present_district_id')
                                            <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group custom-form-group">
                                        <div class="input-icon">
                                            <i class="fa-solid fa-map"></i>
                                        </div>
                                        <select class="form-control @error('present_upazila_id') is-invalid @enderror" 
                                               id="present_upazila_id" name="present_upazila_id" required>
                                            <option value="">Select Upazila</option>
                                        </select>
                                        <label for="present_upazila_id">
                                            <span class="label-text">Upazila</span>
                                            <span class="required-mark">*</span>
                                        </label>
                                        @error('present_upazila_id')
                                            <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group custom-form-group mb-0">
                                        <div class="input-icon">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <input type="text" class="form-control @error('present_address') is-invalid @enderror" 
                                               id="present_address" name="present_address" 
                                               value="{{ old('present_address') }}" required>
                                        <label for="present_address">
                                            <span class="label-text">Full Address</span>
                                            <span class="required-mark">*</span>
                                        </label>
                                        @error('present_address')
                                            <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <label for="password">
                                <span class="label-text">Password</span>
                                <span class="required-mark">*</span>
                            </label>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group custom-form-group mb-4">
                            <div class="input-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                            <label for="password_confirmation">
                                <span class="label-text">Confirm Password</span>
                                <span class="required-mark">*</span>
                            </label>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 text-white submit-btn" 
                                style="background-color: #8a0303;">
                            <span>Create Account</span>
                            <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>

                        <div class="text-center mt-4">
                            <p class="text-muted">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="link-primary">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="small text-muted">
                    By creating an account, you agree to our 
                    <a href="#" class="link-primary">Terms of Service</a> and 
                    <a href="#" class="link-primary">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Card styling */
    .registration-card {
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Form styling */
    .custom-form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .custom-form-group .form-control {
        height: 3.5rem;
        padding: 1rem 3rem;
        font-size: 1rem;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .custom-form-group .form-control:focus {
        border-color: #8a0303;
        box-shadow: 0 0 0 0.2rem rgba(138, 3, 3, 0.1);
        background-color: #fff;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 2;
    }

    .custom-form-group label {
        position: absolute;
        top: 50%;
        left: 3rem;
        transform: translateY(-50%);
        font-size: 1rem;
        color: #6c757d;
        padding: 0 0.25rem;
        background-color: transparent;
        transition: all 0.3s ease;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        pointer-events: none;
    }

    .custom-form-group .required-mark {
        color: #8a0303;
        font-weight: bold;
    }

    .custom-form-group .form-control:focus ~ label,
    .custom-form-group .form-control:not(:placeholder-shown) ~ label {
        top: 0;
        left: 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: #8a0303;
        background-color: #fff;
        padding: 0 0.5rem;
        transform: translateY(-50%) scale(0.85);
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 0.25rem;
        transition: all 0.3s ease;
    }

    .password-toggle:hover {
        color: #8a0303;
    }

    /* Address Section */
    .address-section {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(138, 3, 3, 0.1);
        color: #8a0303;
        border-radius: 50%;
    }

    .section-title {
        color: #495057;
        font-weight: 500;
        margin: 0;
    }

    /* Button styling */
    .submit-btn {
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .submit-btn:hover {
        background-color: #6b0202 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(138, 3, 3, 0.25);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    /* Link styling */
    .link-primary {
        color: #8a0303;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .link-primary:hover {
        color: #6b0202;
        text-decoration: underline;
    }

    /* Error styling */
    .invalid-feedback {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        margin-left: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
    }
</style>

<script>
    function togglePassword(id) {
        const passwordInput = document.getElementById(id);
        const icon = passwordInput.nextElementSibling.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Location dropdown handling
    document.addEventListener('DOMContentLoaded', function() {
        const presentDivisionSelect = document.getElementById('present_division_id');
        const presentDistrictSelect = document.getElementById('present_district_id');
        const presentUpazilaSelect = document.getElementById('present_upazila_id');
        
        // When division changes, update districts
        presentDivisionSelect.addEventListener('change', function() {
            const divisionId = this.value;
            if (divisionId) {
                fetch(`/get-districts/${divisionId}`)
                    .then(response => response.json())
                    .then(districts => {
                        presentDistrictSelect.innerHTML = '<option value="">Select District</option>';
                        districts.forEach(district => {
                            presentDistrictSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                        });
                        presentDistrictSelect.disabled = false;
                    });
            } else {
                presentDistrictSelect.innerHTML = '<option value="">Select District</option>';
                presentDistrictSelect.disabled = true;
            }
        });
        
        // When district changes, update upazilas
        presentDistrictSelect.addEventListener('change', function() {
            const districtId = this.value;
            if (districtId) {
                fetch(`/get-upazilas/${districtId}`)
                    .then(response => response.json())
                    .then(upazilas => {
                        presentUpazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
                        upazilas.forEach(upazila => {
                            presentUpazilaSelect.innerHTML += `<option value="${upazila.id}">${upazila.name}</option>`;
                        });
                        presentUpazilaSelect.disabled = false;
                    });
            } else {
                presentUpazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
                presentUpazilaSelect.disabled = true;
            }
        });
    });
</script>

@endsection 