<!-- filepath: c:\xampp\htdocs\laravel-role\resources\views\backend\pages\dashboard\index.blade.php -->
@extends('backend.layouts.master')

@section('title')
Dashboard - Blood Donation Management System
@endsection

@section('styles')
<style>
    .stat-card {
        border-radius: 10px;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .stat-card .card-body {
        padding: 1.5rem;
    }

    .stat-card .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: rgba(255,255,255,0.8);
    }

    .stat-card .stat-title {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.8);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
    }

    .stat-card .stat-desc {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.7);
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #e84c3d, #e84c3d99);
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #2ecc71, #2ecc7199);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #3498db, #3498db99);
    }

    .bg-gradient-warning {
        background: linear-gradient(45deg, #f1c40f, #f1c40f99);
    }

    .bg-gradient-danger {
        background: linear-gradient(45deg, #c0392b, #c0392b99);
    }
    
    .bg-gradient-secondary {
        background: linear-gradient(45deg, #7f8c8d, #7f8c8d99);
    }

    .activity-card {
        border-radius: 10px;
        border: 1px solid #eee;
        margin-bottom: 1.5rem;
    }

    .activity-card .card-header {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 1rem 1.5rem;
    }

    .activity-card .card-header h5 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }

    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .activity-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 500;
        margin-bottom: 0.25rem;
        color: #333;
    }

    .activity-time {
        font-size: 0.85rem;
        color: #666;
    }

    .chart-card {
        border-radius: 10px;
        border: 1px solid #eee;
        margin-bottom: 1.5rem;
    }

    .chart-card .card-header {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 1rem 1.5rem;
    }

    .chart-container {
        padding: 1.5rem;
        height: 300px;
    }
    
    .blood-type-pill {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        margin-right: 5px;
        margin-bottom: 5px;
        color: white;
        font-size: 0.9rem;
    }
    
    .blood-a-pos {
        background-color: #e74c3c;
    }
    
    .blood-a-neg {
        background-color: #c0392b;
    }
    
    .blood-b-pos {
        background-color: #3498db;
    }
    
    .blood-b-neg {
        background-color: #2980b9;
    }
    
    .blood-ab-pos {
        background-color: #9b59b6;
    }
    
    .blood-ab-neg {
        background-color: #8e44ad;
    }
    
    .blood-o-pos {
        background-color: #2ecc71;
    }
    
    .blood-o-neg {
        background-color: #27ae60;
    }
    
    .recent-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .recent-item:last-child {
        border-bottom: none;
    }
    
    .recent-item .title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .recent-item .info {
        font-size: 0.85rem;
        color: #666;
    }
    
    .recent-item .time {
        font-size: 0.8rem;
        color: #999;
    }
    
    .status-badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-pending {
        background-color: #f1c40f;
        color: #000;
    }
    
    .status-approved {
        background-color: #3498db;
        color: #fff;
    }
    
    .status-completed {
        background-color: #2ecc71;
        color: #fff;
    }
    
    .status-rejected {
        background-color: #e74c3c;
        color: #fff;
    }
    
    .status-urgent {
        background-color: #c0392b;
        color: #fff;
    }
</style>
@endsection

@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><span>Dashboard</span></li>
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
    <!-- Primary Stats Row -->
    <div class="row mt-4">
        <!-- Blood Requests Card -->
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-primary">
                <div class="card-body">
                    <i class="fa fa-heartbeat stat-icon"></i>
                    <h6 class="stat-title">Blood Requests</h6>
                    <h2 class="stat-value">{{ $total_requests }}</h2>
                    <p class="stat-desc">Pending: {{ $pending_requests }}</p>
                </div>
            </div>
        </div>

        <!-- Blood Donations Card -->
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-success">
                <div class="card-body">
                    <i class="fa fa-medkit stat-icon"></i>
                    <h6 class="stat-title">Donations</h6>
                    <h2 class="stat-value">{{ $total_donations }}</h2>
                    <p class="stat-desc">Completed: {{ $completed_donations }}</p>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-info">
                <div class="card-body">
                    <i class="fa fa-users stat-icon"></i>
                    <h6 class="stat-title">Users</h6>
                    <h2 class="stat-value">{{ $total_users }}</h2>
                    <p class="stat-desc">Donors: {{ $total_donors }}</p>
                </div>
            </div>
        </div>

        <!-- Blood Volume Card -->
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-warning">
                <div class="card-body">
                    <i class="fa fa-tint stat-icon"></i>
                    <h6 class="stat-title">Blood Volume</h6>
                    <h2 class="stat-value">{{ number_format($total_blood_volume, 1) }}L</h2>
                    <p class="stat-desc">450ml per donation</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="row mt-3">
        <!-- Approved Requests Card -->
        <div class="col-md-3">
            <div class="card stat-card" style="background: linear-gradient(45deg, #3498db, #3498db99);">
                <div class="card-body">
                    <i class="fa fa-thumbs-up stat-icon"></i>
                    <h6 class="stat-title">Approved</h6>
                    <h2 class="stat-value">{{ $approved_requests }}</h2>
                    <p class="stat-desc">Ready for donation</p>
                </div>
            </div>
        </div>
        
        <!-- Urgent Requests Card -->
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-danger">
                <div class="card-body">
                    <i class="fa fa-exclamation-circle stat-icon"></i>
                    <h6 class="stat-title">Urgent</h6>
                    <h2 class="stat-value">{{ $urgent_requests }}</h2>
                    <p class="stat-desc">High priority requests</p>
                </div>
            </div>
        </div>
        
        <!-- Completed Requests Card -->
        <div class="col-md-3">
            <div class="card stat-card" style="background: linear-gradient(45deg, #27ae60, #27ae6099);">
                <div class="card-body">
                    <i class="fa fa-check-circle stat-icon"></i>
                    <h6 class="stat-title">Completed</h6>
                    <h2 class="stat-value">{{ $completed_requests }}</h2>
                    <p class="stat-desc">Fulfilled requests</p>
                </div>
            </div>
        </div>
        
        <!-- Regular Requests Card -->
        <div class="col-md-3">
            <div class="card stat-card bg-gradient-secondary">
                <div class="card-body">
                    <i class="fa fa-calendar-alt stat-icon"></i>
                    <h6 class="stat-title">Regular</h6>
                    <h2 class="stat-value">{{ $regular_requests }}</h2>
                    <p class="stat-desc">Standard priority</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity Row -->
    <div class="row mt-4">
        <!-- Donation Chart -->
        <div class="col-md-8">
            <div class="card chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Donation Trends (Last 6 Months)</h5>
                </div>
                <div class="chart-container">
                    <canvas id="donationTrendsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-md-4">
            <div class="card activity-card">
                <div class="card-header">
                    <h5>Recent Blood Requests</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($recent_requests) && count($recent_requests) > 0)
                        <div class="list-group">
                            @foreach($recent_requests as $request)
                                <div class="recent-item">
                                    <div class="d-flex justify-content-between">
                                        <div class="title">{{ $request->hospital_name }}</div>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                    <div class="info">
                                        <span class="blood-type-pill blood-{{ strtolower(str_replace('+', '-pos', str_replace('-', '-neg', $request->blood_type))) }}">
                                            {{ $request->blood_type }}
                                        </span>
                                        <span>{{ $request->units_needed }} units needed</span>
                                    </div>
                                    <div class="time">
                                        <i class="fa fa-clock"></i> {{ $request->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No recent blood requests</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Blood Types and Recent Donations Row -->
    <div class="row mt-4">
        <!-- Blood Type Distribution -->
        <div class="col-md-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5>Blood Type Distribution</h5>
                </div>
                <div class="chart-container">
                    <canvas id="bloodTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="col-md-6">
            <div class="card activity-card">
                <div class="card-header">
                    <h5>Recent Donations</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($recent_donations) && count($recent_donations) > 0)
                        <div class="list-group">
                            @foreach($recent_donations as $donation)
                                <div class="recent-item">
                                    <div class="d-flex justify-content-between">
                                        <div class="title">{{ $donation->donor->name ?? 'Unknown Donor' }}</div>
                                        <span class="status-badge status-{{ $donation->status }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                            </div>
                                    <div class="info">
                                        @if($donation->bloodRequest)
                                            For: {{ $donation->bloodRequest->hospital_name }}
                                        @endif
                            </div>
                                    <div class="time">
                                        <i class="fa fa-clock"></i> 
                                        @if($donation->donation_date)
                                            {{ \Carbon\Carbon::parse($donation->donation_date)->diffForHumans() }}
                                        @else
                                            {{ $donation->created_at->diffForHumans() }}
                                        @endif
                            </div>
                            </div>
                            @endforeach
                            </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No recent donations</p>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Stats Row -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card stat-card" style="background: linear-gradient(45deg, #8e44ad, #8e44ad99);">
                <div class="card-body">
                    <i class="fa fa-user-shield stat-icon"></i>
                    <h6 class="stat-title">Total Admins</h6>
                    <h2 class="stat-value">{{ $total_admins }}</h2>
                    <p class="stat-desc">System administrators</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card" style="background: linear-gradient(45deg, #34495e, #34495e99);">
                <div class="card-body">
                    <i class="fa fa-tasks stat-icon"></i>
                    <h6 class="stat-title">Total Roles</h6>
                    <h2 class="stat-value">{{ $total_roles }}</h2>
                    <p class="stat-desc">User role definitions</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card" style="background: linear-gradient(45deg, #16a085, #16a08599);">
                <div class="card-body">
                    <i class="fa fa-key stat-icon"></i>
                    <h6 class="stat-title">Permissions</h6>
                    <h2 class="stat-value">{{ $total_permissions }}</h2>
                    <p class="stat-desc">Access control settings</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Donation Trends Chart
        const trendsCtx = document.getElementById('donationTrendsChart').getContext('2d');
        
        // Get data from PHP if available, otherwise use defaults
        const monthLabels = {!! json_encode($monthly_stats['months'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!};
        const donationsData = {!! json_encode($monthly_stats['donations'] ?? [0, 0, 0, 0, 0, 0]) !!};
        const requestsData = {!! json_encode($monthly_stats['requests'] ?? [0, 0, 0, 0, 0, 0]) !!};
        
        new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: 'Donations',
                        data: donationsData,
                        borderColor: 'rgba(46, 204, 113, 1)',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Requests',
                        data: requestsData,
                        borderColor: 'rgba(231, 76, 60, 1)',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Blood Type Chart
        const bloodTypeCtx = document.getElementById('bloodTypeChart').getContext('2d');
        
        // Get blood type data
        const requestsByBloodType = {!! json_encode($requests_by_blood_type ?? []) !!};
        const donorsByBloodType = {!! json_encode($donors_by_blood_type ?? []) !!};
        
        // Get all blood types for labels
        const bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        
        // Prepare data arrays
        const requestValues = bloodTypes.map(type => requestsByBloodType[type] || 0);
        const donorValues = bloodTypes.map(type => donorsByBloodType[type] || 0);
        
        new Chart(bloodTypeCtx, {
        type: 'bar',
        data: {
                labels: bloodTypes,
                datasets: [
                    {
                        label: 'Requests',
                        data: requestValues,
                        backgroundColor: 'rgba(231, 76, 60, 0.7)',
                        borderColor: 'rgba(231, 76, 60, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Donors',
                        data: donorValues,
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 1
                    }
                ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
            scales: {
                y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                }
            }
        }
        });
    });
</script>
@endsection