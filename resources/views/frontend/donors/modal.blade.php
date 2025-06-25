<!-- Profile Header -->
<div class="text-center mb-4">
    <!-- Profile Image Container -->
    <div class="profile-image-container position-relative" style="width: 180px; height: 180px; margin: 0 auto;">
        <div id="fallback-avatar-{{ $donor->id }}" 
            class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center w-100 h-100" 
            style="border: 4px solid #dc3545; box-shadow: 0 0 15px rgba(0,0,0,0.1); font-size: 4.5rem; {{ $donor->profile_picture ? 'display: none;' : '' }}">
            {{ strtoupper(substr($donor->name, 0, 1)) }}
        </div>
        
        @if($donor->profile_picture)
            <img src="{{ asset('storage/profile_pictures/' . $donor->profile_picture) }}" 
                alt="{{ $donor->name }}'s profile photo" 
                class="rounded-circle w-100 h-100 position-absolute top-0 start-0"
                style="object-fit: cover; border: 4px solid #dc3545; box-shadow: 0 0 15px rgba(0,0,0,0.1);"
                onerror="this.style.display='none'; document.getElementById('fallback-avatar-{{ $donor->id }}').style.display='flex';">
        @endif
    </div>

    <h3 class="mb-1 mt-3">{{ $donor->name }}</h3>
    <p class="text-muted mb-2">{{ $donor->email }}</p>
    <div>
        <span class="badge bg-danger bg-opacity-10 text-danger">
            <i class="fas fa-tint me-1"></i>{{ $donor->blood_group }}
        </span>
        @if($donor->total_blood_donation > 0)
            <span class="badge bg-success bg-opacity-10 text-success ms-2">
                <i class="fas fa-check-circle me-1"></i>{{ $donor->total_blood_donation }} Donations
            </span>
        @else
            <span class="badge bg-secondary bg-opacity-10 text-secondary ms-2">
                <i class="fas fa-times-circle me-1"></i>Never Donated
            </span>
        @endif
    </div>
</div>

<div class="row">
    <!-- Profile Details -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Personal Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Phone</p>
                        <p class="mb-0">
                            @if($donor->phone)
                                {{ substr($donor->phone, 0, -3) . '***' }}
                            @else
                                Not provided
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Gender</p>
                        <p class="mb-0">{{ ucfirst($donor->gender ?? 'Not specified') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Age</p>
                        <p class="mb-0">
                            @if($donor->dob)
                                {{ $donor->age }} years
                                <small class="text-muted d-block">
                                    (Born: {{ \Carbon\Carbon::parse($donor->dob)->format('M d, Y') }})
                                </small>
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Member Since</p>
                        <p class="mb-0">{{ $donor->created_at->format('M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Last Donation</p>
                        <p class="mb-0">
                            @if($donor->last_donation_date)
                                {{ \Carbon\Carbon::parse($donor->last_donation_date)->format('M d, Y') }}
                            @else
                                Never donated
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Contact:</strong> 
                            @if($donor->contact)
                                {{ substr($donor->contact, 0, -3) . '***' }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                </div>

                <h5 class="card-title mb-4 mt-4">Location</h5>
                <p class="text-muted mb-1">Present Address</p>
                <p class="mb-3">{{ $donor->present_address }}</p>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Sub District</p>
                        <p class="mb-0">{{ $donor->present_sub_district }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">District</p>
                        <p class="mb-0">{{ $donor->present_district }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Medical Information</h5>
                
                <div class="mb-3">
                    <p class="text-muted mb-1">Medical Conditions</p>
                    <p class="mb-0">{{ $donor->medical_conditions ?? 'None reported' }}</p>
                </div>

                <div class="mb-0">
                    <p class="text-muted mb-1">Availability Status</p>
                    <p class="mb-0">
                        @if($donor->last_donation_date)
                            @php
                                $lastDonation = \Carbon\Carbon::parse($donor->last_donation_date);
                                $nextDonation = $lastDonation->copy()->addMonths(4);
                                $isAvailable = now()->greaterThan($nextDonation);
                                
                                if (!$isAvailable) {
                                    $daysRemaining = now()->diffInDays($nextDonation, false);
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
                            
                            @if($isAvailable)
                                <span class="text-success">
                                    <i class="fas fa-circle me-1"></i>Available for donation
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="fas fa-circle me-1"></i>Not available until {{ $nextDonation->format('M d, Y') }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    (Available in {{ $availabilityText }})
                                </small>
                            @endif
                        @else
                            <span class="text-success">
                                <i class="fas fa-circle me-1"></i>Available for donation
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div> 