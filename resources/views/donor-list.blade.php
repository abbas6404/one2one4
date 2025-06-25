@extends('layouts.public-layout')

@section('title', 'Donor List')

@push('styles')
<style>
    /* Search Section Styles */
    .search-section {
        background-color: #f8f9fa;
        padding: 50px 0;
        position: relative;
        z-index: 1;
    }
    
    .search-box {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 30px;
        position: relative;
        z-index: 2;
    }
    
    .search-title {
        color: #161630;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    
    .filter-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #161630;
    }
    
    .search-input-group {
        margin-bottom: 15px;
    }
    
    .blood-filter .form-select {
        border-color: rgba(255, 95, 109, 0.3);
    }
    
    .blood-select {
        font-weight: 500;
    }
    
    .location-filter .form-select {
        border-color: rgba(0, 123, 255, 0.3);
    }
    
    .form-control, .form-select {
        height: 50px;
        border-radius: 10px;
        font-size: 1rem;
        box-shadow: none;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #ff5f6d;
        box-shadow: 0 0 0 0.2rem rgba(255, 95, 109, 0.25);
    }
    
    .search-button-wrapper {
        text-align: center;
    }
    
    .custom-search-btn {
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        border: none;
        color: white;
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    .custom-search-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 95, 109, 0.3);
        color: white;
    }
    
    .pulse-btn {
        position: relative;
    }
    
    .pulse-btn:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50px;
        z-index: -1;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(0.9);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.5;
        }
        100% {
            transform: scale(0.9);
            opacity: 1;
        }
    }

    /* Donors Section */
    .donors-section {
        padding: 50px 0;
        background-color: #fff;
    }

    .section-header {
        margin-bottom: 40px;
        text-align: center;
    }
    
    .section-header h2 {
        color: #161630;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
    }
    
    .section-header p {
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto;
    }

    .blood-badge {
        display: inline-block;
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #ff5f6d, #ff9966);
        padding: 8px 15px;
        border-radius: 50px;
        margin-bottom: 1rem;
    }

    .donor-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        padding: 25px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .donor-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .donor-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(to bottom, #ff5f6d, #ff9966);
    }

    .donor-name {
        color: #161630;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .donor-info {
        color: #6c757d;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
    }

    .donor-info i {
        color: #ff5f6d;
        margin-right: 10px;
        font-size: 0.9rem;
        width: 18px;
    }

    /* Masked phone number styling */
    .phone-info {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        color: #6c757d;
    }
    .phone-info i {
        color: #ff5f6d;
        margin-right: 8px;
        font-size: 0.9rem;
    }
    .phone-info span {
        font-size: 1rem;
        font-weight: 500;
    }

    .donor-card .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f8f9fa;
    }

    .donor-actions {
        margin-top: 1.5rem;
    }

    .btn-contact {
        padding: 8px 15px;
        font-weight: 500;
        font-size: 0.9rem;
        border-radius: 50px;
        background: #f8f9fa;
        border: none;
        color: #161630;
        transition: all 0.3s ease;
    }

    .btn-contact:hover {
        background: #161630;
        color: #fff;
    }

    .status-available {
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 50px;
        background: #d1fae5;
        color: #047857;
        display: inline-block;
    }

    .status-unavailable {
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 50px;
        background: #fee2e2;
        color: #b91c1c;
        display: inline-block;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .page-item.active .page-link {
        background-color: #ff5f6d;
        border-color: #ff5f6d;
        color: #fff;
    }

    .page-link {
        color: #161630;
        border-radius: 5px;
        margin: 0 3px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        color: #ff5f6d;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
        opacity: 0.7;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .section-header h2 {
            font-size: 1.8rem;
        }
        
        .donors-section {
            padding: 30px 0;
        }
        
        .search-box {
            padding: 20px;
        }
        
        .search-title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Enhanced Search Section with Blood Color Theme and Hierarchical Location Filters -->
<section class="search-section">
      <div class="container">
        <div class="search-box">
            <h3 class="search-title text-center mb-4">Find Blood Donors</h3>
            <form action="{{ route('donors.search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group blood-filter">
                            <label class="filter-label"><i class="fas fa-tint me-2"></i>Blood Group</label>
                            <select class="form-select blood-select" name="blood_group">
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ request('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ request('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ request('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ request('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ request('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ request('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ request('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ request('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                         </select>
                     </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group location-filter">
                            <label class="filter-label"><i class="fas fa-map-marker-alt me-2"></i>Division</label>
                            <select class="form-select location-select" name="division_id" id="division_id">
                                <option value="">Select Division</option>
                                @foreach($divisions ?? [] as $division)
                                <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                @endforeach
                         </select>
                     </div>
                 </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group location-filter">
                            <label class="filter-label"><i class="fas fa-map me-2"></i>District</label>
                            <select class="form-select location-select" name="district_id" id="district_id" {{ empty(request('division_id')) ? 'disabled' : '' }}>
                                <option value="">Select District</option>
                                @if(!empty($districts))
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                @endif
                            </select>
             </div>
             </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="search-input-group location-filter">
                            <label class="filter-label"><i class="fas fa-street-view me-2"></i>Upazila</label>
                            <select class="form-select location-select" name="upazila_id" id="upazila_id" {{ empty(request('district_id')) ? 'disabled' : '' }}>
                                <option value="">Select Upazila</option>
                                @if(!empty($upazilas))
                                    @foreach($upazilas as $upazila)
                                        <option value="{{ $upazila->id }}" {{ request('upazila_id') == $upazila->id ? 'selected' : '' }}>{{ $upazila->name }}</option>
                                    @endforeach
                                @endif
                            </select>
         </div>
     </div>
                    <div class="col-md-6">
                        <div class="search-input-group">
                            <label class="filter-label"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">All Genders</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                 </div>
                             </div>
        <div class="col-md-6">
                        <div class="search-input-group">
                            <label class="filter-label"><i class="fas fa-search me-2"></i>Keywords</label>
                            <input type="text" class="form-control" name="keywords" placeholder="Search by name, email, or phone..." value="{{ request('keywords') }}">
                             </div>
                             </div>
                    <div class="col-12 mt-4">
                        <div class="search-button-wrapper">
                            <button type="submit" class="btn custom-search-btn pulse-btn">
                                <i class="fas fa-search me-2"></i> Find Blood Donors
                            </button>
                         </div>
                         </div>
                     </div>
            </form>
                 </div>
             </div>
</section>

<!-- Donors Section -->
<section class="donors-section">
    <div class="container">
        <div class="section-header">
            <h2>Available Donors</h2>
            <p>We have <span class="fw-bold text-danger">{{ $total_donor }}</span> registered donors ready to help. Every donor is screened and follows our donation guidelines.</p>
        </div>
        
        <div class="row">
            @forelse($donors as $donor)
            <div class="col-lg-4 col-md-6">
                <div class="donor-card">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <img src="{{ $donor->profile_picture_url ?? asset('images/avatar.png') }}" alt="{{ $donor->name }}" class="avatar">
                        </div>
                        <div class="col-8">
                            <div class="blood-badge">{{ $donor->blood_group }}</div>
                            <h4 class="donor-name">{{ $donor->name }}</h4>
                            
                            @php
                                $isAvailable = is_null($donor->last_donation_date) || $donor->last_donation_date->diffInMonths(now()) >= 4;
                                
                                if (!$isAvailable && !is_null($donor->last_donation_date)) {
                                    // Calculate next available date (4 months after last donation)
                                    $nextAvailableDate = $donor->last_donation_date->copy()->addMonths(4);
                                    $daysRemaining = now()->diffInDays($nextAvailableDate, false);
                                    $monthsRemaining = floor($daysRemaining / 30);
                                    $remainingDays = $daysRemaining % 30;
                                    
                                    $availabilityText = '';
                                    if ($monthsRemaining > 0) {
                                        $availabilityText .= $monthsRemaining . ' month' . ($monthsRemaining > 1 ? 's' : '');
                                    }
                                    if ($remainingDays > 0) {
                                        if ($monthsRemaining > 0) $availabilityText .= ' and ';
                                        $availabilityText .= $remainingDays . ' day' . ($remainingDays > 1 ? 's' : '');
                                    }
                                }
                            @endphp
                            
                            <div class="{{ $isAvailable ? 'status-available' : 'status-unavailable' }}">
                                <i class="fas {{ $isAvailable ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                {{ $isAvailable ? 'Available Now' : 'Available in ' . $availabilityText }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        @if($donor->present_district_id)
                        <div class="donor-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $donor->presentDistrict ? $donor->presentDistrict->name : 'N/A' }}, {{ $donor->presentDivision ? $donor->presentDivision->name : 'N/A' }}</span>
    </div>
                        @endif
                        
                        @if($donor->phone)
                        <div class="phone-info">
                            <i class="fas fa-phone-alt"></i>
                            <span>{{ substr($donor->phone, 0, -3) . '***' }}</span>
                        </div>
                        @endif
                        
                        @if($donor->total_blood_donation)
                        <div class="donor-info">
                            <i class="fas fa-tint"></i>
                            <span>Donated {{ $donor->total_blood_donation }} times</span>
                        </div>
                        @endif
                        
                        @if($donor->last_donation_date)
                        <div class="donor-info">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Last donated: {{ $donor->last_donation_date->format('d M, Y') }}</span>
                        </div>
                        @endif
  </div>

                    <div class="donor-actions">
                        <a href="{{ route('register') }}" class="btn btn-contact">
                            <i class="fas fa-paper-plane me-1"></i> Contact Donor
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="alert alert-info py-4">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>No donors found</h4>
                    <p>Try changing your search criteria or check back later.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $donors->withQueryString()->links() }}
        </div>
    </div>
</section>
  @endsection

@push('scripts')
    <script>
    // Script to handle hierarchical dropdowns for division, district, upazila
    $(document).ready(function() {
        // When division changes
        $('#division_id').change(function() {
            let divisionId = $(this).val();
            if (divisionId) {
                // Enable district dropdown
                $('#district_id').prop('disabled', false);
                
                // Fetch districts via AJAX
                $.ajax({
                    url: '/get-districts/' + divisionId,
                    type: 'GET',
                    success: function(data) {
                        $('#district_id').empty().append('<option value="">Select District</option>');
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                // Disable and reset district and upazila dropdowns
                $('#district_id').prop('disabled', true).empty().append('<option value="">Select District</option>');
                $('#upazila_id').prop('disabled', true).empty().append('<option value="">Select Upazila</option>');
            }
        });
        
        // When district changes
        $('#district_id').change(function() {
            let districtId = $(this).val();
            if (districtId) {
                // Enable upazila dropdown
                $('#upazila_id').prop('disabled', false);
                
                // Fetch upazilas via AJAX
                $.ajax({
                    url: '/get-upazilas/' + districtId,
                    type: 'GET',
                    success: function(data) {
                        $('#upazila_id').empty().append('<option value="">Select Upazila</option>');
                        $.each(data, function(key, value) {
                            $('#upazila_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                // Disable and reset upazila dropdown
                $('#upazila_id').prop('disabled', true).empty().append('<option value="">Select Upazila</option>');
            }
         });
         });
      </script>
@endpush