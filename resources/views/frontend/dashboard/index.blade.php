@extends('frontend.layouts.frontend')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section (Desktop only) -->
    <div class="d-none d-lg-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-dark fw-bold mb-0">My Blood Donation Dashboard</h1>
        <div class="d-flex">
            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-user me-1"></i> Profile
            </a>
            @if($stats['is_eligible'])
                <!-- <a href="{{ route('user.donation.schedule') }}" class="btn donor-gradient text-white">
                    <i class="fas fa-tint me-1"></i> Donate Now
                </a> -->
            @endif
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="user-profile-card shadow-sm mb-4">
        <div class="container-fluid">
            <div class="row">
        <div class="col-md-12">
                    <div class="d-flex align-items-end">
                            <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('images/avatar.png') }}" 
                            alt="Profile Picture" class="user-avatar">
                        <div class="user-profile-content">
                            <h4 class="user-name mb-1">{{ auth()->user()->name }}</h4>
                            <p class="user-email mb-2">
                                <i class="fas fa-envelope me-1"></i> {{ auth()->user()->email }}
                            </p>
                            <div class="d-flex align-items-center">
                                <span class="blood-type-badge me-2">
                                    <i class="fas fa-tint"></i> {{ $stats['blood_group'] }}
                                </span>
                                @if(auth()->user()->is_donor)
                                    <span class="donor-badge bg-success text-white">
                                        <i class="fas fa-user me-1"></i> Donor
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card stats-card {{ $stats['is_eligible'] ? 'eligible-now-gradient' : 'eligibility-gradient' }}">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-label">Next Eligible</div>
                        <div class="stats-value">
                            @if($stats['is_eligible'])
                                Now
                            @else
                                {{ (int)$stats['days_until_eligible'] }} Days
                            @endif
                        </div>
                        <div class="stats-info">4 months between donations</div>
                        </div>
                    <div class="stats-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card donation-gradient">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-label">Total Donations</div>
                        <div class="stats-value">{{ $stats['total_donations'] }}</div>
                        <div class="stats-info">Last: {{ $stats['last_donation'] }}</div>
                        </div>
                    <div class="stats-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card volume-gradient">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-label">Total Volume</div>
                        <div class="stats-value">{{ number_format($stats['total_volume'], 1) }}L</div>
                        <div class="stats-info">450ml per donation</div>
                        </div>
                    <div class="stats-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card lives-gradient">
                <div class="card-body">
                    <div class="stats-content">
                        <div class="stats-label">Lives Saved</div>
                        <div class="stats-value">{{ $stats['lives_saved'] }}</div>
                        <div class="stats-info">3 lives per donation</div>
                        </div>
                    <div class="stats-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Chart -->
    <div class="row">
        <!-- Donation Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card droplet-card shadow-sm">
                <div class="card-header blood-themed-header bg-white">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-bar"></i>Donation History</h5>
                </div>
                <div class="card-body chart-container">
                    <canvas id="donationChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card droplet-card shadow-sm">
                <div class="card-header blood-themed-header bg-white">
                    <h5 class="card-title mb-0"><i class="fas fa-history"></i>Recent Donations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @if(isset($recentDonations) && $recentDonations->count() > 0)
                            @foreach($recentDonations as $donation)
                                <div class="list-group-item blood-list-item">
                                    <div class="d-flex align-items-center">
                                        <div class="droplet-icon-wrapper me-3">
                                            <i class="fas fa-tint droplet-icon"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-1">
                                            <h6 class="mb-0 fw-bold">Blood Donation</h6>
                                            <small class="text-muted">{{ Carbon\Carbon::parse($donation->donation_date)->diffForHumans() }}</small>
                                        </div>
                                        <span class="status-badge donor-gradient text-white">Completed</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="list-group-item py-4">
                                <div class="text-center">
                                    <div class="text-muted mb-2"><i class="fas fa-tint fa-2x opacity-25"></i></div>
                                    <p class="text-muted mb-0">No recent donations</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --blood-red: #dc3545;
    --blood-dark: #a71d2a;
    --blood-light: #f5c2c7;
    --blood-accent: #FF5C72;
    --plasma-yellow: #FFC107;
    --oxygen-blue: #0D6EFD;
    --save-life-green: #28a745;
    --text-dark: #343a40;
    --text-light: #6c757d;
    --light-bg: #f8f9fa;
}

body {
    background-color: #f9fafb;
}

/* Card Designs */
.card {
    border: none;
    border-radius: 16px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 24px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.06);
}

.card-header {
    padding: 1.2rem 1.5rem;
    background-color: white;
    border-bottom: none;
    position: relative;
}

.card-body {
    padding: 1.5rem;
}

/* Blood Droplet Card Design */
.droplet-card {
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.droplet-card::before {
    content: "";
    position: absolute;
    width: 210px;
    height: 210px;
    background: radial-gradient(circle, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0) 70%);
    border-radius: 50%;
    right: -105px;
    top: -105px;
    z-index: -1;
}

.droplet-card::after {
    content: "";
    position: absolute;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0) 70%);
    border-radius: 50%;
    left: -60px;
    bottom: -60px;
    z-index: -1;
}

/* Blood Themed Stats Cards */
.stats-card {
    color: white;
    position: relative;
    overflow: hidden;
    min-height: 150px;
}

