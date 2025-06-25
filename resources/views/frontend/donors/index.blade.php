@extends('frontend.layouts.frontend')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-0">Blood Donors</h2>
                    <p class="text-muted mb-0">Find and connect with blood donors in your area</p>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Advanced Filters
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#mapModal">
                        <i class="fas fa-map-marker-alt me-2"></i>Map View
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Group Quick Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <button class="btn btn-outline-danger blood-group-filter {{ !request('blood_type') && !request('blood_type.*') ? 'active' : '' }}" data-group="all">
                            All Types
                        </button>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                            <button class="btn btn-outline-danger blood-group-filter {{ in_array($type, (array)request('blood_type')) ? 'active' : '' }}" data-group="{{ $type }}">
                                <i class="fas fa-tint me-1"></i>{{ $type }}
                </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-danger bg-opacity-10 text-danger me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Total Donors</h6>
                            <h3 class="mb-0">{{ $totalDonors }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success bg-opacity-10 text-success me-3">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Active Donors</h6>
                            <h3 class="mb-0">{{ $activeDonors }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-info bg-opacity-10 text-info me-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">New Donors</h6>
                            <h3 class="mb-0">{{ $newDonors }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning me-3">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Available Types</h6>
                            <h3 class="mb-0">{{ $availableTypes }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Donors List -->
    <div class="row">
                        @forelse($donors as $donor)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card donor-card border-0 shadow-sm h-100">
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <span class="badge bg-{{ $donor->isAvailableForDonation() ? 'success' : 'warning' }}">
                            {{ $donor->isAvailableForDonation() ? 'Available' : 'Not Available' }}
                        </span>
                    </div>
                    <div class="card-body text-center">
                        <div class="position-relative mb-3">
                            @if($donor->profile_picture)
                                <img src="{{ asset($donor->profile_picture) }}" alt="{{ $donor->name }}" class="rounded-circle donor-avatar">
                                        @else
                                <div class="rounded-circle donor-avatar-placeholder bg-danger bg-opacity-10 text-danger">
                                                {{ substr($donor->name, 0, 1) }}
                                            </div>
                                        @endif
                            <span class="blood-group-badge">{{ $donor->blood_group }}</span>
                        </div>
                        <h5 class="mb-1">{{ $donor->name }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $donor->present_district }}
                        </p>
                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <div class="text-center">
                                <span class="d-block fw-bold">{{ $donor->total_blood_donation ?? 0 }}</span>
                                <small class="text-muted">Donations</small>
                            </div>
                            <div class="text-center">
                                <span class="d-block fw-bold">{{ $donor->getDonorExperience() }}</span>
                                <small class="text-muted">Experience</small>
                                        </div>
                                    </div>
                        <div class="d-grid">
                                    <button type="button" class="btn btn-sm btn-danger view-profile" data-id="{{ $donor->id }}">
                                        <i class="fas fa-eye me-1"></i>View Profile
                                    </button>
                                    </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-user-slash text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="mb-2">No Donors Found</h4>
                        <p class="text-muted mb-4">We couldn't find any donors matching your criteria.</p>
                        <button type="button" class="btn btn-outline-danger" onclick="resetFilters()">
                            <i class="fas fa-redo me-1"></i>Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $donors->firstItem() ?? 0 }} to {{ $donors->lastItem() ?? 0 }} of {{ $donors->total() }} results
        </div>
        <div>
            {{ $donors->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Donors</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.donors.index') }}" method="GET" id="filterForm">
                        <input type="hidden" name="_method" value="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Blood Type</label>
                                    <div class="row g-2">
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="blood_type[]" value="{{ $type }}"
                                                           id="blood_type_{{ $type }}" {{ in_array($type, (array)request('blood_type', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="blood_type_{{ $type }}">
                                                        {{ $type }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Location</label>
                                    <select class="form-select mb-2" name="district" id="district">
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ request('district') == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-select" name="sub_district" id="sub_district">
                                        <option value="">Select Sub District</option>
                                        @foreach($subDistricts as $subDistrict)
                                            <option value="{{ $subDistrict->id }}" {{ request('sub_district') == $subDistrict->id ? 'selected' : '' }}>
                                                {{ $subDistrict->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Donation Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="donation_status" value="all" id="donation_status_all" 
                                            {{ request('donation_status', 'all') === 'all' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="donation_status_all">
                                            All Donors
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="donation_status" value="donated" id="donation_status_donated"
                                            {{ request('donation_status') === 'donated' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="donation_status_donated">
                                            Has Donated
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="donation_status" value="never" id="donation_status_never"
                                            {{ request('donation_status') === 'never' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="donation_status_never">
                                            Never Donated
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light" onclick="resetFilters()">Reset</button>
                            <button type="submit" class="btn btn-danger">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Donors Map</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="donorsMap" style="height: 500px;">
                        <div class="text-center py-5">
                            <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3">Loading map view...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="profileModalLabel">Donor Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="profileModalContent">
                    <!-- Content will be loaded here -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3">Loading donor profile...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .blood-group-filter.active {
        background-color: #8a0303;
        color: white;
        border-color: #8a0303;
    }
    
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
        font-size: 1.2rem;
}

    .donor-card {
        transition: all 0.3s ease;
    }
    
    .donor-card:hover {
        transform: translateY(-5px);
    }
    
    .donor-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin: 0 auto;
        border: 3px solid #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .donor-avatar-placeholder {
        width: 100px;
        height: 100px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        border: 3px solid #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .blood-group-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: #8a0303;
        color: white;
        font-weight: bold;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        font-size: 0.8rem;
        transform: translate(25%, 25%);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
        // Blood group quick filter buttons
        const bloodGroupFilters = document.querySelectorAll('.blood-group-filter');
        bloodGroupFilters.forEach(btn => {
            btn.addEventListener('click', function() {
                const bloodGroup = this.dataset.group;
                let url = new URL(window.location);
                
                if (bloodGroup === 'all') {
                    // Remove all blood_type parameters, not just a single one
                    url.searchParams.delete('blood_type[]');
                    url.searchParams.delete('blood_type');
                } else {
                    url.searchParams.set('blood_type[]', bloodGroup);
                }
                
                window.location.href = url.toString();
            });
        });
        
        // District change event to load sub-districts
        const districtSelect = document.getElementById('district');
        const subDistrictSelect = document.getElementById('sub_district');
        
        if (districtSelect && subDistrictSelect) {
            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                
                // Clear sub-district options
                subDistrictSelect.innerHTML = '<option value="">Select Sub District</option>';
                
                if (districtId) {
                    // Show loading indicator
                    subDistrictSelect.disabled = true;
                    
                    // Fetch sub-districts for the selected district
                    fetch(`{{ route('user.donors.sub-districts', ['districtId' => ':id']) }}`.replace(':id', districtId))
                        .then(response => response.json())
                        .then(data => {
                            // Add options for each sub-district
                            data.forEach(subDistrict => {
                                const option = document.createElement('option');
                                option.value = subDistrict.id;
                                option.textContent = subDistrict.name;
                                subDistrictSelect.appendChild(option);
                            });
                            
                            // Enable select
                            subDistrictSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error loading sub-districts:', error);
                            subDistrictSelect.disabled = false;
                        });
                }
            });
        }
        
        // Donor profile view
        const viewProfileButtons = document.querySelectorAll('.view-profile');
        viewProfileButtons.forEach(button => {
            button.addEventListener('click', function() {
                const donorId = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('profileModal'));
                modal.show();
                
                // Load donor profile content
                fetch(`{{ route('user.donors.show', ':id') }}`.replace(':id', donorId))
                    .then(response => response.json())
            .then(data => {
                if (data.success) {
                            document.getElementById('profileModalContent').innerHTML = data.html;
                } else {
                            document.getElementById('profileModalContent').innerHTML = `
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    Failed to load donor profile. Please try again.
                                </div>
                            `;
                }
            })
            .catch(error => {
                        console.error('Error loading donor profile:', error);
                        document.getElementById('profileModalContent').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Failed to load donor profile. Please try again.
                            </div>
                        `;
            });
            });
    });
});
    
    function resetFilters() {
        // Clear all form fields
        document.getElementById('filterForm').reset();
        // Redirect to the base donor index page
        window.location.href = "{{ route('user.donors.index') }}";
    }
</script>
@endpush