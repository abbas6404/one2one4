<!-- filepath: resources/views/backend/pages/users/show.blade.php -->
@extends('backend.layouts.master')

@section('title')
User Details - Admin Panel
@endsection

@section('styles')
<style>
    .user-profile-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .profile-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    .profile-body {
        padding: 20px;
    }
    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .info-label {
        font-weight: bold;
        color: #555;
    }
    .info-value {
        color: #333;
    }
    .section-title {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        color: #333;
    }
    .blood-group-badge {
        font-size: 16px;
        font-weight: bold;
        padding: 5px 15px;
        border-radius: 20px;
        background-color: #dc3545;
        color: white;
    }
    .donor-badge {
        font-size: 14px;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .donor-badge.yes {
        background-color: #28a745;
        color: white;
    }
    .donor-badge.no {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">User Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
                    <li><span>{{ $user->name }}</span></li>
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
        <div class="col-12 mt-5">
            <div class="card user-profile-card">
                <div class="profile-header d-flex align-items-center">
                    <div class="mr-4">
                        <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('images/avatar.png') }}" alt="{{ $user->name }}" class="profile-image">
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        @if($user->blood_group)
                            <span class="blood-group-badge">{{ $user->blood_group }}</span>
                        @endif
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="section-title">Basic Information</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="info-label">Email</td>
                                            <td class="info-value">{{ $user->email ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Phone</td>
                                            <td class="info-value">{{ $user->phone ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Gender</td>
                                            <td class="info-value">{{ $user->gender ? ucfirst($user->gender) : 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Date of Birth</td>
                                            <td class="info-value">{{ $user->dob ? $user->dob->format('d M, Y') : 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Status</td>
                                            <td class="info-value">
                                                <span class="badge {{ $user->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Created By</td>
                                            <td class="info-value">
                                                @if($user->created_by)
                                                    @php
                                                        $admin = \App\Models\Admin::find($user->created_by);
                                                    @endphp
                                                    {{ $admin ? $admin->name : 'Unknown' }}
                                                @else
                                                    Self Registration
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="section-title">Donation Information</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="info-label">Blood Group</td>
                                            <td class="info-value">{{ $user->blood_group ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Total Donations</td>
                                            <td class="info-value">{{ $user->total_blood_donation ?? '0' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Last Donation Date</td>
                                            <td class="info-value">
                                                {{ $user->last_donation_date ? $user->last_donation_date->format('d M, Y') : 'No donation record' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Availability</td>
                                            <td class="info-value">
                                                @if($user->isAvailableForDonation())
                                                    <span class="badge badge-success">Available for donation</span>
                                                @elseif($user->last_donation_date)
                                                    @php
                                                        $daysRemaining = $user->getDaysUntilNextDonation();
                                                        $monthsRemaining = floor($daysRemaining / 30);
                                                        $remainingDays = $daysRemaining % 30;
                                                        
                                                        $availabilityText = '';
                                                        if ($monthsRemaining > 0) {
                                                            $availabilityText .= $monthsRemaining . ' month' . ($monthsRemaining > 1 ? 's' : '');
                                                        }
                                                        
                                                        if ($remainingDays > 0) {
                                                            if ($availabilityText) {
                                                                $availabilityText .= ' and ';
                                                            }
                                                            $availabilityText .= $remainingDays . ' day' . ($remainingDays > 1 ? 's' : '');
                                                        }
                                                    @endphp
                                                    <span class="badge badge-warning">Available in {{ $availabilityText }}</span>
                                                @else
                                                    <span class="badge badge-secondary">No donation history</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Medical Conditions</td>
                                            <td class="info-value">{{ $user->medical_conditions ?? 'None reported' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="section-title">Address Information</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Address Type</th>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>Upazila</th>
                                            <th>Street Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->locations as $location)
                                            <tr>
                                                <td>{{ ucfirst($location->type) }}</td>
                                                <td>{{ $location->division->name ?? 'N/A' }}</td>
                                                <td>{{ $location->district->name ?? 'N/A' }}</td>
                                                <td>{{ $location->upazila->name ?? 'N/A' }}</td>
                                                <td>{{ $location->address ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                        @if($user->locations->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">No address information available</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">Back to Users</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary mr-2">Edit User</a>
                            <button class="btn btn-danger" 
                                onclick="event.preventDefault(); 
                                if(confirm('Are you sure you want to delete this user?')) {
                                    document.getElementById('delete-user-form').submit();
                                }">
                                Delete User
                            </button>
                            <form id="delete-user-form" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 