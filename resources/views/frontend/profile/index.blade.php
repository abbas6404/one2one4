@extends('frontend.layouts.frontend')

@section('title', 'Profile')

@section('content')
<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 d-none d-lg-block">Profile</h1>
        <div class="d-none d-lg-block">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </button>
            <button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="fas fa-key me-2"></i>Change Password
            </button>
        </div>
    </div>

    <div class="row d-lg-none pt-2"></div>
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="profile-picture-container mb-3 position-relative">
                        <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('images/default-avatar.jpg') }}" 
                             alt="Profile Picture" class="profile-picture">
                        @if(auth()->user()->is_donor)
                            <div class="donor-badge position-absolute bottom-0 end-0 text-white rounded-circle p-2 shadow-sm" 
                                 style="transform: translate(25%, 25%);">
                                <i class="fas fa-tint fa-lg"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                    @if(auth()->user()->is_donor)
                        <p class="text-danger mb-2">
                            <i class="fas fa-tint me-1"></i>
                            Blood Donor
                        </p>
                    @endif
                    <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                    <p class="text-muted mb-2">{{ auth()->user()->phone }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i> Message
                        </button>
                        <button id="shareProfileBtn" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#shareProfileModal">
                            <i class="fas fa-share-alt me-1"></i> Share
                        </button>
                    </div>
                    
                    <!-- Mobile Only Buttons -->
                    <div class="d-flex d-lg-none justify-content-center gap-2 mt-3">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i> Edit Profile
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i> Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <strong>Phone:</strong> {{ auth()->user()->phone }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                            <strong>Date of Birth:</strong> {{ auth()->user()->dob ? auth()->user()->dob->format('d M Y') : 'Not set' }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-id-card text-primary me-2"></i>
                            <strong>National ID:</strong> {{ auth()->user()->national_id ?? 'Not set' }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-venus-mars text-primary me-2"></i>
                            <strong>Gender:</strong> {{ ucfirst(auth()->user()->gender ?? 'Not set') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-heart text-primary me-2"></i>
                            <strong>Marital Status:</strong> {{ ucfirst(auth()->user()->marital_status ?? 'Not set') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong>Member Since:</strong> {{ auth()->user()->created_at->format('M Y') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Professional Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-briefcase text-primary me-2"></i>
                            <strong>Occupation:</strong> {{ auth()->user()->occupation ?? 'Not set' }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-pray text-primary me-2"></i>
                            <strong>Religion:</strong> {{ ucfirst(auth()->user()->religion ?? 'Not set') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                            <strong>SSC Exam Year:</strong> {{ auth()->user()->ssc_exam_year ?? 'Not set' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Permanent Address</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Division:</strong> 
                            @php
                                $division = auth()->user()->permanent_division;
                                if (is_string($division) && (str_starts_with($division, '{') || str_starts_with($division, '['))) {
                                    try {
                                        $divisionObj = json_decode($division);
                                        echo $divisionObj && isset($divisionObj->name) ? $divisionObj->name : 'Not set';
                                    } catch (\Exception $e) {
                                        echo $division ?: 'Not set';
                                    }
                                } else {
                                    echo $division ?: 'Not set';
                                }
                            @endphp
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>District:</strong> 
                            @php
                                $district = auth()->user()->permanent_district;
                                if (is_string($district) && (str_starts_with($district, '{') || str_starts_with($district, '['))) {
                                    try {
                                        $districtObj = json_decode($district);
                                        echo $districtObj && isset($districtObj->name) ? $districtObj->name : 'Not set';
                                    } catch (\Exception $e) {
                                        echo $district ?: 'Not set';
                                    }
                                } else {
                                    echo $district ?: 'Not set';
                                }
                            @endphp
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Upazila:</strong> 
                            @php
                                $subDistrict = auth()->user()->permanent_sub_district;
                                if (is_string($subDistrict) && (str_starts_with($subDistrict, '{') || str_starts_with($subDistrict, '['))) {
                                    try {
                                        $subDistrictObj = json_decode($subDistrict);
                                        echo $subDistrictObj && isset($subDistrictObj->name) ? $subDistrictObj->name : 'Not set';
                                    } catch (\Exception $e) {
                                        echo $subDistrict ?: 'Not set';
                                    }
                                } else {
                                    echo $subDistrict ?: 'Not set';
                                }
                            @endphp
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Address:</strong> {{ auth()->user()->permanent_address ?? 'Not set' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Present Address</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Division:</strong> 
                            @php
                                $division = auth()->user()->present_division;
                                if (is_string($division) && (str_starts_with($division, '{') || str_starts_with($division, '['))) {
                                    try {
                                        $divisionObj = json_decode($division);
                                        echo $divisionObj && isset($divisionObj->name) ? $divisionObj->name : 'Not set';
                                    } catch (\Exception $e) {
                                        echo $division ?: 'Not set';
                                    }
                                } else {
                                    echo $division ?: 'Not set';
                                }
                            @endphp
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>District:</strong> 
                            @php
                                $district = auth()->user()->present_district;
                                if (is_string($district) && (str_starts_with($district, '{') || str_starts_with($district, '['))) {
                                    try {
                                        $districtObj = json_decode($district);
                                        echo $districtObj && isset($districtObj->name) ? $districtObj->name : 'Not set';
                                    } catch (\Exception $e) {
                                        echo $district ?: 'Not set';
                                    }
                                } else {
                                    echo $district ?: 'Not set';
                                }
                            @endphp
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Upazila:</strong> 
                            @php
                                $subDistrict = auth()->user()->present_sub_district;
                                if (is_string($subDistrict) && (str_starts_with($subDistrict, '{') || str_starts_with($subDistrict, '['))) {
                                    try {
                                        $subDistrictObj = json_decode($subDistrict);
                                        echo $subDistrictObj && isset($subDistrictObj->name) ? $subDistrictObj->name : 'Not set';
                                    } catch (\Exception $e) {
                                        echo $subDistrict ?: 'Not set';
                                    }
                                } else {
                                    echo $subDistrict ?: 'Not set';
                                }
                            @endphp
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Address:</strong> {{ auth()->user()->present_address ?? 'Not set' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-md-12 mb-4">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-3">Total Blood Donation</h6>
                            <h2 class="mb-0">{{ auth()->user()->total_blood_donation ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-3">Blood Group</h6>
                            <h2 class="mb-0">{{ auth()->user()->blood_group ?? 'Not set' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-3">Emergency Contact</h6>
                            <h2 class="mb-0">{{ auth()->user()->emergency_contact ?? 'Not set' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-3">Last Donation Date</h6>
                            <h2 class="mb-0">{{ auth()->user()->last_donation_date ? auth()->user()->last_donation_date->format('d M Y') : 'Not set' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Conditions -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fas fa-notes-medical text-danger me-2"></i>
                    <h5 class="card-title mb-0">Medical Information</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->medical_conditions)
                        <p class="mb-0">{{ auth()->user()->medical_conditions }}</p>
                    @else
                        <p class="text-muted mb-0">No medical conditions specified.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Donor Status <span class="text-danger">*</span></label>
                                <div class="modern-toggle-container">
                                    <input type="hidden" name="is_donor" value="0">
                                    <input type="checkbox" 
                                           id="is_donor" 
                                           name="is_donor" 
                                           class="modern-toggle-input @error('is_donor') is-invalid @enderror"
                                           value="1" 
                                           {{ old('is_donor', auth()->user()->is_donor) ? 'checked' : '' }}>
                                    <label for="is_donor" class="modern-toggle">
                                        <div class="modern-toggle-switch"></div>
                                        <div class="modern-toggle-track"></div>
                                    </label>
                                    <span class="modern-toggle-label">
                                        <i class="fas fa-tint me-1"></i>
                                        <span class="toggle-text">{{ old('is_donor', auth()->user()->is_donor) ? 'I am a Blood Donor' : 'Not a Donor' }}</span>
                                    </span>
                                </div>
                                @error('is_donor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                                       id="dob" name="dob" value="{{ old('dob', auth()->user()->dob ? auth()->user()->dob->format('Y-m-d') : '') }}">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', auth()->user()->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marital_status" class="form-label">Marital Status</label>
                                <select class="form-select @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                    <option value="">Select Status</option>
                                    <option value="single" {{ old('marital_status', auth()->user()->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('marital_status', auth()->user()->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('marital_status', auth()->user()->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('marital_status', auth()->user()->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="national_id" class="form-label">National ID</label>
                                <input type="text" class="form-control @error('national_id') is-invalid @enderror" 
                                       id="national_id" name="national_id" value="{{ old('national_id', auth()->user()->national_id) }}">
                                @error('national_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                       id="occupation" name="occupation" value="{{ old('occupation', auth()->user()->occupation) }}">
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" class="form-control @error('religion') is-invalid @enderror" 
                                       id="religion" name="religion" value="{{ old('religion', auth()->user()->religion) }}">
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label">Blood Group <span class="text-danger">*</span></label>
                                <select class="form-select @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" required>
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group', auth()->user()->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group', auth()->user()->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group', auth()->user()->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group', auth()->user()->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="O+" {{ old('blood_group', auth()->user()->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group', auth()->user()->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                    <option value="AB+" {{ old('blood_group', auth()->user()->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group', auth()->user()->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                </select>
                                @error('blood_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ssc_exam_year" class="form-label">SSC Exam Year</label>
                                <input type="number" class="form-control @error('ssc_exam_year') is-invalid @enderror" 
                                       id="ssc_exam_year" name="ssc_exam_year" value="{{ old('ssc_exam_year', auth()->user()->ssc_exam_year) }}">
                                @error('ssc_exam_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                       id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', auth()->user()->emergency_contact) }}">
                                @error('emergency_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" name="profile_picture">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="total_blood_donation" class="form-label">Total Blood Donation</label>
                                <input type="number" class="form-control @error('total_blood_donation') is-invalid @enderror" 
                                       id="total_blood_donation" name="total_blood_donation" min="0" max="100" value="{{ old('total_blood_donation', auth()->user()->total_blood_donation) }}">
                                @error('total_blood_donation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_donation_date" class="form-label">Last Donation Date</label>
                                <input type="date" class="form-control @error('last_donation_date') is-invalid @enderror" 
                                       id="last_donation_date" name="last_donation_date" value="{{ old('last_donation_date', auth()->user()->last_donation_date ? auth()->user()->last_donation_date->format('Y-m-d') : '') }}">
                                @error('last_donation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Medical Conditions -->
                            <div class="col-md-12 mb-3">
                                <label for="medical_conditions" class="form-label">Medical Conditions</label>
                                <textarea class="form-control @error('medical_conditions') is-invalid @enderror" 
                                        id="medical_conditions" 
                                        name="medical_conditions" 
                                        rows="4"
                                        placeholder="Please list any medical conditions, allergies, or medications that may affect blood donation">{{ old('medical_conditions', auth()->user()->medical_conditions) }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    List any medical conditions, allergies, or medications that may affect blood donation.
                                </div>
                                @error('medical_conditions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Permanent Address -->
                        <h6 class="mt-4 mb-3">Permanent Address</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="permanent_division_id" class="form-label">Division</label>
                                <select class="form-select permanent-division @error('permanent_division_id') is-invalid @enderror" 
                                        id="permanent_division_id" name="permanent_division_id" data-target="permanent">
                                    <option value="">Select Division</option>
                                </select>
                                @error('permanent_division_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="permanent_district_id" class="form-label">District</label>
                                <select class="form-select permanent-district @error('permanent_district_id') is-invalid @enderror" 
                                        id="permanent_district_id" name="permanent_district_id" data-target="permanent" disabled>
                                    <option value="">Select District</option>
                                </select>
                                @error('permanent_district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="permanent_upazila_id" class="form-label">Upazila</label>
                                <select class="form-select permanent-upazila @error('permanent_upazila_id') is-invalid @enderror" 
                                        id="permanent_upazila_id" name="permanent_upazila_id" data-target="permanent" disabled>
                                    <option value="">Select Upazila</option>
                                </select>
                                @error('permanent_upazila_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="permanent_address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('permanent_address') is-invalid @enderror" 
                                       id="permanent_address" name="permanent_address" value="{{ old('permanent_address', auth()->user()->permanent_address) }}">
                                @error('permanent_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Present Address -->
                        <h6 class="mt-4 mb-3">Present Address</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="present_division_id" class="form-label">Division <span class="text-danger">*</span></label>
                                <select class="form-select present-division @error('present_division_id') is-invalid @enderror" 
                                        id="present_division_id" name="present_division_id" data-target="present" required>
                                    <option value="">Select Division</option>
                                </select>
                                @error('present_division_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="present_district_id" class="form-label">District <span class="text-danger">*</span></label>
                                <select class="form-select present-district @error('present_district_id') is-invalid @enderror" 
                                        id="present_district_id" name="present_district_id" data-target="present" disabled required>
                                    <option value="">Select District</option>
                                </select>
                                @error('present_district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="present_upazila_id" class="form-label">Upazila <span class="text-danger">*</span></label>
                                <select class="form-select present-upazila @error('present_upazila_id') is-invalid @enderror" 
                                        id="present_upazila_id" name="present_upazila_id" data-target="present" disabled required>
                                    <option value="">Select Upazila</option>
                                </select>
                                @error('present_upazila_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="present_address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('present_address') is-invalid @enderror" 
                                       id="present_address" name="present_address" value="{{ old('present_address', auth()->user()->present_address) }}" required>
                                @error('present_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Share Profile Modal -->
    <div class="modal fade" id="shareProfileModal" tabindex="-1" aria-labelledby="shareProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="shareProfileModalLabel">Share Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-3">
                        <p class="text-muted">Share this blood donor profile on social media</p>
                    </div>
                    
                    <div id="shareCard" class="share-card mb-4">
                        <div class="share-card-header">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="share-card-logo">
                            <div class="share-card-title">Blood Donor Profile</div>
                        </div>
                        <div class="share-card-body">
                            <div class="share-card-profile">
                                <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('images/default-avatar.jpg') }}" 
                                    alt="Profile Picture" class="share-card-img">
                                <div class="share-card-info">
                                    <h4 class="share-card-name">{{ auth()->user()->name }}</h4>
                                    <p class="share-card-blood">Blood Group: <span class="share-card-blood-group">{{ auth()->user()->blood_group ?? 'Not set' }}</span></p>
                                    <p class="share-card-location">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        @php
                                            $district = auth()->user()->present_district;
                                            if (is_string($district) && (str_starts_with($district, '{') || str_starts_with($district, '['))) {
                                                try {
                                                    $districtObj = json_decode($district);
                                                    echo $districtObj && isset($districtObj->name) ? $districtObj->name : 'Not set';
                                                } catch (\Exception $e) {
                                                    echo $district ?: 'Not set';
                                                }
                                            } else {
                                                echo $district ?: 'Not set';
                                            }
                                        @endphp
                                    </p>
                                </div>
                            </div>
                            <div class="share-card-contact">
                                <div class="share-card-contact-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <span>{{ auth()->user()->phone }}</span>
                                </div>
                                <div class="share-card-contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                            <div class="share-card-footer">
                                <p class="share-card-message">I am available for blood donation. Please contact me if you need blood.</p>
                                <div class="share-card-badge">
                                    <i class="fas fa-tint"></i> Blood Donor
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-facebook" id="shareToFacebook">
                            <i class="fab fa-facebook-f me-2"></i>Share on Facebook
                        </button>
                        <button class="btn btn-twitter" id="copyShareLink">
                            <i class="fas fa-copy me-2"></i>Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .profile-picture-container {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: visible;
        border: 3px solid #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        position: relative;
        background: #f8f9fa;
    }

    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .donor-badge {
        position: absolute;
        bottom: -15px;
        right: -15px;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        z-index: 100;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .donor-badge:hover {
        transform: scale(1.3);
    }

    .donor-badge i {
        font-size: 2.2rem;
        color: #ff0000;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }

    .donor-badge:hover i {
        transform: scale(1.1);
        color: #cc0000;
        filter: drop-shadow(0 3px 6px rgba(0,0,0,0.3));
    }

    .card {
        border: none;
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    .list-unstyled li {
        padding: 8px 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .list-unstyled li:last-child {
        border-bottom: none;
    }

    .text-primary {
        color: #8a0303 !important;
    }

    .btn-primary {
        background-color: #8a0303;
        border-color: #8a0303;
    }

    .btn-primary:hover {
        background-color: #6a0202;
        border-color: #6a0202;
    }

    .btn-outline-primary {
        color: #8a0303;
        border-color: #8a0303;
    }

    .btn-outline-primary:hover {
        background-color: #8a0303;
        border-color: #8a0303;
    }

    /* Toggle Switch Styles */
    .form-check-input:checked {
        background-color: #8a0303;
        border-color: #8a0303;
    }

    .form-check-input:focus {
        border-color: #8a0303;
        box-shadow: 0 0 0 0.25rem rgba(138, 3, 3, 0.25);
    }

    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
        margin-top: 0.25em;
        cursor: pointer;
    }

    .form-switch .form-check-label {
        margin-left: 0.5em;
        cursor: pointer;
    }

    /* Donor Toggle Styles */
    .donor-toggle-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .donor-toggle {
        display: none;
    }

    .donor-toggle-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .donor-toggle:checked + .donor-toggle-label {
        background-color: #fff5f5;
        border-color: #8a0303;
    }

    .donor-status-text {
        font-weight: 500;
        color: #495057;
        transition: color 0.3s ease;
    }

    .donor-toggle:checked + .donor-toggle-label .donor-status-text {
        color: #8a0303;
    }

    .donor-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .donor-toggle:checked + .donor-toggle-label .donor-icon {
        background-color: #8a0303;
        color: white;
    }

    .donor-icon i {
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .donor-toggle:checked + .donor-toggle-label .donor-icon i {
        transform: scale(1.1);
    }

    /* Modern Toggle Switch Styles */
    .modern-toggle-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 5px;
    }

    .modern-toggle-input {
        display: none;
    }

    .modern-toggle {
        position: relative;
        display: inline-block;
        width: 64px;
        height: 34px;
        cursor: pointer;
    }

    .modern-toggle-track {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e9ecef;
        border-radius: 34px;
        transition: 0.4s;
        border: 1px solid #ced4da;
    }

    .modern-toggle-switch {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .modern-toggle-input:checked + .modern-toggle .modern-toggle-track {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .modern-toggle-input:checked + .modern-toggle .modern-toggle-switch {
        transform: translateX(30px);
    }

    .modern-toggle-label {
        font-weight: 500;
        display: flex;
        align-items: center;
        color: #495057;
    }

    .modern-toggle-input:checked ~ .modern-toggle-label {
        color: #dc3545;
    }

    .modern-toggle-label i {
        font-size: 18px;
        margin-right: 8px;
        color: #dc3545;
    }

    .toggle-text {
        font-size: 15px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Hover and Focus States */
    .modern-toggle:hover .modern-toggle-track {
        border-color: #adb5bd;
    }

    .modern-toggle-input:checked + .modern-toggle:hover .modern-toggle-track {
        background-color: #c82333;
    }

    .modern-toggle-switch:active {
        width: 32px;
    }

    .modern-toggle-input:checked + .modern-toggle .modern-toggle-switch:active {
        transform: translateX(24px);
    }

    /* Share Card Styles */
    .share-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        background: #fff;
        position: relative;
        max-width: 100%;
        margin: 0 auto;
        border: 1px solid #e9ecef;
    }

    .share-card-header {
        background: linear-gradient(45deg, #8a0303, #dc3545);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .share-card-logo {
        width: 40px;
        height: 40px;
        object-fit: contain;
        background: white;
        border-radius: 8px;
        padding: 5px;
    }

    .share-card-title {
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .share-card-body {
        padding: 20px;
    }

    .share-card-profile {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .share-card-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #8a0303;
    }

    .share-card-info {
        flex: 1;
    }

    .share-card-name {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #212529;
    }

    .share-card-blood {
        font-size: 15px;
        color: #495057;
        margin-bottom: 5px;
    }

    .share-card-blood-group {
        font-weight: 700;
        color: #8a0303;
    }

    .share-card-location {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 0;
    }

    .share-card-contact {
        background-color: #f8f9fa;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .share-card-contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .share-card-contact-item:last-child {
        margin-bottom: 0;
    }

    .share-card-contact-item i {
        color: #8a0303;
        font-size: 15px;
        width: 20px;
        text-align: center;
    }

    .share-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e9ecef;
        padding-top: 15px;
    }

    .share-card-message {
        font-size: 14px;
        color: #495057;
        flex: 1;
        margin-bottom: 0;
    }

    .share-card-badge {
        background-color: #8a0303;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .share-card-badge i {
        font-size: 12px;
    }

    /* Share Button Styles */
    .btn-facebook {
        background-color: #3b5998;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 500;
    }

    .btn-facebook:hover {
        background-color: #2d4373;
        color: white;
    }

    .btn-twitter {
        background-color: #1DA1F2;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 500;
    }

    .btn-twitter:hover {
        background-color: #0c85d0;
        color: white;
    }

    /* Mobile fix for modals to ensure buttons are visible */
    @media (max-width: 767.98px) {
        .modal-body {
            padding-bottom: 10px;
        }
        
        .modal-dialog {
            margin-bottom: 80px;
        }
        
        .modal {
            padding-bottom: 300px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#editProfileModal form');
        const isDonorToggle = document.querySelector('#is_donor');
        const toggleText = document.querySelector('.toggle-text');
        
        if (form && isDonorToggle) {
            form.addEventListener('submit', function(e) {
                // Ensure is_donor is sent as a number
                isDonorToggle.value = parseInt(isDonorToggle.value);
            });
        }

        if (isDonorToggle && toggleText) {
            isDonorToggle.addEventListener('change', function() {
                toggleText.textContent = this.checked ? 'I am a Blood Donor' : 'Not a Donor';
            });
        }

        // Initialize division dropdowns
        loadDivisions();

        // Add event listeners to division and district selects
        document.querySelectorAll('.permanent-division, .present-division').forEach(select => {
            select.addEventListener('change', function() {
                const target = this.dataset.target;
                const districtSelect = document.querySelector(`.${target}-district`);
                const upazilaSelect = document.querySelector(`.${target}-upazila`);
                
                // Reset and disable dependent dropdowns
                resetSelect(districtSelect);
                resetSelect(upazilaSelect);
                
                if (this.value) {
                    loadDistricts(this.value, target);
                    districtSelect.disabled = false;
                }
            });
        });

        document.querySelectorAll('.permanent-district, .present-district').forEach(select => {
            select.addEventListener('change', function() {
                const target = this.dataset.target;
                const upazilaSelect = document.querySelector(`.${target}-upazila`);
                
                // Reset and disable dependent dropdown
                resetSelect(upazilaSelect);
                
                if (this.value) {
                    loadUpazilas(this.value, target);
                    upazilaSelect.disabled = false;
                }
            });
        });

        // Share profile functionality
        const shareToFacebookBtn = document.getElementById('shareToFacebook');
        const copyShareLinkBtn = document.getElementById('copyShareLink');
        
        if (shareToFacebookBtn) {
            shareToFacebookBtn.addEventListener('click', function() {
                const userName = "{{ auth()->user()->name }}";
                const bloodGroup = "{{ auth()->user()->blood_group ?? 'Not set' }}";
                const profileUrl = "{{ route('user.profile.show', auth()->id()) }}";
                
                // Convert share card to image using html2canvas (would require the html2canvas library)
                // For this example, we'll use Facebook's standard sharing
                
                const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(profileUrl)}&quote=${encodeURIComponent('Blood Donor: ' + userName + ' (Blood Group: ' + bloodGroup + ')')}`;
                
                // Open Facebook share dialog in a new window
                window.open(shareUrl, 'facebook-share-dialog', 'width=800,height=600');
            });
        }
        
        if (copyShareLinkBtn) {
            copyShareLinkBtn.addEventListener('click', function() {
                const profileUrl = "{{ route('user.profile.show', auth()->id()) }}";
                
                // Copy to clipboard
                navigator.clipboard.writeText(profileUrl).then(function() {
                    // Show success message
                    const originalText = copyShareLinkBtn.innerHTML;
                    copyShareLinkBtn.innerHTML = '<i class="fas fa-check me-2"></i>Link Copied!';
                    
                    setTimeout(function() {
                        copyShareLinkBtn.innerHTML = originalText;
                    }, 2000);
                });
            });
        }

        // Functions to load dropdown options
        function loadDivisions() {
            fetch('{{ route("get.divisions") }}')
                .then(response => response.json())
                .then(data => {
                    const permanentDivisionSelect = document.querySelector('.permanent-division');
                    const presentDivisionSelect = document.querySelector('.present-division');
                    
                    data.forEach(division => {
                        const option = document.createElement('option');
                        option.value = division.id;
                        option.textContent = division.name;
                        
                        const optionClone = option.cloneNode(true);
                        
                        permanentDivisionSelect.appendChild(option);
                        presentDivisionSelect.appendChild(optionClone);
                    });

                    // Set selected values if available
                    @if(auth()->user()->locations()->where('type', 'permanent')->first()?->division_id)
                        permanentDivisionSelect.value = '{{ auth()->user()->locations()->where("type", "permanent")->first()->division_id }}';
                        permanentDivisionSelect.dispatchEvent(new Event('change'));
                    @endif

                    @if(auth()->user()->locations()->where('type', 'present')->first()?->division_id)
                        presentDivisionSelect.value = '{{ auth()->user()->locations()->where("type", "present")->first()->division_id }}';
                        presentDivisionSelect.dispatchEvent(new Event('change'));
                    @endif
                })
                .catch(error => console.error('Error loading divisions:', error));
        }

        function loadDistricts(divisionId, target) {
            fetch(`{{ url('/get-districts') }}/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    const districtSelect = document.querySelector(`.${target}-district`);
                    
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });

                    // Set selected value if available
                    if (target === 'permanent') {
                        @if(auth()->user()->locations()->where('type', 'permanent')->first()?->district_id)
                            districtSelect.value = '{{ auth()->user()->locations()->where("type", "permanent")->first()->district_id }}';
                            districtSelect.dispatchEvent(new Event('change'));
                        @endif
                    } else if (target === 'present') {
                        @if(auth()->user()->locations()->where('type', 'present')->first()?->district_id)
                            districtSelect.value = '{{ auth()->user()->locations()->where("type", "present")->first()->district_id }}';
                            districtSelect.dispatchEvent(new Event('change'));
                        @endif
                    }
                })
                .catch(error => console.error(`Error loading districts for ${target}:`, error));
        }

        function loadUpazilas(districtId, target) {
            fetch(`{{ url('/get-upazilas') }}/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    const upazilaSelect = document.querySelector(`.${target}-upazila`);
                    
                    data.forEach(upazila => {
                        const option = document.createElement('option');
                        option.value = upazila.id;
                        option.textContent = upazila.name;
                        upazilaSelect.appendChild(option);
                    });

                    // Set selected value if available
                    if (target === 'permanent') {
                        @if(auth()->user()->locations()->where('type', 'permanent')->first()?->upazila_id)
                            upazilaSelect.value = '{{ auth()->user()->locations()->where("type", "permanent")->first()->upazila_id }}';
                        @endif
                    } else if (target === 'present') {
                        @if(auth()->user()->locations()->where('type', 'present')->first()?->upazila_id)
                            upazilaSelect.value = '{{ auth()->user()->locations()->where("type", "present")->first()->upazila_id }}';
                        @endif
                    }
                })
                .catch(error => console.error(`Error loading upazilas for ${target}:`, error));
        }

        function resetSelect(select) {
            select.innerHTML = '<option value="">Select</option>';
            select.disabled = true;
        }
    });
</script>
@endpush 