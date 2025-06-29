<div class="donor-profile">
    <div class="row">
        <div class="col-md-4 text-center mb-4 mb-md-0">
            <div class="profile-card">
                @if($donor->profile_picture)
                    <img src="{{ asset($donor->profile_picture) }}" alt="{{ $donor->name }}" class="profile-image">
                @else
                    <div class="profile-image-placeholder">
                        {{ substr($donor->name, 0, 1) }}
                    </div>
                @endif
            
                <h4 class="mt-3 mb-1">{{ $donor->name }}</h4>
                <div class="blood-badge">
                    <i class="fas fa-tint me-1"></i> {{ $donor->blood_group }}
                </div>
            
                <p class="location mb-3">
                    <i class="fas fa-map-marker-alt me-1"></i> 
                    {{ $donor->present_district }}, {{ $donor->present_sub_district }}
                </p>
                
                <div class="donation-info">
                    @if($donor->isAvailableForDonation())
                        <div class="status-badge available">
                            <i class="fas fa-check-circle me-1"></i> Available for donation
                        </div>
                    @else
                        @php
                            $daysRemaining = $donor->getDaysUntilNextDonation();
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
                        @endphp
                        <div class="status-badge unavailable">
                            <i class="fas fa-clock me-1"></i> Available in {{ $availabilityText }}
                        </div>
                    @endif
                </div>
            
                <div class="donor-stats d-flex justify-content-center mt-3">
                    <div class="stat-item">
                        <span class="stat-value">{{ $donor->total_blood_donation ?? 0 }}</span>
                        <span class="stat-label">Donations</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $donor->last_donation_date ? \Carbon\Carbon::parse($donor->last_donation_date)->diffForHumans() : 'Never' }}</span>
                        <span class="stat-label">Last Donated</span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('user.blood-requests.index') }}" class="btn btn-danger w-100">
                        <i class="fas fa-tint me-1"></i> Request Blood
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-user-circle me-2"></i> Personal Information</h5>
                </div>
                <div class="info-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="info-item">
                                <span class="info-label">Age:</span>
                                <span class="info-value">{{ $donor->dob ? \Carbon\Carbon::parse($donor->dob)->age : 'N/A' }} years</span>
                            </div> -->
                            <div class="info-item">
                                <span class="info-label">Gender:</span>
                                <span class="info-value">{{ ucfirst($donor->gender ?? 'N/A') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Member Since:</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($donor->created_at)->format('M Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $donor->email }}</span>
                            </div> -->
                            <div class="info-item">
                                <span class="info-label">Phone:</span>
                                <span class="info-value">{{ $donor->phone ? substr($donor->phone, 0, -3) . 'XXX' : 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Occupation:</span>
                                <span class="info-value">{{ $donor->occupation ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h5><i class="fas fa-tint me-2"></i> Donation History</h5>
                </div>
                <div class="info-card-body">
                    @if($donor->total_blood_donation > 0)
                        <div class="donation-timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Last Donation</h6>
                                    <p class="mb-0">{{ $donor->last_donation_date ? \Carbon\Carbon::parse($donor->last_donation_date)->format('d M, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Total Donations</h6>
                                    <p class="mb-0">{{ $donor->total_blood_donation }} times</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Next Eligible Date</h6>
                                    <p class="mb-0">{{ $donor->getNextEligibleDonationDate() }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="no-donation-info">
                            <i class="fas fa-info-circle me-2 text-muted"></i>
                            <span>This donor has not recorded any donations yet.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 

<style>
    .donor-profile {
        padding: 20px 0;
    }
    
    .profile-card {
        background: #fff;
        border-radius: 15px;
        padding: 30px 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin: 0 auto;
    }
    
    .profile-image-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #fff;
        background: linear-gradient(135deg, #8a0303, #cb0303);
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin: 0 auto;
    }
    
    .blood-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        background-color: #8a0303;
        color: white;
        font-weight: bold;
        font-size: 1rem;
        margin: 10px 0;
    }
    
    .location {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .donation-info {
        margin: 15px 0;
    }
    
    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
    }
    
    .status-badge.available {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    
    .status-badge.unavailable {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .donor-stats {
        margin-top: 20px;
        display: flex;
        justify-content: space-around;
    }
    
    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 15px;
    }
    
    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #8a0303;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .info-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .info-card-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .info-card-header h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }
    
    .info-card-body {
        padding: 20px;
    }
    
    .info-item {
        margin-bottom: 12px;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
        display: inline-block;
        min-width: 100px;
    }
    
    .info-value {
        color: #212529;
    }
    
    .donation-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .donation-timeline:before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: rgba(138, 3, 3, 0.2);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #8a0303;
        box-shadow: 0 0 0 4px rgba(138, 3, 3, 0.2);
    }
    
    .timeline-content {
        padding-left: 10px;
    }
    
    .no-donation-info {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 10px;
        color: #6c757d;
        text-align: center;
    }
    
    .form-control, .form-select {
        padding: 12px 15px;
        border-color: #e0e0e0;
        border-radius: 10px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #8a0303;
        box-shadow: 0 0 0 0.25rem rgba(138, 3, 3, 0.25);
    }
    
    .btn-danger {
        background-color: #8a0303;
        border-color: #8a0303;
    }
    
    .btn-danger:hover {
        background-color: #750202;
        border-color: #750202;
    }
</style> 