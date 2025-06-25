@extends('frontend.layouts.frontend')

@section('title', 'Edit Blood Request')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Blood Request
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('blood-requests.update', $bloodRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Blood Information -->
                        <div class="row mb-4">
                            <h6 class="text-danger mb-3">Blood Information</h6>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="blood_type" class="form-label">Blood Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type" required>
                                        <option value="">Select Blood Type</option>
                                        <option value="A+" {{ old('blood_type', $bloodRequest->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type', $bloodRequest->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type', $bloodRequest->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type', $bloodRequest->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="O+" {{ old('blood_type', $bloodRequest->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type', $bloodRequest->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                        <option value="AB+" {{ old('blood_type', $bloodRequest->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type', $bloodRequest->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    </select>
                                    @error('blood_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="units_needed" class="form-label">Units Needed <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('units_needed') is-invalid @enderror" 
                                           id="units_needed" name="units_needed" value="{{ old('units_needed', $bloodRequest->units_needed) }}" 
                                           required min="1" max="10">
                                    @error('units_needed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="needed_date" class="form-label">Needed By Date</label>
                                    <input type="date" class="form-control @error('needed_date') is-invalid @enderror" 
                                           id="needed_date" name="needed_date" 
                                           value="{{ old('needed_date', $bloodRequest->needed_date ? $bloodRequest->needed_date->format('Y-m-d') : '') }}"
                                           min="{{ date('Y-m-d') }}">
                                    @error('needed_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Urgency Level -->
                        <div class="row mb-4">
                            <h6 class="text-danger mb-3">Urgency Level</h6>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div class="flex-fill">
                                            <input type="radio" class="btn-check" name="urgency_level" id="urgency_low" 
                                                   value="low" {{ old('urgency_level', $bloodRequest->urgency_level) == 'low' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success w-100" for="urgency_low">
                                                <i class="fas fa-clock me-2"></i>Low
                                            </label>
                                        </div>
                                        <div class="flex-fill">
                                            <input type="radio" class="btn-check" name="urgency_level" id="urgency_medium" 
                                                   value="medium" {{ old('urgency_level', $bloodRequest->urgency_level) == 'medium' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info w-100" for="urgency_medium">
                                                <i class="fas fa-heartbeat me-2"></i>Medium
                                            </label>
                                        </div>
                                        <div class="flex-fill">
                                            <input type="radio" class="btn-check" name="urgency_level" id="urgency_high" 
                                                   value="high" {{ old('urgency_level', $bloodRequest->urgency_level) == 'high' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning w-100" for="urgency_high">
                                                <i class="fas fa-exclamation-circle me-2"></i>High
                                            </label>
                                        </div>
                                        <div class="flex-fill">
                                            <input type="radio" class="btn-check" name="urgency_level" id="urgency_critical" 
                                                   value="critical" {{ old('urgency_level', $bloodRequest->urgency_level) == 'critical' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger w-100" for="urgency_critical">
                                                <i class="fas fa-exclamation-triangle me-2"></i>Critical
                                            </label>
                                        </div>
                                    </div>
                                    @error('urgency_level')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Hospital Information -->
                        <div class="row mb-4">
                            <h6 class="text-danger mb-3">Hospital Information</h6>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hospital_name" class="form-label">Hospital Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('hospital_name') is-invalid @enderror" 
                                           id="hospital_name" name="hospital_name" value="{{ old('hospital_name', $bloodRequest->hospital_name) }}" required>
                                    @error('hospital_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hospital_address" class="form-label">Hospital Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('hospital_address') is-invalid @enderror" 
                                              id="hospital_address" name="hospital_address" rows="1" required>{{ old('hospital_address', $bloodRequest->hospital_address) }}</textarea>
                                    @error('hospital_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="row mb-4">
                            <h6 class="text-danger mb-3">Additional Information</h6>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="additional_notes" class="form-label">Additional Notes</label>
                                    <textarea class="form-control @error('additional_notes') is-invalid @enderror" 
                                              id="additional_notes" name="additional_notes" rows="3"
                                              placeholder="Any additional information that might help donors...">{{ old('additional_notes', $bloodRequest->additional_notes) }}</textarea>
                                    @error('additional_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('blood-requests.show', $bloodRequest->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i>Update Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-check:checked + .btn-outline-success {
        background-color: var(--bs-success);
        color: white;
    }
    .btn-check:checked + .btn-outline-info {
        background-color: var(--bs-info);
        color: white;
    }
    .btn-check:checked + .btn-outline-warning {
        background-color: var(--bs-warning);
        color: white;
    }
    .btn-check:checked + .btn-outline-danger {
        background-color: var(--bs-danger);
        color: white;
    }
</style>
@endpush
@endsection 