@extends('backend.layouts.master')

@section('title')
Location Management - Admin Panel
@endsection

@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Location Management</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Location Hierarchy</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner mt-4">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Divisions</h6>
                            <h2 class="mb-0">{{ $total_divisions }}</h2>
                        </div>
                        <div class="icon">
                            <i class="fa fa-map fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.locations.divisions') }}" data-bs-toggle="tooltip" title="View all divisions">View Divisions</a>
                    <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Districts</h6>
                            <h2 class="mb-0">{{ $total_districts }}</h2>
                            </div>
                        <div class="icon">
                            <i class="fa fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.locations.districts') }}" data-bs-toggle="tooltip" title="View all districts">View Districts</a>
                    <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Upazilas</h6>
                            <h2 class="mb-0">{{ $total_upazilas }}</h2>
                            </div>
                        <div class="icon">
                            <i class="fa fa-location-arrow fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.locations.upazilas') }}" data-bs-toggle="tooltip" title="View all upazilas">View Upazilas</a>
                    <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Locations</h6>
                            <h2 class="mb-0">{{ $total_divisions + $total_districts + $total_upazilas }}</h2>
                            </div>
                        <div class="icon">
                            <i class="fa fa-globe fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <span class="small text-white">Division + District + Upazila</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Location Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4"><i class="fa fa-plus-circle mr-2"></i> Quick Actions</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.locations.divisions.create') }}" class="btn btn-primary btn-block d-flex align-items-center justify-content-center">
                                <i class="fa fa-plus-circle mr-2"></i> 
                                <span>Add New Division</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.locations.districts.create') }}" class="btn btn-success btn-block d-flex align-items-center justify-content-center">
                                <i class="fa fa-plus-circle mr-2"></i> 
                                <span>Add New District</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.locations.upazilas.create') }}" class="btn btn-info btn-block d-flex align-items-center justify-content-center">
                                <i class="fa fa-plus-circle mr-2"></i> 
                                <span>Add New Upazila</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card filter-card">
                <div class="card-body">
                    <h5 class="filter-title mb-4"><i class="fa fa-filter mr-2"></i> Search & Filter Locations</h5>
                    <form method="GET" class="filter-form">
                        <div class="row align-items-end">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="filter-label">
                                    <i class="fa fa-map-marker mr-1"></i> Division
                                    <span class="text-muted small ml-1">(Select first)</span>
                                </label>
                                <select class="form-select custom-select" name="division" id="division">
                                    <option value="">All Divisions</option>
                                    @foreach($allDivisions as $div)
                                        <option value="{{ $div->name }}" {{ request('division') == $div->name ? 'selected' : '' }}>{{ $div->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="filter-label">
                                    <i class="fa fa-building mr-1"></i> District
                                    <span class="text-muted small ml-1">(Select second)</span>
                                </label>
                                <select class="form-select custom-select" name="district" id="district">
                                    <option value="">All Districts</option>
                                    @foreach($allDistricts as $dist)
                                        <option value="{{ $dist->name }}" {{ request('district') == $dist->name ? 'selected' : '' }}>
                                            {{ $dist->name }} - {{ $dist->division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="filter-label">
                                    <i class="fa fa-map-pin mr-1"></i> Upazila
                                    <span class="text-muted small ml-1">(Select last)</span>
                                </label>
                                <select class="form-select custom-select" name="upazila" id="upazila">
                                    <option value="">All Upazilas</option>
                                    @foreach($allUpazilas as $upa)
                                        <option value="{{ $upa->name }}" {{ request('upazila') == $upa->name ? 'selected' : '' }}>
                                            {{ $upa->name }} - {{ $upa->district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 apply-filters-btn">
                                    <i class="fa fa-search me-2"></i>Search Locations
                                </button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="filter-tips alert alert-info py-2 small">
                                    <i class="fa fa-info-circle mr-1"></i> 
                                    <strong>Tip:</strong> Select a Division first, then District, then Upazila for more specific results. Or search without filters to see all locations.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title"><i class="fa fa-list mr-2"></i> Location Hierarchy</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.locations.index', array_merge(request()->all(), ['export' => 'csv'])) }}" class="btn btn-sm btn-outline-secondary" id="exportBtn">
                            <i class="fa fa-download me-2"></i>Export CSV
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="locationHierarchyTable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sl = 1; @endphp
                                @foreach($divisions as $division)
                                    @if($division->districts->count())
                                        @foreach($division->districts as $district)
                                            @if($district->upazilas->count())
                                                @foreach($district->upazilas as $upazila)
                                                    <tr>
                                                        <td>{{ $sl++ }}</td>
                                                        <td>
                                                            <div>{{ $division->name }}</div>
                                                            <small class="text-muted">{{ $division->bn_name }}</small>
                                                        </td>
                                                        <td>
                                                            <div>{{ $district->name }}</div>
                                                            <small class="text-muted">{{ $district->bn_name }}</small>
                                                        </td>
                                                        <td>
                                                            <div>{{ $upazila->name }}</div>
                                                            <small class="text-muted">{{ $upazila->bn_name }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('admin.locations.upazilas.edit', $upazila->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Upazila">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td>
                                                        <div>{{ $division->name }}</div>
                                                        <small class="text-muted">{{ $division->bn_name }}</small>
                                                    </td>
                                                    <td>
                                                        <div>{{ $district->name }}</div>
                                                        <small class="text-muted">{{ $district->bn_name }}</small>
                                                    </td>
                                                    <td class="text-center text-muted">—</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('admin.locations.districts.edit', $district->id) }}" class="btn btn-sm btn-outline-primary" title="Edit District">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{ $sl++ }}</td>
                                            <td>
                                                <div>{{ $division->name }}</div>
                                                <small class="text-muted">{{ $division->bn_name }}</small>
                                            </td>
                                            <td class="text-center text-muted">—</td>
                                            <td class="text-center text-muted">—</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.locations.divisions.edit', $division->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Division">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if($divisions->count() == 0)
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            <i class="fa fa-info-circle mr-2"></i> No locations found matching your search criteria. Try different filters or <a href="{{ route('admin.locations.index') }}">view all locations</a>.
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $divisions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }
    
    .icon {
        opacity: 0.8;
    }
    
    .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 8px 16px;
        transition: all 0.3s;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn i {
        margin-right: 6px;
    }
    
    .btn-block {
        padding: 12px;
        height: 50px;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 12px 15px;
    }
    
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    .table-hover tbody tr {
        transition: all 0.2s;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transform: scale(1.005);
    }
    
    .btn-group .btn {
        padding: 0.375rem 0.75rem;
    }
    
    .form-select, .form-control {
        border-radius: 6px;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .main-content-inner {
        padding: 20px;
    }
    
    .page-title-area {
        padding: 20px 0;
        background-color: #f8f9fa;
        margin-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    /* Filter Card Styles */
    .filter-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .filter-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    .filter-title {
        color: #333;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .filter-label {
        color: #555;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .custom-select {
        height: 45px;
        border: 1px solid #e1e1e1;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
        width: 100%;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
        padding-right: 30px;
    }

    .custom-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
        background-color: #fff;
    }

    .apply-filters-btn {
        height: 45px;
        border-radius: 6px;
        font-weight: 500;
        letter-spacing: 0.5px;
        background: #007bff;
        border: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .apply-filters-btn i {
        margin-right: 8px;
    }

    .apply-filters-btn:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.2);
    }

    .filter-form {
        padding: 1rem;
    }
    
    .filter-tips {
        margin-bottom: 0;
        background-color: rgba(23, 162, 184, 0.1);
        border-color: rgba(23, 162, 184, 0.2);
        color: #117a8b;
    }
    
    /* Datatable customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e1e1e1;
        border-radius: 6px;
        padding: 8px 12px;
        background-color: #f8f9fa;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e1e1e1;
        border-radius: 6px;
        padding: 4px 8px;
        background-color: #f8f9fa;
    }
    
    /* Export button styling */
    #exportBtn {
        background-color: #fff;
        border: 1px solid #28a745;
        color: #28a745;
        border-radius: 6px;
        transition: all 0.3s ease;
        padding: 6px 15px;
        display: flex;
        align-items: center;
    }
    
    #exportBtn i {
        margin-right: 8px;
    }
    
    #exportBtn:hover {
        background-color: #28a745;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }
    
    /* Card stats hover effects */
    .card.bg-primary, 
    .card.bg-success, 
    .card.bg-info, 
    .card.bg-warning {
        transition: all 0.3s ease;
    }
    
    .card.bg-primary:hover, 
    .card.bg-success:hover, 
    .card.bg-info:hover, 
    .card.bg-warning:hover {
        transform: translateY(-7px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .card.bg-primary .card-footer,
    .card.bg-success .card-footer,
    .card.bg-info .card-footer,
    .card.bg-warning .card-footer {
        background: rgba(0,0,0,0.1);
        border-top: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .custom-select {
            margin-bottom: 1rem;
        }
        
        .apply-filters-btn {
            margin-top: 0.5rem;
        }
        
        .btn-block {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Improved Cascading dropdowns
        function updateDistrictsDropdown() {
            var selectedDivision = $('#division').val();
            if (selectedDivision === '') {
                // Show all districts if no division selected
                $('#district option').show();
            } else {
                // Show only districts from the selected division
            $('#district option').each(function() {
                    var optionText = $(this).text();
                    var divisionOfDistrict = '';
                    
                    // Check if the district belongs to the selected division
                    @foreach($allDistricts as $dist)
                        if ("{{ $dist->name }}" === optionText.split(' - ')[0].trim()) {
                            divisionOfDistrict = "{{ $dist->division->name }}";
                        }
                    @endforeach
                    
                    if (divisionOfDistrict === selectedDivision || $(this).val() === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            }
            // Reset district and upazila selection
            $('#district').val('');
            $('#upazila').val('');
            updateUpazilasDropdown();
        }

        function updateUpazilasDropdown() {
            var selectedDistrict = $('#district').val();
            if (selectedDistrict === '') {
                // Show all upazilas if no district selected
                $('#upazila option').show();
            } else {
                // Show only upazilas from the selected district
            $('#upazila option').each(function() {
                    var optionText = $(this).text();
                    var districtOfUpazila = '';
                    
                    // Check if the upazila belongs to the selected district
                    @foreach($allUpazilas as $upa)
                        if ("{{ $upa->name }}" === optionText.split(' - ')[0].trim()) {
                            districtOfUpazila = "{{ $upa->district->name }}";
                        }
                    @endforeach
                    
                    if (districtOfUpazila === selectedDistrict || $(this).val() === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            }
            // Reset upazila selection
            $('#upazila').val('');
        }

        // Event listeners
        $('#division').on('change', updateDistrictsDropdown);
        $('#district').on('change', updateUpazilasDropdown);

        // Initialize on page load
        updateDistrictsDropdown();
        updateUpazilasDropdown();

        // Enhanced DataTable configuration
        $('#locationHierarchyTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search locations...",
                paginate: {
                    previous: '<i class="fa fa-chevron-left"></i>',
                    next: '<i class="fa fa-chevron-right"></i>'
                },
                emptyTable: "No locations found. Try different filters or create a new location."
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            pageLength: 25,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ],
            paging: false // Disable DataTables paging since we use Laravel pagination
        });
    });
</script>
@endsection 