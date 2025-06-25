<!-- filepath: c:\xampp\htdocs\laravel-role\resources\views\backend\pages\users\edit.blade.php -->
@extends('backend.layouts.master')

@section('title')
User Edit - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
    .required-field::after {
        content: "*";
        color: red;
        margin-left: 3px;
    }
    .form-control:focus {
        border-color:rgb(48, 81, 180);
        box-shadow: 0 0 0 0.2rem rgba(45, 77, 173, 0.25);
        background-color:rgb(156, 252, 204);
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">User Edit</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
                    <li><span>Edit User - {{ $user->name }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit User - {{ $user->name }}</h4>
                    <p class="text-muted font-14 mb-4">Only the Name field is required. All other fields are optional.</p>
                    
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name" class="required-field">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Email (Optional)</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="phone">Phone Number <span class="required-mark">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ $user->phone }}" required>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="blood_group">Blood Group <span class="required-mark">*</span></label>
                                <select class="form-control" id="blood_group" name="blood_group" required>
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ $user->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ $user->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ $user->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ $user->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ $user->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ $user->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ $user->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ $user->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="gender">Gender <span class="required-mark">*</span></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="last_donation_date">Last Donation Date <span class="required-mark">*</span></label>
                                <input type="date" class="form-control" id="last_donation_date" name="last_donation_date" value="{{ $user->last_donation_date ? $user->last_donation_date->format('Y-m-d') : '' }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="total_blood_donation">Total Blood Donations <span class="required-mark">*</span></label>
                                <input type="number" class="form-control" id="total_blood_donation" name="total_blood_donation" min="0" 
                                       value="{{ $user->total_blood_donation > 0 ? $user->total_blood_donation : '' }}" 
                                       placeholder="Enter number of donations" required>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Present Address</h5>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="present_division_id">Division <span class="required-mark">*</span></label>
                                <select class="form-control" id="present_division_id" name="present_division_id" required>
                                    <option value="">Select Division</option>
                                    @foreach(\App\Models\Division::all() as $division)
                                        <option value="{{ $division->id }}" {{ $user->locations->where('type', 'present')->first()?->division_id == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="present_district_id">District <span class="required-mark">*</span></label>
                                <select class="form-control" id="present_district_id" name="present_district_id" {{ $user->locations->where('type', 'present')->first()?->division_id ? '' : 'disabled' }} required>
                                    <option value="">Select District</option>
                                    @if($user->locations->where('type', 'present')->first()?->division_id)
                                        @foreach(\App\Models\District::where('division_id', $user->locations->where('type', 'present')->first()?->division_id)->get() as $district)
                                            <option value="{{ $district->id }}" {{ $user->locations->where('type', 'present')->first()?->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="present_upazila_id">Upazila <span class="required-mark">*</span></label>
                                <select class="form-control" id="present_upazila_id" name="present_upazila_id" {{ $user->locations->where('type', 'present')->first()?->district_id ? '' : 'disabled' }} required>
                                    <option value="">Select Upazila</option>
                                    @if($user->locations->where('type', 'present')->first()?->district_id)
                                        @foreach(\App\Models\Upazila::where('district_id', $user->locations->where('type', 'present')->first()?->district_id)->get() as $upazila)
                                            <option value="{{ $upazila->id }}" {{ $user->locations->where('type', 'present')->first()?->upazila_id == $upazila->id ? 'selected' : '' }}>
                                                {{ $upazila->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="present_address">Street Address (Optional)</label>
                                <textarea class="form-control" id="present_address" name="present_address" rows="2" placeholder="Enter street address, house no, etc.">{{ $user->locations->where('type', 'present')->first()?->address }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Password (Optional)</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                                <small class="form-text text-muted">Leave blank if you don't want to change the password</small>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update User</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();
        
        // Simple form validation to prevent submission if required fields are empty
        $('form').on('submit', function(e) {
            let isValid = true;
            const requiredFields = [
                'name', 'phone', 'blood_group', 'gender', 'last_donation_date', 
                'total_blood_donation', 'present_division_id', 'present_district_id', 'present_upazila_id'
            ];
            
            requiredFields.forEach(field => {
                const value = $(`#${field}`).val();
                if (!value) {
                    $(`#${field}`).css('border-color', 'red');
                    isValid = false;
                } else {
                    $(`#${field}`).css('border-color', '');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
        
        // Reset border color when field is changed
        $('input, select').on('change', function() {
            $(this).css('border-color', '');
        });
        
        // Make form more user-friendly by moving to next field on Enter key
        const formInputs = [
            'name',
            'email',
            'phone',
            'blood_group',
            'gender',
            'last_donation_date',
            'total_blood_donation',
            'present_division_id',
            'present_district_id',
            'present_upazila_id',
            'present_address',
            'password',
            'password_confirmation'
        ];

        // Set up Enter key navigation for each input
        formInputs.forEach((field, index) => {
            const element = $('#' + field);
            if (element.length) {
                element.on('keydown', function(e) {
                    // If Enter key is pressed
                    if (e.which === 13) {
                        e.preventDefault();
                        
                        // Find the next input field
                        let nextIndex = index + 1;
                        while (nextIndex < formInputs.length) {
                            const nextElement = $('#' + formInputs[nextIndex]);
                            if (nextElement.length && !nextElement.prop('disabled')) {
                                nextElement.focus();
                                break;
                            }
                            nextIndex++;
                        }
                        
                        // If we're at the last field, submit the form
                        if (nextIndex >= formInputs.length) {
                            $('form').submit();
                        }
                    }
                });
            }
        });

        // Handle division change
        $('#present_division_id').on('change', function() {
            const divisionId = $(this).val();
            const districtSelect = $('#present_district_id');
            const upazilaSelect = $('#present_upazila_id');
            
            // Reset and disable district and upazila dropdowns
            districtSelect.html('<option value="">Select District</option>').prop('disabled', true);
            upazilaSelect.html('<option value="">Select Upazila</option>').prop('disabled', true);
            
            if (divisionId) {
                // Enable district dropdown and fetch districts
                $.ajax({
                    url: '/get-districts/' + divisionId,
                    type: 'GET',
                    success: function(data) {
                        districtSelect.prop('disabled', false);
                        $.each(data, function(key, district) {
                            districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                        });
                        
                        // Focus on the district dropdown after loading
                        districtSelect.focus();
                    }
                });
            }
        });
        
        // Handle district change
        $('#present_district_id').on('change', function() {
            const districtId = $(this).val();
            const upazilaSelect = $('#present_upazila_id');
            
            // Reset and disable upazila dropdown
            upazilaSelect.html('<option value="">Select Upazila</option>').prop('disabled', true);
            
            if (districtId) {
                // Enable upazila dropdown and fetch upazilas
                $.ajax({
                    url: '/get-upazilas/' + districtId,
                    type: 'GET',
                    success: function(data) {
                        upazilaSelect.prop('disabled', false);
                        $.each(data, function(key, upazila) {
                            upazilaSelect.append('<option value="' + upazila.id + '">' + upazila.name + '</option>');
                        });
                        
                        // Focus on the upazila dropdown after loading
                        upazilaSelect.focus();
                    }
                });
            }
        });
        
        // Set initial focus on the name field when the page loads
        $('#name').focus();
    });
</script>
@endsection