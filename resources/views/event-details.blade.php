@extends('layouts.public-layout')

@section('content')
<div class="event-detail-page">
    <!-- Event Hero Section -->
    <section class="event-hero-section position-relative">
        <div class="event-hero-bg" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{ $event->image ? asset($event->image) : asset('images/default-event.jpg') }}) no-repeat center center / cover; height: 400px;"></div>
        <div class="container position-relative">
            <div class="event-hero-content text-white py-5" style="margin-top: -150px; position: relative; z-index: 10;">
                <div class="row">
                    <div class="col-lg-8">
                        @if($event->isUpcoming())
                        <span class="badge bg-success p-2 mb-3">Upcoming Event</span>
                        @elseif($event->isOngoing())
                        <span class="badge bg-primary p-2 mb-3">Ongoing Event</span>
                        @else
                        <span class="badge bg-secondary p-2 mb-3">Past Event</span>
                        @endif
                        
                        <h1 class="fw-bold display-5 mb-3">{{ $event->title }}</h1>
                        
                        <div class="event-meta d-flex flex-wrap align-items-center mb-4">
                            <div class="me-4 mb-2">
                                <i class="far fa-calendar-alt me-2"></i>
                                <span>{{ $event->start_date->format('F d, Y') }}</span>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="far fa-clock me-2"></i>
                                <span>{{ $event->start_date->format('h:i A') }} - {{ $event->end_date->format('h:i A') }}</span>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span>{{ $event->location ?? 'Location TBD' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0">
                        @if($event->isUpcoming())
                        <a href="#register" class="btn btn-danger btn-lg">Register for this Event</a>
                        @elseif($event->isOngoing())
                        <span class="badge bg-primary p-3 fs-5">This Event is Happening Now!</span>
                        @else
                        <span class="badge bg-secondary p-3 fs-5">This Event has Ended</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Event Content Section -->
    <section class="event-content-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Event Description -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title border-bottom pb-3 mb-3">About This Event</h3>
                            <div class="event-description">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Details -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title border-bottom pb-3 mb-3">Event Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-danger"><i class="far fa-calendar-alt me-2"></i> Date & Time</h5>
                                    <p>{{ $event->start_date->format('F d, Y') }}<br>
                                       {{ $event->start_date->format('h:i A') }} - {{ $event->end_date->format('h:i A') }}</p>
                                    
                                    <h5 class="text-danger mt-4"><i class="fas fa-hourglass-half me-2"></i> Duration</h5>
                                    <p>{{ $event->start_date->diffForHumans($event->end_date, true) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-danger"><i class="fas fa-map-marker-alt me-2"></i> Location</h5>
                                    <p>{{ $event->location ?? 'Location details will be announced soon' }}</p>
                                    
                                    <h5 class="text-danger mt-4"><i class="fas fa-info-circle me-2"></i> Status</h5>
                                    <p>
                                        @if($event->isUpcoming())
                                        <span class="badge bg-success p-2">Upcoming</span>
                                        @elseif($event->isOngoing())
                                        <span class="badge bg-primary p-2">Ongoing</span>
                                        @else
                                        <span class="badge bg-secondary p-2">Past</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Registration Form -->
                    @if($event->isUpcoming())
                    <div class="card shadow-sm" id="register">
                        <div class="card-body">
                            <h3 class="card-title border-bottom pb-3 mb-3">Register for This Event</h3>
                            <form action="#" method="POST">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-select" id="blood_group" name="blood_group" required>
                                            <option value="">Select your blood group</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Additional Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                                    <label class="form-check-label" for="agree_terms">
                                        I agree to the terms and conditions for blood donation
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-danger">Register for This Event</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="col-lg-4">
                    <!-- Event Share -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-3 mb-3">Share This Event</h5>
                            <div class="d-flex justify-content-center social-share">
                                <a href="#" class="btn btn-outline-primary me-2" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), 'facebook-share-dialog', 'width=626,height=436'); return false;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info me-2" onclick="window.open('https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url=' + encodeURIComponent(window.location.href), 'twitter-share-dialog', 'width=626,height=436'); return false;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success me-2" onclick="window.open('https://wa.me/?text={{ urlencode($event->title . ' - ' . route('events.show', $event->slug)) }}', 'whatsapp-share-dialog', 'width=626,height=436'); return false;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary" onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!'); return false;">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Calendar -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h5 class="card-title border-bottom pb-3 mb-3">Add to Calendar</h5>
                            <div class="calendar-box border rounded p-3 mb-3">
                                <div class="calendar-month bg-danger text-white py-1 text-uppercase">
                                    {{ $event->start_date->format('M') }}
                                </div>
                                <div class="calendar-day display-4 fw-bold py-2">
                                    {{ $event->start_date->format('d') }}
                                </div>
                                <div class="calendar-weekday text-muted">
                                    {{ $event->start_date->format('l') }}
                                </div>
                            </div>
                            <div class="calendar-links">
                                <a href="#" class="btn btn-sm btn-outline-secondary mb-2 w-100">
                                    <i class="far fa-calendar-plus me-1"></i> Google Calendar
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="far fa-calendar-alt me-1"></i> iCal / Outlook
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Events -->
                    @if(count($relatedEvents) > 0)
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-3 mb-3">Related Events</h5>
                            @foreach($relatedEvents as $relatedEvent)
                            <div class="related-event mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        @if($relatedEvent->image)
                                        <img src="{{ asset($relatedEvent->image) }}" alt="{{ $relatedEvent->title }}" class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                        <img src="{{ asset('images/default-event.jpg') }}" alt="{{ $relatedEvent->title }}" class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">
                                            <a href="{{ route('events.show', $relatedEvent->slug) }}" class="text-decoration-none text-dark">{{ $relatedEvent->title }}</a>
                                        </h6>
                                        <div class="small text-muted mb-1">
                                            <i class="far fa-calendar-alt me-1"></i> {{ $relatedEvent->start_date->format('M d, Y') }}
                                        </div>
                                        <div class="small text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $relatedEvent->location ?? 'Location TBD' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    .event-hero-bg {
        position: relative;
    }
    
    .event-hero-content {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }
    
    .event-meta {
        font-size: 16px;
    }
    
    .calendar-box {
        max-width: 200px;
        margin: 0 auto;
    }
    
    .calendar-month {
        font-weight: 600;
        border-radius: 4px 4px 0 0;
    }
    
    .calendar-day {
        font-size: 3rem;
    }
    
    .event-description {
        white-space: pre-line;
    }
    
    @media (max-width: 767.98px) {
        .event-hero-content {
            margin-top: -100px;
        }
    }
</style>
@endsection 