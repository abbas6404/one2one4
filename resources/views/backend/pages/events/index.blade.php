@extends('backend.layouts.master')

@section('title', 'Events Management')

@section('styles')
<style>
    .filter-form {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .event-status {
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: 500;
    }
    .event-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    .event-title {
        font-weight: 600;
    }
    .badge-event-status {
        padding: 5px 8px;
    }
    .event-date {
        font-size: 12px;
    }
    .action-buttons .btn {
        margin: 2px;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Events</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Events</span></li>
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
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title">Events List</h4>
                        <div>
                            @if (Auth::guard('admin')->user()->can('event.create'))
                                <a class="btn btn-primary" href="{{ route('admin.events.create') }}">
                                    <i class="fa fa-plus-circle"></i> Create New Event
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Filter Form -->
                    <div class="filter-form">
                        <form action="{{ route('admin.events.index') }}" method="GET" class="row">
                            <div class="col-md-3 mb-2">
                                <select name="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="time_filter" class="form-control">
                                    <option value="">All Time</option>
                                    <option value="upcoming" {{ request('time_filter') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="ongoing" {{ request('time_filter') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="past" {{ request('time_filter') == 'past' ? 'selected' : '' }}>Past</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="featured" class="form-control">
                                    <option value="">Featured Status</option>
                                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="table table-striped table-hover">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Image</th>
                                    <th width="20%">Event Details</th>
                                    <th width="15%">Date & Time</th>
                                    <th width="15%">Location</th>
                                    <th width="15%">Status</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td>
                                        @if ($event->image)
                                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="event-image">
                                        @else
                                            <img src="{{ asset('images/default.png') }}" alt="Default" class="event-image">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="event-title">{{ $event->title }}</div>
                                        @if ($event->event_fee)
                                            <small class="text-muted">Fee: {{ $event->event_fee }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="event-date">
                                            <i class="fa fa-calendar-alt"></i> <strong>Start:</strong> {{ $event->start_date->format('M d, Y') }}<br>
                                            <i class="fa fa-clock"></i> {{ $event->start_date->format('h:i A') }}
                                        </div>
                                        <div class="event-date mt-1">
                                            <i class="fa fa-calendar-check"></i> <strong>End:</strong> {{ $event->end_date->format('M d, Y') }}<br>
                                            <i class="fa fa-clock"></i> {{ $event->end_date->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($event->upazila || $event->district || $event->division)
                                            @if ($event->upazila)
                                                {{ $event->upazila->name ?? '' }}
                                            @endif
                                            
                                            @if ($event->district)
                                                {{ $event->upazila ? ', ' : '' }}{{ $event->district->name ?? '' }}
                                            @endif
                                            
                                            @if ($event->division)
                                                {{ ($event->district || $event->upazila) ? ', ' : '' }}{{ $event->division->name ?? '' }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="mb-2">
                                            @if ($event->status == 'active')
                                                <span class="badge badge-success badge-event-status">Active</span>
                                            @elseif ($event->status == 'inactive')
                                                <span class="badge badge-warning badge-event-status">Inactive</span>
                                            @else
                                                <span class="badge badge-danger badge-event-status">Cancelled</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-2">
                                            @if ($event->is_featured)
                                                <span class="badge badge-info badge-event-status">Featured</span>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            @if ($event->isUpcoming())
                                                <span class="badge badge-primary badge-event-status">Upcoming</span>
                                            @elseif ($event->isOngoing())
                                                <span class="badge badge-success badge-event-status">Ongoing</span>
                                            @elseif ($event->hasEnded())
                                                <span class="badge badge-secondary badge-event-status">Ended</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        @if (Auth::guard('admin')->user()->can('event.view'))
                                            <a class="btn btn-info text-white btn-sm" href="{{ route('admin.events.show', $event->id) }}" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('event.edit'))
                                            <a class="btn btn-success text-white btn-sm" href="{{ route('admin.events.edit', $event->id) }}" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($events->hasPages())
                            <div class="mt-4">
                                {{ $events->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 