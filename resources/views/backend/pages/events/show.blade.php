@extends('backend.layouts.master')

@section('title', 'Event Details')

@section('styles')
<style>
    .event-image {
        max-width: 100%;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .event-details dt {
        font-weight: 600;
    }
    
    .event-details dd {
        margin-bottom: 1rem;
    }
    
    .event-description {
        margin-top: 2rem;
        white-space: pre-line;
    }
    
    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Event Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.events.index') }}">Events</a></li>
                    <li><span>View Event</span></li>
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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="header-title">Event Details: {{ $event->title }}</h4>
                        <div>
                            @if (Auth::guard('admin')->user()->can('event.edit'))
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            @endif
                            <a href="{{ route('admin.events.index') }}" class="btn btn-info btn-sm ml-2">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            @if ($event->image)
                                <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="event-image mb-4">
                            @else
                                <div class="alert alert-info">No image available for this event.</div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <dl class="row event-details">
                                <dt class="col-sm-4">Title:</dt>
                                <dd class="col-sm-8">{{ $event->title }}</dd>
                                
                                <dt class="col-sm-4">Slug:</dt>
                                <dd class="col-sm-8">{{ $event->slug }}</dd>
                                
                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    @if ($event->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif ($event->status == 'inactive')
                                        <span class="badge badge-warning">Inactive</span>
                                    @else
                                        <span class="badge badge-danger">Cancelled</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-4">Featured:</dt>
                                <dd class="col-sm-8">
                                    @if ($event->is_featured)
                                        <span class="badge badge-info">Featured</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-4">Start Date:</dt>
                                <dd class="col-sm-8">{{ $event->start_date->format('F d, Y - h:i A') }}</dd>
                                
                                <dt class="col-sm-4">End Date:</dt>
                                <dd class="col-sm-8">{{ $event->end_date->format('F d, Y - h:i A') }}</dd>
                                
                                <dt class="col-sm-4">Duration:</dt>
                                <dd class="col-sm-8">
                                    @php
                                        $duration = $event->start_date->diffForHumans($event->end_date, true);
                                    @endphp
                                    {{ $duration }}
                                </dd>
                                
                                <dt class="col-sm-4">Location:</dt>
                                <dd class="col-sm-8">{{ $event->location ?? 'Not specified' }}</dd>
                                
                                <dt class="col-sm-4">Event Status:</dt>
                                <dd class="col-sm-8">
                                    @if ($event->isUpcoming())
                                        <span class="badge badge-primary">Upcoming</span>
                                    @elseif ($event->isOngoing())
                                        <span class="badge badge-success">Ongoing</span>
                                    @elseif ($event->hasEnded())
                                        <span class="badge badge-secondary">Ended</span>
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-4">Created:</dt>
                                <dd class="col-sm-8">{{ $event->created_at->format('F d, Y - h:i A') }}</dd>
                                
                                <dt class="col-sm-4">Last Updated:</dt>
                                <dd class="col-sm-8">{{ $event->updated_at->format('F d, Y - h:i A') }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="event-description">
                                <h5>Event Description</h5>
                                <div class="p-3 bg-light rounded">
                                    {{ $event->description ?? 'No description available for this event.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 