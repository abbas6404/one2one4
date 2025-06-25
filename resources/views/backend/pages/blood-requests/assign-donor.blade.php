@extends('backend.layouts.master')

@section('title')
Assign Donor - Blood Request #{{ $bloodRequest->id }}
@endsection

@section('styles')
<style>
    .page-title-area {
        padding: 30px 30px 20px;
        background: #f8f9fa;
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .breadcrumbs-area h4 {
        margin: 0 0 10px;
        font-size: 24px;
        color: #333;
    }

    .breadcrumbs {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .breadcrumbs li {
        display: flex;
        align-items: center;
        color: #666;
    }

    .breadcrumbs li:not(:last-child):after {
        content: '/';
        margin-left: 8px;
        color: #ccc;
    }

    .breadcrumbs a {
        color: #e84c3d;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumbs a:hover {
        color: #c0392b;
    }

    .assign-donor-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
    }
    .assign-donor-table th, .assign-donor-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }
    .assign-donor-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }
    .assign-donor-table tr:hover {
        background-color: #f8f9fa;
    }
    .assign-btn {
        background: #2ecc71;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .assign-btn:hover {
        background: #27ae60;
    }
    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #e84c3d;
        text-decoration: none;
        font-weight: 500;
    }
    .back-link:hover {
        text-decoration: underline;
        color: #c0392b;
    }
    .assign-btn.disabled {
        background: #95a5a6;
        cursor: not-allowed;
    }
    .spinner-border {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
        margin-right: 5px;
        display: none;
    }
    #toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    .toast {
        min-width: 250px;
        margin-bottom: 10px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        display: none;
    }
    .toast-header {
        padding: 0.5rem 1rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .toast-body {
        padding: 0.75rem 1rem;
    }
    .toast-success .toast-header {
        background-color: #d4edda;
        color: #155724;
    }
    .toast-error .toast-header {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    /* Animation for row removal */
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; transform: translateY(-10px); }
    }
    
    .fade-out {
        animation: fadeOut 0.5s ease forwards;
    }
    
    .filter-card {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        border: none;
    }
    
    .filter-title {
        color: #333;
        font-weight: 600;
    }
    
    .filter-label {
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
    }
    
    .blood-type {
        font-weight: 600;
        color: #dc3545;
        font-size: 16px;
        display: inline-block;
        padding: 5px 15px;
        background: #f8d7da;
        border-radius: 20px;
        text-align: center;
    }
    
    .donor-age {
        color: #555;
        display: inline-block;
        margin-left: 8px;
        font-size: 13px;
    }
    
    .donor-gender {
        color: #555;
        display: inline-block;
        font-size: 13px;
    }
    
    .eligibility-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .eligible {
        background-color: #d4edda;
        color: #155724;
    }
    
    .not-eligible {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .donor-profile {
        display: flex;
        align-items: center;
    }
    
    .donor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 12px;
        background-color: #4e73df;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }
    
    .donor-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .donor-initial {
        text-transform: uppercase;
    }
    
    .donor-info {
        flex: 1;
    }
    
    .donor-name {
        font-weight: 600;
        font-size: 15px;
        color: #333;
        margin-bottom: 2px;
    }
    
    .donor-meta {
        color: #666;
    }
    
    .nearby-badge {
        display: inline-block;
        background-color: #4e73df;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        margin-top: 5px;
    }
    
    .nearby-donor {
        background-color: #eef5ff;
    }
    
    .exact-match {
        color: #28a745;
        font-size: 12px;
        font-weight: 600;
        margin-top: 3px;
        text-align: center;
    }
    
    .compatible-match {
        color: #17a2b8;
        font-size: 12px;
        margin-top: 3px;
        text-align: center;
    }
    
    .contact-info {
        font-size: 14px;
        color: #555;
    }
    
    .phone-number, .email {
        margin-bottom: 3px;
    }
    
    .click-to-call {
        color: #28a745;
        margin-left: 5px;
    }
    
    .location-info {
        font-size: 14px;
    }
    
    .location-primary {
        font-weight: 500;
        margin-bottom: 3px;
    }
    
    .location-detail {
        color: #666;
        font-size: 13px;
        margin-bottom: 3px;
    }
    
    .location-division {
        color: #777;
        font-size: 12px;
        font-style: italic;
    }
    
    .donation-history {
        font-size: 13px;
    }
    
    .donation-status {
        margin-bottom: 8px;
    }
    
    .donation-count {
        color: #555;
        margin-bottom: 3px;
    }
    
    .last-donation {
        color: #666;
    }
    
    .time-ago {
        color: #888;
        font-style: italic;
        font-size: 12px;
    }
    
    .eligible-date {
        color: #e74a3b;
        font-size: 12px;
        margin-top: 3px;
    }
    
    .first-time {
        color: #28a745;
        font-weight: 500;
    }
    
    .distance-info {
        text-align: center;
    }
    
    .distance-value {
        font-weight: 600;
        font-size: 15px;
        color: #333;
    }
    
    .distance-visual {
        margin: 8px 0;
    }
    
    .distance-bar-wrapper {
        background-color: #eee;
        height: 4px;
        border-radius: 2px;
        width: 100%;
    }
    
    .distance-bar {
        height: 100%;
        background-color: #4e73df;
        border-radius: 2px;
    }
    
    .travel-time {
        font-size: 12px;
        color: #777;
    }
    
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .contact-donor-btn {
        display: inline-block;
        padding: 6px 12px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #555;
        text-align: center;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
    }
    
    .contact-donor-btn:hover {
        background-color: #e9ecef;
        color: #333;
        text-decoration: none;
    }
    
    .lower-priority {
        opacity: 0.75;
    }
    
    .sort-options {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .sort-label {
        font-size: 14px;
        color: #555;
    }
    
    .sort-option {
        font-size: 13px;
    }
    
    .sort-option.active {
        background-color: #4e73df;
        color: white;
        border-color: #4e73df;
    }
    
    .hospital-info {
        padding: 5px 10px;
        border-left: 1px solid #eee;
    }
    
    .hospital-name {
        font-size: 15px;
        margin-bottom: 5px;
    }
    
    .hospital-address {
        font-size: 14px;
        color: #333;
        line-height: 1.4;
    }
    
    .directions-link {
        display: inline-block;
        color: #4e73df;
        font-size: 13px;
        text-decoration: none;
    }
    
    .directions-link:hover {
        text-decoration: underline;
        color: #2e59d9;
    }
    
    .map-preview {
        max-width: 300px;
    }
    
    .map-thumbnail {
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .map-thumbnail img {
        width: 100%;
        display: block;
    }
    
    .map-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        opacity: 0;
        transition: opacity 0.2s;
    }
    
    .map-thumbnail:hover .map-overlay {
        opacity: 1;
        background: rgba(0,0,0,0.5);
    }
    
    .time-remaining {
        color: #666;
        font-size: 13px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-approved {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    
    .status-rejected {
        background-color: #f8d7da;
        color: #842029;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Assign Blood Donor</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.blood_requests.index') }}">Blood Requests</a></li>
                    <li><a href="{{ route('admin.blood_requests.show', $bloodRequest->id) }}">Request #{{ $bloodRequest->id }}</a></li>
                    <li><span>Assign Donor</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12">
            <!-- Toast notifications container -->
            <div id="toast-container"></div>
            
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Blood Request #{{ $bloodRequest->id }} - Patient: {{ $bloodRequest->user->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <p><strong>Blood Group Needed:</strong> <span class="blood-type">{{ $bloodRequest->blood_type }}</span></p>
                            <p><strong>Units Needed:</strong> {{ $bloodRequest->units_needed }}</p>
                            <p><strong>Current Donors:</strong> {{ $bloodRequest->donations->count() }}/{{ $bloodRequest->units_needed }}</p>
                            <p><strong>Status:</strong> 
                                <span class="status-badge status-{{ $bloodRequest->status }}">{{ ucfirst($bloodRequest->status) }}</span>
                            </p>
                        </div>
                        <div class="col-md-7">
                            <div class="hospital-info">
                                <div class="hospital-name">
                                    <i class="fa fa-hospital-o"></i> <strong>Hospital:</strong> {{ $bloodRequest->hospital_name }}
                                </div>
                                <div class="hospital-address mt-2">
                                    <i class="fa fa-map-marker"></i> <strong>Address:</strong>
                                    <div class="ml-4 mt-1">
                                        @if($bloodRequest->hospital_address)
                                            <div>{{ $bloodRequest->hospital_address }}</div>
                                        @endif
                                        <div>
                                            @if(is_object($bloodRequest->upazila))
                                                {{ $bloodRequest->upazila->name }},
                                            @elseif(is_string($bloodRequest->upazila))
                                                {{ $bloodRequest->upazila }},
                                            @endif
                                            
                                            @if(is_object($bloodRequest->district))
                                                {{ $bloodRequest->district->name }},
                                            @elseif(is_string($bloodRequest->district))
                                                {{ $bloodRequest->district }},
                                            @endif
                                            
                                            @if(is_object($bloodRequest->division))
                                                {{ $bloodRequest->division->name }}
                                            @elseif(is_string($bloodRequest->division))
                                                {{ $bloodRequest->division }}
                                            @endif
                                        </div>
                                        <div class="get-directions mt-1">
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($bloodRequest->hospital_name . ', ' . ($bloodRequest->formattedAddress ?? '')) }}" target="_blank" class="directions-link">
                                                <i class="fa fa-location-arrow"></i> Get Directions
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="map-preview mt-2">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($bloodRequest->hospital_name . ', ' . ($bloodRequest->formattedAddress ?? '')) }}" target="_blank" class="map-link">
                                        <div class="map-thumbnail">
                                            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($bloodRequest->hospital_name . ', ' . ($bloodRequest->formattedAddress ?? '')) }}&zoom=14&size=300x120&maptype=roadmap&markers=color:red%7C{{ urlencode($bloodRequest->hospital_name . ', ' . ($bloodRequest->formattedAddress ?? '')) }}&key={{ config('services.google.maps_api_key', '') }}" 
                                                alt="Hospital location map" class="img-fluid">
                                            <div class="map-overlay">
                                                <i class="fa fa-search-plus"></i> View Larger Map
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="due-date mt-2">
                                    <i class="fa fa-calendar"></i> <strong>Needed By:</strong> 
                                    @if($bloodRequest->needed_date)
                                        {{ $bloodRequest->needed_date->format('M d, Y') }}
                                        <span class="time-remaining">
                                            ({{ $bloodRequest->needed_date->isPast() ? 'Overdue' : $bloodRequest->needed_date->diffForHumans() }})
                                        </span>
                                    @else
                                        Not specified
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card filter-card">
                        <div class="card-body">
                            <h5 class="filter-title mb-4">Donor Filters</h5>
                            <form id="filter-form" method="GET" class="filter-form">
                                <div class="row align-items-end">
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="filter-label">Search</label>
                                        <input type="text" name="search" class="form-control" placeholder="Search by name or phone" value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="filter-label">Division</label>
                                        <select name="division_id" id="division_id" class="form-select custom-select">
                                            <option value="">All Divisions</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}" {{ ($divisionId ?? '') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="filter-label">District</label>
                                        <select name="district_id" id="district_id" class="form-select custom-select">
                                            <option value="">All Districts</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ ($districtId ?? '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3 mb-md-0">
                                        <label class="filter-label">Upazila</label>
                                        <select name="upazila_id" id="upazila_id" class="form-select custom-select">
                                            <option value="">All Upazilas</option>
                                            @foreach($upazilas as $upazila)
                                                <option value="{{ $upazila->id }}" {{ ($upazilaId ?? '') == $upazila->id ? 'selected' : '' }}>{{ $upazila->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-3 mt-md-0">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-filter me-2"></i>Filter
                                        </button>
                                    </div>
                                    @if($divisionId || $districtId || $upazilaId || request('search'))
                                        <div class="col-md-3 mt-3 mt-md-0">
                                            <a href="{{ route('admin.blood_requests.assign_donor_page', $bloodRequest->id) }}" class="btn btn-outline-danger w-100">Clear</a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Eligible Donors ({{ count($potentialDonors) }})</h5>
                        <div class="sort-options">
                            <span class="sort-label">Sort by:</span>
                            <div class="btn-group sort-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary sort-option active" data-sort="distance">
                                    <i class="fa fa-map-marker"></i> Distance
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary sort-option" data-sort="eligibility">
                                    <i class="fa fa-check-circle"></i> Eligibility
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary sort-option" data-sort="donations">
                                    <i class="fa fa-tint"></i> Experience
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="donors-table-container">
                        <table class="assign-donor-table">
                            <thead>
                                <tr>
                                    <th>Donor Information</th>
                                    <th>Blood Group</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Donation History</th>
                                    <th>Distance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($potentialDonors as $donor)
                                    <tr id="donor-row-{{ $donor->id }}" class="{{ $donor->distance < 10 ? 'nearby-donor' : '' }}">
                                        <td>
                                            <div class="donor-profile">
                                                <div class="donor-avatar">
                                                    @if($donor->profile_picture)
                                                        <img src="{{ asset($donor->profile_picture) }}" alt="{{ $donor->name }}" class="donor-img">
                                                    @else
                                                        <div class="donor-initial">{{ substr($donor->name, 0, 1) }}</div>
                                                    @endif
                                                </div>
                                                <div class="donor-info">
                                                    <div class="donor-name">{{ $donor->name }}</div>
                                                    <div class="donor-meta">
                                                        <span class="donor-gender">{{ $donor->gender ?? 'N/A' }}</span> 
                                                        @if($donor->date_of_birth)
                                                        <span class="donor-age">{{ \Carbon\Carbon::parse($donor->date_of_birth)->age }} years</span>
                                                        @endif
                                                    </div>
                                                    @if($donor->distance < 10)
                                                        <span class="nearby-badge"><i class="fa fa-map-marker"></i> Nearby Donor</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="blood-type">{{ $donor->blood_group }}</span>
                                            @if($bloodRequest->blood_type == $donor->blood_group)
                                                <div class="exact-match">Exact Match</div>
                                            @else
                                                <div class="compatible-match">Compatible</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="contact-info">
                                                <div class="phone-number">
                                                    <i class="fa fa-phone"></i> {{ $donor->phone ?: 'N/A' }}
                                                    @if($donor->phone)
                                                        <a href="#" class="click-to-call" data-phone="{{ $donor->phone }}" title="Click to call">
                                                            <i class="fa fa-phone-square"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="email">
                                                    <i class="fa fa-envelope"></i> {{ $donor->email }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="location-info">
                                                <div class="location-primary">
                                                    <i class="fa fa-map-marker"></i> 
                                                    {{ is_object($donor->permanentDistrict) ? $donor->permanentDistrict->name : (is_string($donor->permanentDistrict) ? $donor->permanentDistrict : 'N/A') }}
                                                </div>
                                                <div class="location-detail">
                                                    {{ is_object($donor->permanentUpazila) ? $donor->permanentUpazila->name : (is_string($donor->permanentUpazila) ? $donor->permanentUpazila : '') }}
                                                    {{ $donor->permanent_address ? ', '.$donor->permanent_address : '' }}
                                                </div>
                                                @if($donor->permanentDivision)
                                                <div class="location-division">
                                                    {{ is_object($donor->permanentDivision) ? $donor->permanentDivision->name : (is_string($donor->permanentDivision) ? $donor->permanentDivision : '') }} Division
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php 
                                                $lastDonation = $donor->donations->first(); 
                                                $lastDonationDate = $lastDonation && $lastDonation->donation_date ? $lastDonation->donation_date : null;
                                                $monthsSinceLastDonation = $lastDonationDate ? now()->diffInMonths($lastDonationDate) : null;
                                                $totalDonations = $donor->donations->count();
                                                $isEligible = !$lastDonationDate || $monthsSinceLastDonation >= 3;
                                            @endphp
                                            
                                            <div class="donation-history">
                                                <div class="donation-status">
                                                    <span class="eligibility-badge {{ $isEligible ? 'eligible' : 'not-eligible' }}">
                                                        {{ $isEligible ? 'Eligible Now' : 'Not Eligible Yet' }}
                                                    </span>
                                                </div>
                                                
                                                <div class="donation-count">
                                                    <i class="fa fa-tint"></i> {{ $totalDonations }} {{ $totalDonations == 1 ? 'donation' : 'donations' }}
                                                </div>
                                                
                                                @if($lastDonationDate)
                                                    <div class="last-donation">
                                                        Last: {{ $lastDonationDate->format('M d, Y') }}
                                                        <span class="time-ago">({{ $monthsSinceLastDonation }} months ago)</span>
                                                    </div>
                                                    @if(!$isEligible)
                                                        <div class="eligible-date">
                                                            Eligible in {{ 3 - $monthsSinceLastDonation }} month(s)
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="first-time">First Time Donor</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="distance-info">
                                                <span class="distance-value">{{ number_format($donor->distance, 1) }} km</span>
                                                <div class="distance-visual">
                                                    <div class="distance-bar-wrapper">
                                                        <div class="distance-bar" style="width: {{ min(100, (1 - min(1, $donor->distance/50)) * 100) }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="travel-time">
                                                    ~ {{ ceil($donor->distance / 0.5) }} min by car
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button 
                                                    type="button" 
                                                    class="assign-btn assign-donor-btn {{ $isEligible ? '' : 'lower-priority' }}" 
                                                    data-donor-id="{{ $donor->id }}" 
                                                    data-request-id="{{ $bloodRequest->id }}"
                                                    data-donor-name="{{ $donor->name }}"
                                                    data-donor-phone="{{ $donor->phone }}"
                                                    data-donor-blood="{{ $donor->blood_group }}"
                                                    data-donor-address="{{ is_object($donor->permanentDistrict) ? $donor->permanentDistrict->name : (is_string($donor->permanentDistrict) ? $donor->permanentDistrict : '') }}"
                                                    data-donor-eligible="{{ $isEligible }}"
                                                    title="Assign {{ $donor->name }} to this request"
                                                >
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <i class="fa fa-user-plus"></i> Assign
                                                </button>
                                                
                                                <a href="#" class="contact-donor-btn" data-phone="{{ $donor->phone }}" data-email="{{ $donor->email }}">
                                                    <i class="fa fa-comment"></i> Contact
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center p-5">
                                            <div class="alert alert-info mb-0">
                                                <i class="fa fa-info-circle mr-2"></i> No eligible donors found. Try adjusting your filters.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize sorting functionality
        initializeSorting();
        
        // Initialize all buttons and interactive features
        initializeAssignButtons();
        
        // Function to initialize sorting options
        function initializeSorting() {
            const sortButtons = document.querySelectorAll('.sort-option');
            sortButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const sortBy = this.getAttribute('data-sort');
                    sortDonors(sortBy);
                    
                    // Update active status
                    sortButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Initial sort by distance
            sortDonors('distance');
        }
        
        // Sort donors by different criteria
        function sortDonors(sortBy) {
            const table = document.querySelector('.assign-donor-table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Filter out rows that don't represent donors
            const donorRows = rows.filter(row => !row.querySelector('.alert'));
            
            if (donorRows.length === 0) return; // No donors to sort
            
            donorRows.sort((a, b) => {
                switch(sortBy) {
                    case 'distance':
                        // Check if the element exists before accessing textContent
                        const distanceElA = a.querySelector('.distance-value');
                        const distanceElB = b.querySelector('.distance-value');
                        
                        if (!distanceElA || !distanceElB) return 0;
                        
                        const distanceA = parseFloat(distanceElA.textContent) || 999;
                        const distanceB = parseFloat(distanceElB.textContent) || 999;
                        return distanceA - distanceB;
                    
                    case 'eligibility':
                        const eligibleA = a.querySelector('.eligible') !== null ? 1 : 0;
                        const eligibleB = b.querySelector('.eligible') !== null ? 1 : 0;
                        return eligibleB - eligibleA; // Eligible first
                    
                    case 'donations':
                        const countElA = a.querySelector('.donation-count');
                        const countElB = b.querySelector('.donation-count');
                        
                        if (!countElA || !countElB) return 0;
                        
                        const countTextA = countElA.textContent;
                        const countTextB = countElB.textContent;
                        const donationsA = parseInt(countTextA.match(/\d+/) ? countTextA.match(/\d+/)[0] : '0') || 0;
                        const donationsB = parseInt(countTextB.match(/\d+/) ? countTextB.match(/\d+/)[0] : '0') || 0;
                        return donationsB - donationsA; // More donations first
                        
                    default:
                        return 0;
                }
            });
            
            // Re-append rows in new order
            donorRows.forEach(row => tbody.appendChild(row));
            
            // If there's a "no donors" message row, make sure it stays at the end
            const noDataRow = rows.find(row => row.querySelector('.alert'));
            if (noDataRow) {
                tbody.appendChild(noDataRow);
            }
        }
        // CSRF token for AJAX requests
        const csrfToken = "{{ csrf_token() }}";
        
        // Function to show toast notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            const toastId = 'toast-' + Date.now();
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.id = toastId;
            
            toast.innerHTML = `
                <div class="toast-header">
                    <strong>${type === 'success' ? 'Success' : 'Error'}</strong>
                    <button type="button" class="btn-close" onclick="document.getElementById('${toastId}').remove()"></button>
                </div>
                <div class="toast-body">${message}</div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Show the toast
            toast.style.display = 'block';
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (document.getElementById(toastId)) {
                    document.getElementById(toastId).remove();
                }
            }, 5000);
        }
        
        // Function to initialize assign donor buttons
        function initializeAssignButtons() {
            const assignButtons = document.querySelectorAll('.assign-donor-btn');
            assignButtons.forEach(button => {
                button.addEventListener('click', handleAssignDonor);
            });
            
            // Initialize click-to-call
            document.querySelectorAll('.click-to-call').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const phone = this.getAttribute('data-phone');
                    if (phone) {
                        window.location.href = 'tel:' + phone;
                    }
                });
            });
            
            // Initialize contact buttons
            document.querySelectorAll('.contact-donor-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const phone = this.getAttribute('data-phone');
                    const email = this.getAttribute('data-email');
                    
                    // Get blood request details for message
                    const requestTitle = document.querySelector('.card-header.bg-danger h4')?.textContent?.trim() || 'Blood Request';
                    const bloodType = document.querySelector('.blood-type')?.textContent?.trim() || '[Blood Type]';
                    
                    // Get hospital details
                    const hospitalName = document.querySelector('.hospital-name')?.textContent?.replace('Hospital:', '')?.trim() || 'the hospital';
                    
                    // Get hospital address
                    let hospitalAddress = '';
                    const addressElement = document.querySelector('.hospital-address');
                    if (addressElement) {
                        const addressTexts = Array.from(addressElement.querySelectorAll('div')).map(div => div.textContent.trim());
                        hospitalAddress = addressTexts.filter(Boolean).join(', ');
                    }
                    
                    // Get needed by date
                    let neededBy = '';
                    const dueDateElement = document.querySelector('.due-date');
                    if (dueDateElement) {
                        neededBy = dueDateElement.textContent.replace('Needed By:', '').trim().split('(')[0].trim();
                    }
                    
                    const messageTemplate = `
Hello! I'm reaching out regarding ${requestTitle.replace('Blood Request #', 'blood request #')}.

We are in need of ${bloodType} blood group at ${hospitalName}.
${hospitalAddress ? 'Hospital Address: ' + hospitalAddress : ''}
${neededBy ? 'Needed by: ' + neededBy : ''}

Would you be available to donate? Please let us know at your earliest convenience.

Thank you!
                    `;
                    
                    if (phone) {
                        if (confirm("Would you like to send an SMS to this donor?")) {
                            window.location.href = 'sms:' + phone + '?body=' + encodeURIComponent(messageTemplate.trim());
                        } else if (confirm("Would you like to call this donor instead?")) {
                            window.location.href = 'tel:' + phone;
                        }
                    } else if (email) {
                        if (confirm("Would you like to send an email to this donor?")) {
                            window.location.href = 'mailto:' + email + '?subject=Blood%20Donation%20Request&body=' + encodeURIComponent(messageTemplate.trim());
                        }
                    }
                });
            });
        }
        
        // Handle assign donor clicks
        function handleAssignDonor() {
            const donorId = this.getAttribute('data-donor-id');
            const requestId = this.getAttribute('data-request-id');
            const donorName = this.getAttribute('data-donor-name');
            const donorPhone = this.getAttribute('data-donor-phone');
            const donorBlood = this.getAttribute('data-donor-blood');
            const donorAddress = this.getAttribute('data-donor-address');
            const donorEligible = this.getAttribute('data-donor-eligible');
            const spinner = this.querySelector('.spinner-border');
            
            // Confirm assignment
            if (!confirm(`Are you sure you want to assign ${donorName} to this blood request?`)) {
                return;
            }
            
            // Disable button and show spinner
            this.disabled = true;
            this.classList.add('disabled');
            spinner.style.display = 'inline-block';
            this.textContent = ' Assigning...';
            this.prepend(spinner);
            
            // Make AJAX request
            fetch(`/admin/blood-requests/${requestId}/assign-donor`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    donor_id: donorId,
                    donor_phone: donorPhone,
                    donor_blood: donorBlood,
                    donor_address: donorAddress,
                    donor_eligible: donorEligible,
                    _token: csrfToken
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success toast
                    showToast(data.message || 'Donor assigned successfully', 'success');
                    
                    // Remove row from table
                    const row = document.getElementById(`donor-row-${donorId}`);
                    if (row) {
                        row.classList.add('fade-out');
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if table is empty
                            const tbody = document.querySelector('.assign-donor-table tbody');
                            if (tbody.children.length === 0) {
                                tbody.innerHTML = `<tr>
                                    <td colspan="7" class="text-center p-5">
                                        <div class="alert alert-info mb-0">
                                            <i class="fa fa-info-circle mr-2"></i> No eligible donors found. Try adjusting your filters.
                                        </div>
                                    </td>
                                </tr>`;
                            }
                            
                            // Update the count in the card header
                            const countElem = document.querySelector('.card-header h5');
                            const currentCount = parseInt(countElem.innerText.match(/\d+/)[0]) - 1;
                            countElem.innerText = `Eligible Donors (${currentCount})`;
                        }, 500);
                    }
                    
                    // Offer to redirect to request details
                    setTimeout(() => {
                        if (confirm('Donor assigned successfully. View request details?')) {
                            window.location.href = `{{ route('admin.blood_requests.show', $bloodRequest->id) }}`;
                        }
                    }, 1000);
                } else {
                    // Show error toast
                    showToast(data.message || 'Error assigning donor', 'error');
                    
                    // Reset button
                    this.disabled = false;
                    this.classList.remove('disabled');
                    spinner.style.display = 'none';
                    this.textContent = 'Assign';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error toast
                showToast('An error occurred while assigning the donor', 'error');
                
                // Reset button
                this.disabled = false;
                this.classList.remove('disabled');
                spinner.style.display = 'none';
                this.textContent = 'Assign';
            });
        }
        
        // Initialize the assign buttons
        initializeAssignButtons();

        // Add dependent dropdown for division/district/upazila
        const divisionSelect = document.getElementById('division_id');
        const districtSelect = document.getElementById('district_id');
        const upazilaSelect = document.getElementById('upazila_id');
        
        if(divisionSelect && districtSelect) {
            divisionSelect.addEventListener('change', function() {
                const divisionId = this.value;
                
                // Clear district dropdown
                districtSelect.innerHTML = '<option value="">All Districts</option>';
                upazilaSelect.innerHTML = '<option value="">All Upazilas</option>';
                
                if (!divisionId) return;
                
                // Get districts for selected division
                fetch(`/api/divisions/${divisionId}/districts`)
                    .then(response => response.json())
                    .then(districts => {
                        districts.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching districts:', error));
            });
        }
        
        if(districtSelect && upazilaSelect) {
            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                
                // Clear upazila dropdown
                upazilaSelect.innerHTML = '<option value="">All Upazilas</option>';
                
                if (!districtId) return;
                
                // Get upazilas for selected district
                fetch(`/api/districts/${districtId}/upazilas`)
                    .then(response => response.json())
                    .then(upazilas => {
                        upazilas.forEach(upazila => {
                            const option = document.createElement('option');
                            option.value = upazila.id;
                            option.textContent = upazila.name;
                            upazilaSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching upazilas:', error));
            });
        }

        // Optional enhancement: Implement AJAX filtering
        // This part would require updates to the backend controller to support AJAX filtering
        /*
        // Filter form handling
        const filterForm = document.getElementById('filter-form');
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(filterForm);
            const searchParams = new URLSearchParams(formData);
            
            fetch(`{{ route('admin.blood_requests.assign_donor_page', $bloodRequest->id) }}?${searchParams.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('donors-table-container').innerHTML = html;
                initializeAssignButtons();
                
                // Update URL with the search parameters without refreshing
                const newUrl = `${window.location.pathname}?${searchParams.toString()}`;
                window.history.pushState({ path: newUrl }, '', newUrl);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error filtering donors', 'error');
            });
        });
        */
    });
</script>
@endsection 