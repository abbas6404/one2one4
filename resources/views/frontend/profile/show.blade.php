@extends('frontend.layouts.frontend')

@section('title', $user->name . '\'s Profile')

@section('content')
<div class="container-fluid pt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $user->name }}'s Profile</h1>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="profile-picture-container mb-3 position-relative">
                        <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('images/avatar.png') }}" 
                             alt="Profile Picture" class="profile-picture">
                        @if($user->is_donor)
                            <div class="donor-badge position-absolute bottom-0 end-0 text-white rounded-circle p-2 shadow-sm" 
                                 style="transform: translate(25%, 25%);">
                                <i class="fas fa-tint fa-lg"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    @if($user->is_donor)
                        <p class="text-danger mb-2">
                            <i class="fas fa-tint me-1"></i>
                            Blood Donor
                        </p>
                    @endif
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <p class="text-muted mb-2">{{ $user->phone }}</p>
                    
                    @if(Auth::check())
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('user.donors.contact', $user->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-1"></i> Contact
                        </a>
                    </div>
                    @endif
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
                            <strong>Phone:</strong> {{ $user->phone }}
                        </li>
                        @if($user->dob)
                        <li class="mb-2">
                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                            <strong>Date of Birth:</strong> {{ $user->dob ? $user->dob->format('d M Y') : 'Not set' }}
                        </li>
                        @endif
                        <li class="mb-2">
                            <i class="fas fa-venus-mars text-primary me-2"></i>
                            <strong>Gender:</strong> {{ ucfirst($user->gender ?? 'Not set') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong>Member Since:</strong> {{ $user->created_at->format('M Y') }}
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
                        @if($user->occupation)
                        <li class="mb-2">
                            <i class="fas fa-briefcase text-primary me-2"></i>
                            <strong>Occupation:</strong> {{ $user->occupation }}
                        </li>
                        @endif
                        @if($user->religion)
                        <li class="mb-2">
                            <i class="fas fa-pray text-primary me-2"></i>
                            <strong>Religion:</strong> {{ ucfirst($user->religion) }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Present Address -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Address</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Division:</strong> 
                            @php
                                $division = $user->present_division;
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
                                $district = $user->present_district;
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
                                $subDistrict = $user->present_sub_district;
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
                    </ul>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center mb-3 mb-md-0">
                            <h6 class="text-muted mb-3">Total Blood Donation</h6>
                            <h2 class="mb-0">{{ $user->total_blood_donation ?? 0 }}</h2>
                        </div>

                        <div class="col-md-6 text-center">
                            <h6 class="text-muted mb-3">Blood Group</h6>
                            <h2 class="mb-0">{{ $user->blood_group ?? 'Not set' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        transition: all 0.3s ease;
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

    .donor-badge i {
        font-size: 2.2rem;
        color: #ff0000;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
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
</style>
@endpush 