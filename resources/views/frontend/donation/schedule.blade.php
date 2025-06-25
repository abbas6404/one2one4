@extends('frontend.layouts.frontend')

@section('title', 'Schedule Donation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4">Schedule a Donation</h4>
                    
                    @if (!$canDonate)
                        <div class="alert alert-warning">
                            {{ $message }}
                        </div>
                    @else
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('donation.schedule.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="donation_date" class="form-label">Donation Date</label>
                                <input type="date" 
                                       class="form-control @error('donation_date') is-invalid @enderror" 
                                       id="donation_date" 
                                       name="donation_date"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('donation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="donation_time" class="form-label">Preferred Time</label>
                                <select class="form-select @error('donation_time') is-invalid @enderror" 
                                        id="donation_time" 
                                        name="donation_time"
                                        required>
                                    <option value="">Select a time slot</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                </select>
                                @error('donation_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="donation_center" class="form-label">Donation Center</label>
                                <select class="form-select @error('donation_center') is-invalid @enderror" 
                                        id="donation_center" 
                                        name="donation_center"
                                        required>
                                    <option value="">Select a donation center</option>
                                    <option value="City Blood Bank">City Blood Bank</option>
                                    <option value="Central Hospital">Central Hospital</option>
                                    <option value="Medical Center">Medical Center</option>
                                    <option value="Community Clinic">Community Clinic</option>
                                </select>
                                @error('donation_center')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Schedule Donation</button>
                                <a href="{{ route('donation.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 