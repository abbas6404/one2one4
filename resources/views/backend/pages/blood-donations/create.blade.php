@extends('backend.layouts.master')

@section('title')
Add New Blood Donation
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
        color: #4e73df;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumbs a:hover {
        color: #2e59d9;
    }

    .main-content-inner {
        padding: 0 30px 30px;
    }

    .form-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .form-header {
        padding: 20px 25px;
        background: linear-gradient(45deg, #4e73df, #4e73df99);
        color: white;
    }

    .form-header h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .form-body {
        padding: 25px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .form-group label {
        font-weight: 500;
        color: #555;
    }

    .form-control {
        border: 1px solid #d1d3e2;
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 14px;
        color: #333;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .form-control-select {
        height: 45px;
    }

    .btn-submit {
        background: #4e73df;
        color: white;
        border: none;
        padding: 10px 25px;
        font-size: 15px;
        font-weight: 500;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-submit:hover {
        background: #2e59d9;
    }

    .btn-cancel {
        background: #858796;
        color: white;
        border: none;
        padding: 10px 25px;
        font-size: 15px;
        font-weight: 500;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
        margin-right: 10px;
    }

    .btn-cancel:hover {
        background: #6e707e;
    }

    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .required-field::after {
        content: '*';
        color: #e74a3b;
        margin-left: 3px;
    }

    .rejection-reason {
        display: none;
    }

    .section-divider {
        margin: 30px 0;
        border-top: 1px dashed #e3e6f0;
    }

    .select2-container--default .select2-results__option {
        padding: 8px 12px;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #4e73df;
    }
    
    .select2-container--default .select2-selection--single {
        height: 45px;
        padding: 8px 15px;
        border: 1px solid #d1d3e2;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
    }
    
    .donor-details {
        font-size: 12px;
        color: #666;
    }
    
    .donor-blood-group {
        font-weight: bold;
        color: #dc3545;
    }
    
    .donor-phone {
        color: #28a745;
    }
    
    .request-details {
        font-size: 12px;
        color: #666;
    }
    
    .request-blood-group {
        font-weight: bold;
        color: #dc3545;
    }
    
    .request-hospital {
        color: #17a2b8;
    }

    .search-container {
        margin-bottom: 15px;
        padding: 15px;
        background-color: #f8f9fc;
        border-radius: 5px;
        border: 1px solid #e3e6f0;
    }
    
    .search-result {
        margin-top: 10px;
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        background-color: #fff;
    }
    
    .search-result-item {
        padding: 10px 15px;
        border-bottom: 1px solid #e3e6f0;
        cursor: pointer;
    }
    
    .search-result-item:hover {
        background-color: #eaecf4;
    }
    
    .search-result-item:last-child {
        border-bottom: none;
    }
    
    .donor-info {
        font-size: 12px;
        color: #666;
    }
    
    .donor-blood-group {
        font-weight: bold;
        color: #e74a3b;
        padding: 2px 8px;
        background-color: rgba(231, 74, 59, 0.1);
        border-radius: 3px;
    }

    /* Add styles for phone number display */
    .phone-number {
        color: #28a745;
        font-weight: 500;
    }
    
    /* Add styles for eligibility status */
    .donor-eligible {
        color: #28a745;
        font-weight: 500;
        margin-left: 5px;
    }
    
    .donor-not-eligible {
        color: #dc3545;
        font-weight: 500;
        margin-left: 5px;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Add New Blood Donation</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.blood_donations.index') }}">Blood Donations</a></li>
                    <li><span>Add New</span></li>
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
            <div class="form-card">
                <div class="form-header">
                    <h2><i class="fa fa-plus-circle"></i> Add New Blood Donation</h2>
                </div>
                <div class="form-body">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.blood_donations.store') }}" method="POST">
                        @csrf
                        
                        <!-- Donor Selection Section -->
                        <div class="section-title">
                            <i class="fa fa-user-md"></i> Donor Information
                        </div>

                        <!-- Donor Search -->
                        <div class="search-container">
                            <div class="form-group">
                                <label for="donor_search"><i class="fa fa-search"></i> Search Donor</label>
                                <input type="text" class="form-control" id="donor_search" placeholder="Search by ID, name, phone or blood group">
                                <small class="form-text text-muted">For phone search, enter at least 5 digits</small>
                            </div>
                            <div class="search-result" id="donor_search_results" style="display: none;">
                                <!-- Search results will appear here -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="donor_id" class="required-field">Selected Donor</label>
                            <select name="donor_id" id="donor_id" class="form-control @error('donor_id') is-invalid @enderror" required>
                                <option value="">-- Select Donor --</option>
                                @foreach($donors as $donor)
                                <option value="{{ $donor->id }}" 
                                    data-phone="{{ $donor->phone }}" 
                                    data-last-donation="{{ $donor->last_donation_date ? $donor->last_donation_date->format('Y-m-d') : '' }}"
                                    {{ old('donor_id') == $donor->id ? 'selected' : '' }}>
                                    {{ $donor->name }} - <strong class="donor-blood-group">{{ $donor->blood_group ?? 'Unknown Blood Group' }}</strong>
                                    @if($donor->last_donation_date)
                                    (Last donation: {{ $donor->last_donation_date->format('M d, Y') }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('donor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="selected_donor_info" class="alert alert-info mt-3" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Name:</strong> <span id="donor_name"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Blood Group:</strong> <span id="donor_blood_group" class="badge badge-danger"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Phone:</strong> <span id="donor_phone"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Last Donation:</strong> <span id="donor_last_donation"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <strong>Eligibility Status:</strong> <span id="donor_eligibility"></span>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Blood Request Section -->
                        <div class="section-title">
                            <i class="fa fa-medkit"></i> Blood Request Information (Optional)
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Only pending and approved blood requests are shown.
                        </div>

                        <!-- Blood Request Search -->
                        <div class="search-container">
                            <div class="form-group">
                                <label for="request_search"><i class="fa fa-search"></i> Search Blood Request</label>
                                <input type="text" class="form-control" id="request_search" placeholder="Search by ID, patient name, hospital or blood type">
                            </div>
                            <div class="search-result" id="request_search_results" style="display: none;">
                                <!-- Search results will appear here -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="blood_request_id">Selected Blood Request</label>
                            <select name="blood_request_id" id="blood_request_id" class="form-control @error('blood_request_id') is-invalid @enderror">
                                <option value="">-- No Request (Independent Donation) --</option>
                                @foreach($bloodRequests as $request)
                                <option value="{{ $request->id }}" {{ old('blood_request_id') == $request->id ? 'selected' : '' }}>
                                    Request #{{ $request->id }} - <span class="blood-group-badge">{{ $request->blood_type }}</span> - 
                                    {{ $request->patient_name ?? 'Unknown Patient' }} - 
                                    {{ $request->hospital_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('blood_request_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="selected_request_info" class="alert alert-info mt-3" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Request ID:</strong> #<span id="request_id"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Blood Type:</strong> <span id="request_blood_type" class="badge badge-danger"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Patient:</strong> <span id="request_patient"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Hospital:</strong> <span id="request_hospital"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Units Needed:</strong> <span id="request_units"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Urgency:</strong> <span id="request_urgency"></span>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider"></div>

                        <!-- Donation Details Section -->
                        <div class="section-title">
                            <i class="fa fa-tint"></i> Donation Information
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> The donation status will be set to "Pending" by default. Blood volume will be automatically assigned.
                        </div>

                        <!-- Hidden input for default status -->
                        <input type="hidden" name="status" value="pending">

                        <div class="form-actions">
                            <a href="{{ route('admin.blood_donations.index') }}" class="btn btn-cancel">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fa fa-check"></i> Create Donation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Update donor info when donor is selected
        $('#donor_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            if (selectedOption.val() === '') {
                $('#selected_donor_info').hide();
                $('.eligibility-warning').remove();
                $('button[type="submit"]').prop('disabled', false);
                return;
            }
            
            // Extract donor information from the option text
            var optionText = selectedOption.text();
            var donorName = optionText.split(' - ')[0].trim();
            var bloodGroup = '';
            
            // Extract blood group - it's between the first " - " and the next " ("
            if (optionText.indexOf(' - ') > -1) {
                var afterName = optionText.split(' - ')[1];
                if (afterName.indexOf(' (') > -1) {
                    bloodGroup = afterName.split(' (')[0].trim();
                } else {
                    bloodGroup = afterName.trim();
                }
            }
            
            // Get phone number from data attribute
            var phone = selectedOption.data('phone') || 'Not provided';
            
            // Display the donor information
            $('#donor_name').text(donorName);
            $('#donor_blood_group').text(bloodGroup);
            $('#donor_phone').text(phone);
            
            // Get last donation if available
            var lastDonation = 'Never';
            var lastDonationDate = selectedOption.data('last-donation') || '';
            
            if (optionText.indexOf('Last donation:') > -1) {
                lastDonation = optionText.split('Last donation:')[1].trim().replace(')', '');
            }
            
            $('#donor_last_donation').text(lastDonation);
            
            // Check donor eligibility
            var isEligible = checkDonorEligibility(lastDonationDate);
            var eligibilityHtml = isEligible ? 
                '<span class="donor-eligible">Eligible for donation</span>' : 
                '<span class="donor-not-eligible">Not eligible until 4 months after last donation</span>';
            $('#donor_eligibility').html(eligibilityHtml);
            
            // Show warning and disable submit button if donor is not eligible
            $('.eligibility-warning').remove();
            if (!isEligible) {
                var warningHtml = '<div class="alert alert-danger mt-3 eligibility-warning">' +
                    '<i class="fa fa-exclamation-triangle"></i> <strong>Warning:</strong> ' +
                    'This donor is not eligible for donation yet. Donors must wait at least 4 months between donations.' +
                    '</div>';
                $('#selected_donor_info').after(warningHtml);
                $('button[type="submit"]').prop('disabled', true);
            } else {
                $('button[type="submit"]').prop('disabled', false);
            }
            
            $('#selected_donor_info').show();
        });
        
        // Trigger donor info display if a donor is already selected
        if ($('#donor_id').val() !== '') {
            $('#donor_id').trigger('change');
        }
        
        // Simple donor search functionality
        $('#donor_search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            if (searchText.length < 1) {
                $('#donor_search_results').hide();
                return;
            }
            
            var resultsHtml = '';
            var matchFound = false;
            var isPhoneSearch = /^\d+$/.test(searchText) && searchText.length >= 5;
            
            // Loop through all donor options
            $('#donor_id option').each(function() {
                if ($(this).val() === '') return; // Skip the placeholder option
                
                var optionText = $(this).text().toLowerCase();
                var donorId = $(this).val();
                var displayText = $(this).text();
                var phoneNumber = $(this).data('phone') || '';
                var lastDonation = $(this).data('last-donation') || '';
                
                // Check if the search text matches the option text or phone number
                var isMatch = false;
                
                if (isPhoneSearch) {
                    // For phone search, check if the phone number contains the search text
                    // Convert both to string and ensure case insensitive comparison
                    var phoneStr = String(phoneNumber).toLowerCase();
                    isMatch = phoneStr.indexOf(searchText) > -1;
                } else {
                    // For regular search, check if the option text contains the search text
                    isMatch = optionText.indexOf(searchText) > -1;
                }
                
                if (isMatch) {
                    // Check donor eligibility based on last donation date
                    var isEligible = checkDonorEligibility(lastDonation);
                    var eligibilityText = isEligible ? 
                        '<span class="donor-eligible">(Eligible)</span>' : 
                        '<span class="donor-not-eligible">(Not eligible yet)</span>';
                    
                    // Highlight blood group in search results
                    var parts = displayText.split(' - ');
                    if (parts.length >= 2) {
                        var donorName = parts[0];
                        var bloodGroup = parts[1];
                        var rest = parts.length > 2 ? ' - ' + parts.slice(2).join(' - ') : '';
                        
                        // Add phone number to display text if it's a phone search
                        var phoneDisplay = isPhoneSearch ? 
                            ' <span class="phone-number">(' + phoneNumber + ')</span>' : '';
                        
                        displayText = donorName + phoneDisplay + ' - <span class="donor-blood-group">' + bloodGroup + '</span>' + rest + ' ' + eligibilityText;
                    }
                    
                    resultsHtml += '<div class="search-result-item" data-id="' + donorId + '">' + displayText + '</div>';
                    matchFound = true;
                }
            });
            
            // Display results
            if (matchFound) {
                $('#donor_search_results').html(resultsHtml).show();
                
                // Handle donor selection
                $('.search-result-item').on('click', function() {
                    var donorId = $(this).data('id');
                    $('#donor_id').val(donorId).trigger('change');
                    $('#donor_search_results').hide();
                });
            } else {
                $('#donor_search_results').html('<div class="p-3">No donors found matching your search.</div>').show();
            }
        });
        
        // Simple blood request search functionality
        $('#request_search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            if (searchText.length < 1) {
                $('#request_search_results').hide();
                return;
            }
            
            var resultsHtml = '';
            var matchFound = false;
            
            // Loop through all request options
            $('#blood_request_id option').each(function() {
                if ($(this).val() === '') return; // Skip the placeholder option
                
                var optionText = $(this).text().toLowerCase();
                var requestId = $(this).val();
                var displayText = $(this).text();
                
                // Check if the search text matches the option text
                if (optionText.indexOf(searchText) > -1) {
                    // Highlight blood type in search results
                    var parts = displayText.split(' - ');
                    if (parts.length >= 2) {
                        var requestNumber = parts[0];
                        var bloodType = parts[1];
                        var rest = parts.slice(2).join(' - ');
                        
                        displayText = requestNumber + ' - <span class="donor-blood-group">' + bloodType + '</span> - ' + rest;
                    }
                    
                    // Add status badge
                    if (displayText.toLowerCase().indexOf('pending') > -1) {
                        displayText += ' <span class="badge badge-warning">Pending</span>';
                    } else if (displayText.toLowerCase().indexOf('approved') > -1) {
                        displayText += ' <span class="badge badge-success">Approved</span>';
                    }
                    
                    resultsHtml += '<div class="search-result-item" data-id="' + requestId + '">' + displayText + '</div>';
                    matchFound = true;
                }
            });
            
            // Display results
            if (matchFound) {
                $('#request_search_results').html(resultsHtml).show();
                
                // Handle request selection
                $('.search-result-item').on('click', function() {
                    var requestId = $(this).data('id');
                    $('#blood_request_id').val(requestId).trigger('change');
                    $('#request_search_results').hide();
                });
            } else {
                $('#request_search_results').html('<div class="p-3">No requests found matching your search.</div>').show();
            }
        });
        
        // Update request info when request is selected
        $('#blood_request_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            if (selectedOption.val() === '') {
                $('#selected_request_info').hide();
                return;
            }
            
            // Extract request information from the option text
            var optionText = selectedOption.text();
            var parts = optionText.split(' - ');
            
            var requestId = parts[0].replace('Request #', '').trim();
            var bloodType = parts[1].trim();
            var patient = parts[2].trim();
            var hospital = parts.length > 3 ? parts[3].trim() : 'Not specified';
            
            // Display the request information
            $('#request_id').text(requestId);
            $('#request_blood_type').text(bloodType);
            $('#request_patient').text(patient);
            $('#request_hospital').text(hospital);
            
            // Get additional information via AJAX
            $.ajax({
                url: '/admin/blood-requests/' + selectedOption.val() + '/info',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#request_units').text(data.units_needed || 'Not specified');
                        
                        var urgency = data.urgency_level || 'normal';
                        var urgencyBadge = urgency === 'urgent' ? 
                            '<span class="badge badge-danger">Urgent</span>' : 
                            '<span class="badge badge-info">Normal</span>';
                        $('#request_urgency').html(urgencyBadge);
                        
                        // Check if donor blood group matches request blood type
                        var donorBloodGroup = $('#donor_blood_group').text().trim();
                        var requestBloodType = data.blood_type;
                        
                        if (donorBloodGroup && requestBloodType) {
                            var isCompatible = checkBloodCompatibility(donorBloodGroup, requestBloodType);
                            if (!isCompatible) {
                                var warningHtml = '<div class="alert alert-warning mt-3 compatibility-warning">' +
                                    '<i class="fa fa-exclamation-triangle"></i> <strong>Warning:</strong> ' +
                                    'The selected donor\'s blood group (' + donorBloodGroup + ') may not be compatible with the requested blood type (' + requestBloodType + ').' +
                                    '</div>';
                                $('#selected_request_info').after(warningHtml);
                            } else {
                                $('.compatibility-warning').remove();
                            }
                        }
                    } else {
                        $('#request_units').text('Not specified');
                        $('#request_urgency').html('<span class="badge badge-secondary">Unknown</span>');
                    }
                },
                error: function() {
                    $('#request_units').text('Not specified');
                    $('#request_urgency').html('<span class="badge badge-secondary">Unknown</span>');
                }
            });
            
            $('#selected_request_info').show();
        });
        
        // Trigger request info display if a request is already selected
        if ($('#blood_request_id').val() !== '') {
            $('#blood_request_id').trigger('change');
        }
        
        // Close search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-container').length) {
                $('.search-result').hide();
            }
        });
    });

    // Function to check if donor is eligible based on last donation date
    function checkDonorEligibility(lastDonationDate) {
        if (!lastDonationDate) {
            return true; // If no last donation date, donor is eligible
        }
        
        var fourMonthsAgo = new Date();
        fourMonthsAgo.setMonth(fourMonthsAgo.getMonth() - 4);
        
        var lastDonation = new Date(lastDonationDate);
        
        // Return true if last donation was more than 4 months ago
        return lastDonation < fourMonthsAgo;
    }

    // Function to check blood compatibility
    function checkBloodCompatibility(donorGroup, recipientType) {
        // Basic compatibility check
        // This is a simplified version and should be expanded with proper medical rules
        if (donorGroup === recipientType) {
            return true;
        }
        
        // O+ can donate to A+, B+, AB+
        if (donorGroup === 'O+' && ['A+', 'B+', 'AB+'].includes(recipientType)) {
            return true;
        }
        
        // O- is universal donor
        if (donorGroup === 'O-') {
            return true;
        }
        
        // A- can donate to A+, A-, AB+, AB-
        if (donorGroup === 'A-' && ['A+', 'A-', 'AB+', 'AB-'].includes(recipientType)) {
            return true;
        }
        
        // A+ can donate to A+, AB+
        if (donorGroup === 'A+' && ['A+', 'AB+'].includes(recipientType)) {
            return true;
        }
        
        // B- can donate to B+, B-, AB+, AB-
        if (donorGroup === 'B-' && ['B+', 'B-', 'AB+', 'AB-'].includes(recipientType)) {
            return true;
        }
        
        // B+ can donate to B+, AB+
        if (donorGroup === 'B+' && ['B+', 'AB+'].includes(recipientType)) {
            return true;
        }
        
        // AB- can donate to AB+, AB-
        if (donorGroup === 'AB-' && ['AB+', 'AB-'].includes(recipientType)) {
            return true;
        }
        
        // AB+ can only donate to AB+
        if (donorGroup === 'AB+' && recipientType === 'AB+') {
            return true;
        }
        
        return false;
    }
</script>
@endsection 