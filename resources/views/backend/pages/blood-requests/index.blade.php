@extends('backend.layouts.master')

@section('title')
Blood Requests
@endsection

@section('styles')
    <style>
        .table {
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding: 15px 10px;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        .table td {
            vertical-align: middle !important;
            padding: 15px 10px;
            border-top: 1px solid #eee;
        }
        .table tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Proximity indicators */
        .proximity-badge {
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            margin-left: 0.5rem;
            font-weight: 600;
        }
        
        .proximity-badge.nearby {
            background-color: #2ecc71;
            color: white;
        }
        
        .proximity-badge.close {
            background-color: #3498db;
            color: white;
        }
        
        .proximity-badge.same-division {
            background-color: #f1c40f;
            color: #333;
        }
        
        .donor-nearby {
            background-color: #f8fff8;
            border-left: 3px solid #2ecc71;
        }
        
        /* Blood type badges */
        .blood-type-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            color: white;
            text-align: center;
            min-width: 60px;
        }
        .blood-a-pos { background-color: #e74c3c; }
        .blood-a-neg { background-color: #c0392b; }
        .blood-b-pos { background-color: #3498db; }
        .blood-b-neg { background-color: #2980b9; }
        .blood-ab-pos { background-color: #9b59b6; }
        .blood-ab-neg { background-color: #8e44ad; }
        .blood-o-pos { background-color: #2ecc71; }
        .blood-o-neg { background-color: #27ae60; }
        
        .units-needed {
            color: #666;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        .units-progress {
            height: 6px;
            width: 70px;
            background-color: #eee;
            border-radius: 3px;
            margin-left: 10px;
            overflow: hidden;
        }
        .units-fill {
            height: 100%;
            background-color: #3498db;
        }
        .units-complete {
            background-color: #2ecc71;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        .badge-low {
            background-color: #28a745;
            color: white;
        }
        .badge-medium {
            background-color: #17a2b8;
            color: white;
        }
        .badge-high {
            background-color: #ffc107;
            color: #000;
        }
        .badge-critical {
            background-color: #dc3545;
            color: white;
        }
        .badge-completed {
            background-color: #28a745;
            color: white;
        }
        .badge-cancelled {
            background-color: #dc3545;
            color: white;
        }
        .badge-in-progress {
            background-color: #17a2b8;
            color: white;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-approved {
            background-color: #28a745;
            color: white;
        }
        .badge-rejected {
            background-color: #dc3545;
            color: white;
        }
        .donor-badge {
            background-color: #17a2b8;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            margin: 2px;
            display: inline-block;
            font-size: 12px;
            transition: all 0.2s;
        }
        .donor-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .btn-action {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            margin: 2px;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-view {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }
        .btn-assign {
            background-color: #3498db;
            color: white;
            border: none;
        }
        .btn-approve {
            background-color: #2ecc71;
            color: white;
            border: none;
        }
        .btn-reject {
            background-color: #e74c3c;
            color: white;
            border: none;
        }
        .requester-info {
            display: flex;
            align-items: center;
        }
        .requester-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 12px;
            font-size: 1rem;
        }
        .requester-name {
            color: #333;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .requester-phone {
            color: #666;
            font-size: 0.85rem;
        }
        .hospital-info {
            color: #444;
            font-weight: 500;
        }
        .hospital-location {
            color: #666;
            font-size: 0.85rem;
        }
        .filter-card {
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: none;
        }
        .filter-body {
            padding: 20px;
        }
        .filter-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .filter-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }
        .filter-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .filter-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .reset-btn {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
            margin-left: 10px;
        }
        .reset-btn:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }
        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        .action-button-group {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        .date-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            color: #666;
            font-size: 0.85rem;
        }
        .urgent-date {
            color: #e74c3c;
            font-weight: 500;
        }
        .donor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            max-width: 250px;
        }
        .donor-list-container {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 15px;
            border: 1px solid #eee;
            border-radius: 6px;
        }
        .donor-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: all 0.2s;
        }
        .donor-item:hover {
            background-color: #f8f9fa;
        }
        .donor-item:last-child {
            border-bottom: none;
        }
        .donor-info {
            flex-grow: 1;
        }
        .donor-name {
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 0.95rem;
        }
        .donor-details {
            font-size: 0.85rem;
            color: #666;
        }
        .btn-quick-assign {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-quick-assign:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .donor-blood-type {
            display: inline-block;
            padding: 3px 8px;
            background-color: #f8d7da;
            color: #dc3545;
            border-radius: 12px;
            font-weight: 500;
            font-size: 11px;
            margin-left: 5px;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
        }
        .modal-title {
            font-weight: 600;
            color: #333;
        }
        .modal-body {
            padding: 20px;
        }
        .donor-search {
            margin-bottom: 20px;
            position: relative;
        }
        .donor-search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .donor-search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        .no-donors-message {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
        .loading-spinner {
            text-align: center;
            padding: 30px;
        }
        .assign-success-message {
            padding: 15px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 6px;
            font-weight: 500;
            display: none;
            margin-top: 15px;
            text-align: center;
        }
        
        /* Nearby Hospitals Styles */
        .nearby-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s;
            overflow: hidden;
        }
        
        .nearby-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #3498db;
        }
        
        .nearby-card-header {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .nearby-request-blood {
            font-weight: 700;
            font-size: 20px;
            color: #dc3545;
            background: #f8d7da;
            display: inline-block;
            padding: 2px 12px;
            border-radius: 15px;
        }
        
        .nearby-distance {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #555;
        }
        
        .nearby-distance i {
            margin-right: 4px;
            color: #3498db;
        }
        
        .nearby-card-body {
            padding: 15px;
        }
        
        .nearby-hospital {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
            font-size: 15px;
        }
        
        .nearby-hospital i {
            color: #16a085;
            margin-right: 5px;
        }
        
        .nearby-location {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .nearby-location i {
            margin-right: 5px;
            color: #e74c3c;
        }
        
        .nearby-units {
            display: inline-block;
            padding: 3px 10px;
            background-color: #eee;
            border-radius: 12px;
            font-size: 12px;
            margin-right: 10px;
        }
        
        .nearby-date {
            display: inline-block;
            padding: 3px 10px;
            background-color: #eee;
            border-radius: 12px;
            font-size: 12px;
        }
        
        .nearby-urgent {
            color: #e74c3c;
            font-weight: 500;
        }
        
        .nearby-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        
        .nearby-assign-btn {
            flex: 1;
            display: inline-block;
            padding: 8px 0;
            background-color: #3498db;
            color: white;
            text-align: center;
            border-radius: 4px;
            font-weight: 500;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .nearby-assign-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        
        .nearby-view-btn {
            flex: 1;
            display: inline-block;
            padding: 8px 0;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
            text-align: center;
            border-radius: 4px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .nearby-view-btn:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }
        
        .nearby-requests-list {
            max-height: 500px;
            overflow-y: auto;
        }
        
        .nearby-search {
            margin-bottom: 15px;
        }
        
        .no-nearby {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
        .urgency-icon {
            font-size: 1.2rem;
            margin-right: 5px;
        }
        .urgency-critical {
            color: #e74c3c;
        }
        .card-actions {
            display: flex;
            margin-top: 15px;
            justify-content: flex-end;
            gap: 10px;
        }
        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .table-responsive {
                border: none;
            }
            .action-button-group {
                justify-content: flex-start;
                margin-top: 10px;
            }
            .filter-body .row {
                margin-bottom: 15px;
            }
            .btn-action {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }
        }
        .status-pill {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 15px 5px 35px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .status-pill::before {
            content: '';
            position: absolute;
            left: 15px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: white;
        }
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        .status-approved {
            background-color: #3498db;
            color: white;
        }
        .status-completed {
            background-color: #2ecc71;
            color: white;
        }
        .status-rejected {
            background-color: #e74c3c;
            color: white;
        }
        .status-cancel {
            background-color: #95a5a6;
            color: white;
        }
    </style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Blood Request Management</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Blood Requests</span></li>
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
            <!-- Filters -->
            <div class="card filter-card">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="fa fa-filter mr-2"></i> Filter Blood Requests
                    </h5>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" data-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <div class="collapse show" id="filterCollapse">
                    <div class="card-body filter-body">
                        <form action="{{ route('admin.blood_requests.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="blood_type">Blood Type</label>
                                        <select name="blood_type" id="blood_type" class="form-control">
                                            <option value="">All Blood Types</option>
                                            <option value="A+" {{ request('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ request('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ request('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ request('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ request('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ request('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ request('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ request('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="urgency_level">Urgency</label>
                                        <select name="urgency_level" id="urgency_level" class="form-control">
                                            <option value="">All Urgency Levels</option>
                                            <option value="normal" {{ request('urgency_level') == 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="urgent" {{ request('urgency_level') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">Search</label>
                                        <div class="search-box">
                                            <i class="fa fa-search search-icon"></i>
                                            <input type="text" name="search" id="search" class="form-control search-input" placeholder="Search by name, phone or hospital" value="{{ request('search') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="filter-btn">
                                        <i class="fa fa-filter mr-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('admin.blood_requests.index') }}" class="reset-btn">
                                        <i class="fa fa-refresh mr-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 18%">Requester</th>
                                    <th style="width: 8%">Blood</th>
                                    <th style="width: 12%">Progress</th>
                                    <th style="width: 20%">Hospital & Location</th>
                                    <th style="width: 12%">Date</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bloodRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>
                                        <div class="requester-info">
                                            <div class="requester-avatar">
                                                {{ substr($request->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="requester-name">{{ $request->user->name }}</div>
                                                <div class="requester-phone">
                                                    <i class="fa fa-phone-alt mr-1"></i> {{ $request->user->phone }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="blood-type-badge blood-{{ strtolower(str_replace('+', '-pos', str_replace('-', '-neg', $request->blood_type))) }}">
                                            {{ $request->blood_type }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="units-needed">
                                            {{ $request->donations->count() }}/{{ $request->units_needed }} units
                                            <div class="units-progress ml-2">
                                                <div class="units-fill {{ $request->donations->count() >= $request->units_needed ? 'units-complete' : '' }}" 
                                                    style="width: {{ min(($request->donations->count() / $request->units_needed) * 100, 100) }}%">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="donor-list mt-2">
                                            @foreach($request->donations->take(3) as $donation)
                                                <span class="donor-badge" title="{{ $donation->donor->phone }}">{{ $donation->donor->name }}</span>
                                            @endforeach
                                            @if($request->donations->count() > 3)
                                                <span class="donor-badge" style="background-color: #95a5a6;">+{{ $request->donations->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hospital-info">
                                            <i class="fa fa-hospital mr-1"></i> {{ $request->hospital_name }}
                                        </div>
                                        <div class="hospital-location">
                                            <i class="fa fa-map-marker-alt mr-1"></i> 
                                            {{ $request->division ? $request->division->name : '' }}
                                            {{ $request->district ? ', '.$request->district->name : '' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-badge">
                                            <i class="fa fa-calendar-alt mr-1"></i> {{ $request->created_at->format('M d, Y') }}
                                        </div>
                                        @if($request->needed_date)
                                            <div class="mt-2">
                                                <span class="date-badge urgent-date">
                                                    <i class="fa fa-clock mr-1"></i> Need by: {{ $request->needed_date->format('M d, Y') }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'status-'.$request->status;
                                            $statusText = ucfirst(str_replace('_', ' ', $request->status));
                                            
                                            if($request->urgency_level == 'urgent') {
                                                $urgencyIcon = '<i class="fa fa-exclamation-circle urgency-icon urgency-critical"></i>';
                                            } else {
                                                $urgencyIcon = '';
                                            }
                                        @endphp
                                        <span class="status-pill {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                        @if($request->urgency_level == 'urgent')
                                            <div class="mt-2 text-danger">
                                                <i class="fa fa-exclamation-circle"></i> Urgent
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-button-group">
                                            @if(Auth::guard('admin')->user()->can('blood.request.view'))
                                                <a href="{{ route('admin.blood_requests.show', $request->id) }}" class="btn-action btn-view" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                            
                                            @if(Auth::guard('admin')->user()->can('blood.request.edit') && $request->status == 'pending')
                                                <form action="{{ route('admin.blood_requests.update_status', $request->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn-action btn-approve" title="Approve Request">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(Auth::guard('admin')->user()->can('blood.request.edit') && ($request->status == 'approved' || $request->status == 'pending') && $request->donations->count() < $request->units_needed)
                                                <button class="btn-action btn-assign" data-toggle="modal" data-target="#quickAssignModal" data-requestid="{{ $request->id }}" data-bloodtype="{{ $request->blood_type }}" title="Assign Donor">
                                                    <i class="fa fa-user-plus"></i>
                                                </button>
                                            @endif
                                            
                                            @if(Auth::guard('admin')->user()->can('blood.request.edit') && $request->status == 'pending')
                                                <form action="{{ route('admin.blood_requests.update_status', $request->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <input type="hidden" name="rejection_reason" value="Request rejected by admin">
                                                    <button type="submit" class="btn-action btn-reject" title="Reject Request">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <img src="https://img.icons8.com/color/96/000000/nothing-found.png" style="opacity: 0.5; width: 60px;">
                                        <p class="text-muted mt-3">No blood requests found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bloodRequests->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Assign Donor Modal -->
<div class="modal fade" id="quickAssignModal" tabindex="-1" role="dialog" aria-labelledby="quickAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickAssignModalLabel">Quick Assign Donor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tabs navigation -->
                <ul class="nav nav-tabs mb-3" id="assignTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="direct-assign-tab" data-toggle="tab" href="#direct-assign" role="tab" aria-controls="direct-assign" aria-selected="true">
                            <i class="fa fa-user-plus mr-1"></i> Direct Assign
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="nearby-requests-tab" data-toggle="tab" href="#nearby-requests" role="tab" aria-controls="nearby-requests" aria-selected="false">
                            <i class="fa fa-hospital mr-1"></i> Nearby Hospital Requests
                        </a>
                    </li>
                </ul>
                
                <!-- Tabs content -->
                <div class="tab-content" id="assignTabsContent">
                    <!-- Direct assign tab -->
                    <div class="tab-pane fade show active" id="direct-assign" role="tabpanel" aria-labelledby="direct-assign-tab">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="donor-search">
                            <i class="fa fa-search donor-search-icon"></i>
                            <input type="text" id="donorSearchInput" class="donor-search-input" placeholder="Search by name or phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="donor-list-container" id="donorListContainer">
                            <div class="loading-spinner">
                                <i class="fa fa-spinner fa-spin fa-2x"></i>
                                <p class="mt-3">Searching for eligible donors...</p>
                            </div>
                        </div>
                        <div class="assign-success-message" id="assignSuccessMessage">
                            <i class="fa fa-check-circle mr-2"></i> Donor assigned successfully!
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nearby requests tab -->
                    <div class="tab-pane fade" id="nearby-requests" role="tabpanel" aria-labelledby="nearby-requests-tab">
                        <div class="nearby-hospitals-container">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="nearby-search d-flex">
                                        <input type="text" id="nearbySearchInput" class="form-control" placeholder="Search by hospital name or location">
                                        <button id="refreshNearbyBtn" class="btn btn-outline-primary ml-2">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="nearby-requests-list" id="nearbyRequestsList">
                                <div class="loading-spinner">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                                    <p class="mt-3">Finding nearby hospital requests...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Set up AJAX to always send the CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Global variables for donor assignment
    let currentRequestId = null;
    let currentBloodType = null;
    
    // Make the function available globally for the retry button
    function loadPotentialDonors() {
        const container = $('#donorListContainer');
        container.html('<div class="loading-spinner"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-3">Searching for eligible donors...</p></div>');
        
        $.ajax({
            url: '/admin/api/potential-donors',
            type: 'GET',
            data: {
                blood_type: currentBloodType,
                request_id: currentRequestId
            },
            dataType: 'json',
            success: function(response) {
                container.empty();
                
                if(response.donors.length === 0) {
                    container.html(`
                        <div class="no-donors-message">
                            <img src="https://img.icons8.com/color/96/000000/nothing-found.png" style="opacity: 0.5; width: 60px;">
                            <p class="mt-3">No eligible donors found for blood type ${currentBloodType}</p>
                        </div>
                    `);
                    return;
                }
                
                $.each(response.donors, function(index, donor) {
                    const lastDonation = donor.last_donation_date ? 'Last donated: ' + donor.last_donation_date : 'Never donated';
                    
                    // Format complete address information
                    let locationInfo = '';
                    let addressDetail = '';
                    
                    // Build location display
                    if (donor.present_district || donor.present_division) {
                        const district = donor.present_district || '';
                        const division = donor.present_division || '';
                        locationInfo = `<i class="fa fa-map-marker-alt mr-1"></i> ${district}${division ? ', ' + division : ''}`;
                    }
                    
                    // Build detailed address (only if the data is available)
                    try {
                        if ((donor.present_address !== undefined && donor.present_address) || 
                            (donor.present_upazila !== undefined && donor.present_upazila)) {
                            const upazila = donor.present_upazila || '';
                            const address = donor.present_address || '';
                            
                            if (upazila || address) {
                                addressDetail = `
                                    <div class="donor-address">
                                        <i class="fa fa-map mr-1"></i> 
                                        ${upazila}${address ? (upazila ? ', ' : '') + address : ''}
                                    </div>
                                `;
                            }
                        }
                    } catch (e) {
                        console.error("Error processing address data:", e);
                        // If there's an error, just don't show the address detail
                    }
                    
                    // Determine proximity badge based on location match
                    let proximityBadge = '';
                    if (donor.location_match === 3) {
                        proximityBadge = '<span class="proximity-badge nearby">Very Close</span>';
                    } else if (donor.location_match === 2) {
                        proximityBadge = '<span class="proximity-badge close">Close</span>';
                    } else if (donor.location_match === 1) {
                        proximityBadge = '<span class="proximity-badge same-division">Same Division</span>';
                    }
                    
                    const donorItem = `
                        <div class="donor-item ${donor.location_match > 0 ? 'donor-nearby' : ''}">
                            <div class="donor-info">
                                <div class="donor-name">
                                    ${donor.name} 
                                    <span class="donor-blood-type">${donor.blood_group}</span>
                                    ${proximityBadge}
                                </div>
                                <div class="donor-details">
                                    <div><i class="fa fa-phone-alt mr-1"></i> ${donor.phone}</div>
                                    <div><i class="fa fa-tint mr-1"></i> ${lastDonation}</div>
                                    ${locationInfo ? '<div class="donor-location">' + locationInfo + '</div>' : ''}
                                    ${addressDetail}
                                </div>
                            </div>
                            <button class="btn-quick-assign" data-donor-id="${donor.id}">
                                Assign <i class="fa fa-check ml-1"></i>
                            </button>
                        </div>
                    `;
                    container.append(donorItem);
                });
                
                // Add click event for assign buttons
                $('.btn-quick-assign').on('click', function() {
                    const donorId = $(this).data('donor-id');
                    assignDonor(donorId, $(this));
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching donors:", xhr.responseText);
                let errorMessage = 'Error loading donors. Please try again.';
                let technicalDetails = '';
                
                try {
                    // Try to parse the error response for more details
                    const errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse && errorResponse.message) {
                        errorMessage = errorResponse.message;
                        
                        // Provide simplified message for database column errors
                        if (errorMessage.includes('Column not found') || errorMessage.includes('SQLSTATE')) {
                            errorMessage = 'Unable to load donor location data. Please contact the administrator.';
                            technicalDetails = `
                                <div class="small text-muted mt-2">Technical details: ${errorResponse.message}</div>
                            `;
                        }
                    }
                } catch (e) {
                    // If parsing fails, use the default message
                }
                
                container.html(`
                    <div class="no-donors-message text-danger">
                        <i class="fa fa-exclamation-circle fa-3x mb-3"></i>
                        <p>${errorMessage}</p>
                        <button class="btn btn-outline-danger btn-sm mt-2" onclick="loadPotentialDonors()">
                            Retry
                        </button>
                        ${technicalDetails}
                    </div>
                `);
            }
        });
    }
    
    // Function to assign a donor
    function assignDonor(donorId, buttonElement) {
        buttonElement.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Assigning...');
        
        $.ajax({
            url: '/admin/blood-requests/' + currentRequestId + '/assign-donor',
            type: 'POST',
            data: {
                donor_id: donorId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                buttonElement.closest('.donor-item').fadeOut();
                $('#assignSuccessMessage').fadeIn();
                
                // Update the UI to reflect the new assignment
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(response) {
                buttonElement.prop('disabled', false).html('Assign <i class="fa fa-check ml-1"></i>');
                alert(response.responseJSON?.message || 'Error assigning donor');
            }
        });
    }

    $(document).ready(function() {
            // Function to load nearby hospital requests
    function loadNearbyRequests() {
        const container = $('#nearbyRequestsList');
        container.html('<div class="loading-spinner"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-3">Finding nearby hospital requests...</p></div>');
        
        $.ajax({
            url: '/admin/api/nearby-hospital-requests',
            type: 'GET',
            data: {
                blood_type: currentBloodType,
                current_request_id: currentRequestId
            },
            dataType: 'json',
            success: function(response) {
                container.empty();
                
                if (!response.requests || response.requests.length === 0) {
                    container.html(`
                        <div class="no-nearby">
                            <img src="https://img.icons8.com/color/96/000000/nothing-found.png" style="opacity: 0.5; width: 60px;">
                            <p class="mt-3">No nearby hospital requests found for blood type ${currentBloodType}</p>
                        </div>
                    `);
                    return;
                }
                
                // Sort by distance
                const requests = response.requests.sort((a, b) => a.distance - b.distance);
                
                // Create a container for the cards
                const cardsContainer = $('<div class="row"></div>');
                container.append(cardsContainer);
                
                // Add each request as a card
                $.each(requests, function(index, request) {
                    // Format the address
                    const address = [
                        request.hospital_address,
                        request.district?.name,
                        request.division?.name
                    ].filter(Boolean).join(', ');
                    
                    // Format the needed date
                    const neededDate = request.needed_date ? request.needed_date : 'Not specified';
                    
                    // Format the distance
                    const distance = request.distance ? 
                        `<div class="nearby-distance">
                            <i class="fa fa-location-arrow"></i> ${request.distance.toFixed(1)} km away
                        </div>` : '';
                    
                    // Urgency class
                    const urgencyClass = request.urgency_level === 'urgent' ? 'nearby-urgent' : '';
                    
                    // Create the card
                    const card = `
                        <div class="col-md-6">
                            <div class="nearby-card">
                                <div class="nearby-card-header">
                                    <div class="nearby-request-blood">${request.blood_type}</div>
                                    ${distance}
                                </div>
                                <div class="nearby-card-body">
                                    <div class="nearby-hospital">
                                        <i class="fa fa-hospital"></i> ${request.hospital_name}
                                    </div>
                                    <div class="nearby-location">
                                        <i class="fa fa-map-marker"></i> ${address}
                                    </div>
                                    <div>
                                        <span class="nearby-units">
                                            <i class="fa fa-tint"></i> ${request.donations_count || 0}/${request.units_needed} units
                                        </span>
                                        <span class="nearby-date ${urgencyClass}">
                                            <i class="fa fa-calendar"></i> ${neededDate}
                                        </span>
                                    </div>
                                    <div class="nearby-actions">
                                        <button class="nearby-assign-btn" data-request-id="${request.id}">
                                            <i class="fa fa-bolt"></i> Quick Assign
                                        </button>
                                        <a href="/admin/blood-requests/${request.id}" class="nearby-view-btn">
                                            <i class="fa fa-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    cardsContainer.append(card);
                });
                
                // Add click handler for the quick assign buttons
                $('.nearby-assign-btn').on('click', function() {
                    const requestId = $(this).data('request-id');
                    
                    // Switch to the direct assign tab
                    $('#direct-assign-tab').tab('show');
                    
                    // Update the currentRequestId
                    currentRequestId = requestId;
                    
                    // Update the modal title
                    $('#quickAssignModalLabel').text('Assign Donor for Blood Request #' + requestId + ' (' + currentBloodType + ')');
                    
                    // Reload the donor list
                    loadPotentialDonors();
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading nearby requests:', xhr, status, error);
                container.html(`
                    <div class="no-nearby text-danger">
                        <i class="fa fa-exclamation-circle fa-3x mb-3"></i>
                        <p>Error loading nearby hospital requests. Please try again.</p>
                        <button class="btn btn-outline-danger btn-sm mt-2" id="retry-nearby">
                            Retry
                        </button>
                    </div>
                `);
                
                $('#retry-nearby').on('click', function() {
                    loadNearbyRequests();
                });
            }
        });
    }

        // When the quick assign modal is opened
        $('#quickAssignModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            currentRequestId = button.data('requestid');
            currentBloodType = button.data('bloodtype');
            
            $('#quickAssignModalLabel').text('Assign Donor for Blood Request #' + currentRequestId + ' (' + currentBloodType + ')');
            
            // Clear previous search and results
            $('#donorSearchInput').val('');
        $('#nearbySearchInput').val('');
            $('#assignSuccessMessage').hide();
            
            // Load potential donors
            loadPotentialDonors();
        
        // When the nearby tab is clicked, load the nearby requests
        $('#nearby-requests-tab').on('shown.bs.tab', function() {
            loadNearbyRequests();
        });
        
        // Refresh button for nearby requests
        $('#refreshNearbyBtn').on('click', function() {
            loadNearbyRequests();
        });
        
        // Search functionality for nearby requests
        $('#nearbySearchInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.nearby-card').each(function() {
                const cardText = $(this).text().toLowerCase();
                if (cardText.includes(searchTerm)) {
                    $(this).closest('.col-md-6').show();
                } else {
                    $(this).closest('.col-md-6').hide();
                }
            });
        });
        });

        // Search functionality
        $('#donorSearchInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.donor-item').each(function() {
                const donorText = $(this).text().toLowerCase();
                if(donorText.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Toggle filter collapse
        $('#filterToggle').click(function() {
            $('#filterCollapse').collapse('toggle');
        });
    });
</script>
@endsection 