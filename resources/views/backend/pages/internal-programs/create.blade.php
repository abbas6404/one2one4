@extends('backend.layouts.master')

@section('title')
Add New Internal Program
@endsection

@section('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f1f1f1;
    }
    .card-title {
        margin-bottom: 0;
        font-weight: 600;
    }
    .form-section {
        margin-bottom: 30px;
    }
    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f1f1;
    }
    .form-group label {
        font-weight: 500;
    }
    .required:after {
        content: " *";
        color: red;
    }
    .custom-file-label {
        overflow: hidden;
    }
    .form-control {
        border-radius: 20px;
        padding: 5px 20px;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Add New Internal Program</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.internal-programs.index') }}">Internal Programs</a></li>
                    <li><span>Add New Program</span></li>
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
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Add New Internal Program</h4>
                    <a href="{{ route('admin.internal-programs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.internal-programs.store') }}" method="POST">
                        @csrf

                        <div class="form-section">
                            <div class="form-section-title">Basic Information</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="required">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="required">Location</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control @error('division_id') is-invalid @enderror" id="division_id" name="division_id" required>
                                                    <option value="">Select Division</option>
                                                    @foreach(\App\Models\Division::orderBy('name')->get() as $division)
                                                        <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                            {{ $division->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('division_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control @error('district_id') is-invalid @enderror" id="district_id" name="district_id" required>
                                                    <option value="">Select District</option>
                                                    @if(old('division_id'))
                                                        @foreach(\App\Models\District::where('division_id', old('division_id'))->orderBy('name')->get() as $district)
                                                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                                {{ $district->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('district_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id" required>
                                                    <option value="">Select Upazila</option>
                                                    @if(old('district_id'))
                                                        @foreach(\App\Models\Upazila::where('district_id', old('district_id'))->orderBy('name')->get() as $upazila)
                                                            <option value="{{ $upazila->id }}" {{ old('upazila_id') == $upazila->id ? 'selected' : '' }}>
                                                                {{ $upazila->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('upazila_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">Program Details</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tshirt_size" class="required">T-shirt Size</label>
                                        <select class="form-control @error('tshirt_size') is-invalid @enderror" id="tshirt_size" name="tshirt_size" required>
                                            <option value="">Select T-shirt Size</option>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="event_id">Associated Event</label>
                                        <select class="form-control @error('event_id') is-invalid @enderror" id="event_id" name="event_id">
                                            <option value="">Select Event (Optional)</option>
                                            @foreach($events as $event)
                                                <option value="{{ $event->id }}" 
                                                    {{ old('event_id') == $event->id ? 'selected' : '' }}
                                                    data-fee="{{ $event->event_fee }}">
                                                    {{ $event->title }} 
                                                    @if($event->is_featured) [Featured] @endif
                                                    @if($event->event_fee) - {{ $event->event_fee }} BDT @endif
                                                    ({{ $event->start_date->format('M d, Y') }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('event_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">Payment Information</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="payment_amount">Payment Amount</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control @error('payment_amount') is-invalid @enderror" id="payment_amount" name="payment_amount" value="{{ old('payment_amount') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">BDT</span>
                                            </div>
                                            @error('payment_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for required data -->
                        <input type="hidden" name="blood_group" value="A+">
                        <input type="hidden" name="payment_method" value="Cash">

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
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
        // Update payment amount when event is selected
        $('#event_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var fee = selectedOption.data('fee');
            
            if (fee) {
                $('#payment_amount').val(fee);
            } else {
                $('#payment_amount').val('');
            }
        });

        // Handle location dropdowns
        $('#division_id').on('change', function() {
            var divisionId = $(this).val();
            if (divisionId) {
                // Clear subsequent dropdowns
                $('#district_id').empty().append('<option value="">Select District</option>');
                $('#upazila_id').empty().append('<option value="">Select Upazila</option>');
                
                // Get districts for the selected division
                $.ajax({
                    url: '/get-districts/' + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
        
        $('#district_id').on('change', function() {
            var districtId = $(this).val();
            if (districtId) {
                // Clear upazila dropdown
                $('#upazila_id').empty().append('<option value="">Select Upazila</option>');
                
                // Get upazilas for the selected district
                $.ajax({
                    url: '/get-upazilas/' + districtId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#upazila_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection 