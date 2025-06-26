@extends('backend.layouts.master')

@section('title')
Edit Internal Program
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
    .current-screenshot {
        margin-top: 10px;
        max-width: 200px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px;
    }
    .current-screenshot img {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit Internal Program</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.internal-programs.index') }}">Internal Programs</a></li>
                    <li><span>Edit Program</span></li>
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
                    <h4 class="card-title">Edit Internal Program</h4>
                    <div>
                        <a href="{{ route('admin.internal-programs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.internal-programs.show', $internalProgram->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> View Details
                        </a>
                    </div>
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

                    <form action="{{ route('admin.internal-programs.update', $internalProgram->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-section">
                            <div class="form-section-title">Personal Information</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $internalProgram->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="required">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $internalProgram->phone) }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email (Optional)</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $internalProgram->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="blood_group" class="required">Blood Group</label>
                                        <select class="form-control @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" required>
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" {{ old('blood_group', $internalProgram->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_group', $internalProgram->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_group', $internalProgram->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_group', $internalProgram->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_group', $internalProgram->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_group', $internalProgram->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_group', $internalProgram->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_group', $internalProgram->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_group')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="present_address" class="required">Present Address</label>
                                        <textarea class="form-control @error('present_address') is-invalid @enderror" id="present_address" name="present_address" rows="3" required>{{ old('present_address', $internalProgram->present_address) }}</textarea>
                                        @error('present_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <option value="S" {{ old('tshirt_size', $internalProgram->tshirt_size) == 'S' ? 'selected' : '' }}>Small (S)</option>
                                            <option value="M" {{ old('tshirt_size', $internalProgram->tshirt_size) == 'M' ? 'selected' : '' }}>Medium (M)</option>
                                            <option value="L" {{ old('tshirt_size', $internalProgram->tshirt_size) == 'L' ? 'selected' : '' }}>Large (L)</option>
                                            <option value="XL" {{ old('tshirt_size', $internalProgram->tshirt_size) == 'XL' ? 'selected' : '' }}>Extra Large (XL)</option>
                                            <option value="XXL" {{ old('tshirt_size', $internalProgram->tshirt_size) == 'XXL' ? 'selected' : '' }}>Double XL (XXL)</option>
                                        </select>
                                        @error('tshirt_size')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="required">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="pending" {{ old('status', $internalProgram->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ old('status', $internalProgram->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ old('status', $internalProgram->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">Payment Information</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method" class="required">Payment Method</label>
                                        <select class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="bKash" {{ old('payment_method', $internalProgram->payment_method) == 'bKash' ? 'selected' : '' }}>bKash</option>
                                            <option value="Nagad" {{ old('payment_method', $internalProgram->payment_method) == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                            <option value="Rocket" {{ old('payment_method', $internalProgram->payment_method) == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                            <option value="Cash" {{ old('payment_method', $internalProgram->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Bank Transfer" {{ old('payment_method', $internalProgram->payment_method) == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trx_id">Transaction ID (Optional)</label>
                                        <input type="text" class="form-control @error('trx_id') is-invalid @enderror" id="trx_id" name="trx_id" value="{{ old('trx_id', $internalProgram->trx_id) }}">
                                        @error('trx_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="screenshot">Payment Screenshot (Optional)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot">
                                            <label class="custom-file-label" for="screenshot">Choose file</label>
                                            @error('screenshot')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Accepted file types: JPG, PNG. Max size: 2MB.</small>
                                        
                                        @if($internalProgram->screenshot)
                                            <div class="current-screenshot mt-2">
                                                <p>Current Screenshot:</p>
                                                <img src="{{ $internalProgram->screenshot_url }}" alt="Current Screenshot">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.internal-programs.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
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
        // Update file input label when file is selected
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endsection 