.stats-icon {
    position: absolute;
    right: 20px;
    bottom: 20px;
    font-size: 4rem;
    opacity: 0.15;
    transform: rotate(15deg);
    color: rgba(255, 255, 255, 0.5);
    transition: all 0.3s ease;
}

.stats-card:hover .stats-icon {
    transform: rotate(0deg) scale(1.1);
    opacity: 0.25;
}

.stats-content {
    position: relative;
    z-index: 2;
}

.stats-value {
    font-size: 2.2rem;
    font-weight: 600;
    margin-bottom: 5px;
    line-height: 1.2;
}

.stats-label {
    text-transform: uppercase;
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    opacity: 0.8;
    margin-bottom: 10px;
}

.stats-info {
    font-size: 0.7rem;
    opacity: 0.7;
    letter-spacing: 0.3px;
}

/* Blood Type Badge */
.blood-type-badge {
    font-weight: 700;
    font-size: 0.9rem;
    padding: 6px 12px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--blood-red) 0%, var(--blood-dark) 100%);
    color: white;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 3px 6px rgba(220, 53, 69, 0.2);
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
}

.blood-type-badge::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
}

.blood-type-badge i {
    margin-right: 5px;
    font-size: 0.9rem;
}

/* Blood Gradients */
.donor-gradient {
    background: linear-gradient(135deg, var(--blood-red) 0%, var(--blood-dark) 100%);
}

.eligibility-gradient {
    background: linear-gradient(135deg, var(--plasma-yellow) 0%, #FD7E14 100%);
}

.eligible-now-gradient {
    background: linear-gradient(135deg, var(--save-life-green) 0%, #198754 100%);
}

.donation-gradient {
    background: linear-gradient(135deg, var(--blood-accent) 0%, var(--blood-red) 100%);
}

.volume-gradient {
    background: linear-gradient(135deg, var(--oxygen-blue) 0%, #0a58ca 100%);
}

.lives-gradient {
    background: linear-gradient(135deg, #6f42c1 0%, #4c0bce 100%);
}

/* Blood Themed List Items */
.blood-list-item {
    border-left: 3px solid var(--blood-red);
    transition: all 0.3s ease;
    padding: 1rem 1.25rem;
}

.blood-list-item:hover {
    background-color: rgba(220, 53, 69, 0.03);
}

/* Droplet Icon */
.droplet-icon-wrapper {
    position: relative;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(220, 53, 69, 0.1);
    overflow: hidden;
}

.droplet-icon-wrapper::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
    z-index: 1;
}

.droplet-icon {
    color: var(--blood-red);
    font-size: 1.2rem;
    z-index: 2;
}

/* Card Headers with Blood Theme */
.blood-themed-header {
    position: relative;
    border-bottom: none;
    padding-bottom: 1rem;
}

.blood-themed-header::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 1.5rem;
    right: 1.5rem;
    height: 2px;
    background: linear-gradient(90deg, var(--blood-red), rgba(220, 53, 69, 0.2));
    border-radius: 2px;
}

.blood-themed-header .card-title {
    color: var(--text-dark);
    font-weight: 600;
    display: flex;
    align-items: center;
}

.blood-themed-header i {
    color: var(--blood-red);
    margin-right: 10px;
}

/* Donor status badge */
.donor-badge {
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
}

/* Custom Status Badge */
.status-badge {
    font-weight: 600;
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 6px;
}

/* User Profile Card */
.user-profile-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
}

.user-profile-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: linear-gradient(to right, rgba(235, 22, 43, 0.8), rgba(39, 28, 197, 0.8));
    z-index: 0;
}

.user-avatar {
    width: 85px;
    height: 85px;
    border-radius: 16px;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
    margin-top: 30px;
}

.user-profile-content {
    position: relative;
    z-index: 1;
    padding: 1.5rem;
    padding-top: 0;
}

.user-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
}

.user-email {
    color: var(--text-light);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

/* Chart Styling */
.chart-container {
    position: relative;
    padding: 0;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('donationChart').getContext('2d');
    const chartData = {!! json_encode($donationChart ?? [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'data' => array_fill(0, 12, 0)
    ]) !!};

    // Create blood-red gradient for chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(220, 53, 69, 0.8)');
    gradient.addColorStop(1, 'rgba(220, 53, 69, 0.1)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Donations',
                data: chartData.data,
                backgroundColor: gradient,
                borderColor: 'rgba(220, 53, 69, 0.6)',
                borderWidth: 1,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(220, 53, 69, 0.9)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#5a5c69',
                        font: {
                            family: "'Inter', sans-serif",
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.03)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#5a5c69',
                        font: {
                            family: "'Inter', sans-serif",
                        }
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#343a40',
                    bodyColor: '#6c757d',
                    titleFont: {
                        weight: 'bold',
                        family: "'Inter', sans-serif",
                    },
                    bodyFont: {
                        family: "'Inter', sans-serif",
                    },
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    displayColors: false,
                    caretSize: 6,
                    cornerRadius: 6,
                    boxPadding: 6,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label + ' ' + new Date().getFullYear();
                        },
                        label: function(context) {
                            let label = ' ';
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + (context.parsed.y === 1 ? ' Donation' : ' Donations');
                            }
                            return label;
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endpush