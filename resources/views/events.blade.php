@extends('layouts.public-layout')

@section('content')
<section class="events-hero-section py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url({{ asset('images/events-bg.jpg') }}) no-repeat center center / cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center text-white">
                <h1 class="fw-bold display-5 mb-3">{{ $pageTitle }}</h1>
                <p class="lead mb-4">{{ $pageDescription }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Events Carousel -->
@if(count($featuredEvents) > 0)
<section class="featured-events py-5">
    <div class="container">
        <div class="section-heading text-center mb-4">
            <h2 class="fw-bold">Featured Events</h2>
            <p class="text-muted">Join our highlighted blood donation events</p>
        </div>
        
        <div id="featuredEventsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($featuredEvents as $index => $event)
                <button type="button" data-bs-target="#featuredEventsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            
            <div class="carousel-inner rounded shadow">
                @foreach($featuredEvents as $index => $event)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="position-relative">
                        @if($event->image)
                        <img src="{{ asset($event->image) }}" class="d-block w-100" alt="{{ $event->title }}" style="max-height: 500px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/default-event.jpg') }}" class="d-block w-100" alt="{{ $event->title }}" style="max-height: 500px; object-fit: cover;">
                        @endif
                        <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.6); border-radius: 5px; padding: 20px;">
                            <h3>{{ $event->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($event->description, 150) }}</p>
                            <div class="d-flex justify-content-center align-items-center text-white mb-3">
                                <i class="far fa-calendar-alt me-2"></i>
                                <span>{{ $event->start_date->format('M d, Y - h:i A') }}</span>
                                <i class="fas fa-map-marker-alt ms-3 me-2"></i>
                                <span>{{ $event->location ?? 'Location TBD' }}</span>
                            </div>
                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-danger">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#featuredEventsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#featuredEventsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endif

<!-- Events Listing -->
<section class="events-listing py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold">All Events</h2>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end">
                    <div class="btn-group" role="group" aria-label="Filter events">
                        <a href="{{ route('events.index', ['filter' => 'upcoming']) }}" class="btn {{ $filter == 'upcoming' ? 'btn-danger' : 'btn-outline-danger' }}">Upcoming</a>
                        <a href="{{ route('events.index', ['filter' => 'past']) }}" class="btn {{ $filter == 'past' ? 'btn-danger' : 'btn-outline-danger' }}">Past</a>
                        <a href="{{ route('events.index', ['filter' => 'all']) }}" class="btn {{ $filter == 'all' ? 'btn-danger' : 'btn-outline-danger' }}">All</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            @forelse($events as $event)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="event-image-container position-relative">
                        @if($event->image)
                        <img src="{{ asset($event->image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/default-event.jpg') }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        
                        @if($event->isUpcoming())
                        <div class="event-status upcoming">Upcoming</div>
                        @elseif($event->isOngoing())
                        <div class="event-status ongoing">Ongoing</div>
                        @else
                        <div class="event-status past">Past</div>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <div class="event-meta my-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="far fa-calendar-alt text-danger me-2"></i>
                                <span>{{ $event->start_date->format('M d, Y - h:i A') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <span>{{ $event->location ?? 'Location TBD' }}</span>
                            </div>
                        </div>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 text-center">
                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline-danger">View Details</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No events found. Please check back later for updates.
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5 text-white text-center" style="background: linear-gradient(45deg, #a51c1c, #e93535);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Ready to Save Lives?</h2>
                <p class="lead mb-4">Every donation counts. Register for an upcoming blood donation event today.</p>
                <a href="{{ route('events.index', ['filter' => 'upcoming']) }}" class="btn btn-outline-light btn-lg">Find an Event</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .hover-lift {
        transition: transform 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
    }
    
    .event-image-container {
        overflow: hidden;
    }
    
    .event-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: white;
    }
    
    .event-status.upcoming {
        background-color: #28a745;
    }
    
    .event-status.ongoing {
        background-color: #007bff;
    }
    
    .event-status.past {
        background-color: #6c757d;
    }
    
    .event-meta {
        font-size: 14px;
        color: #6c757d;
    }
    
    .carousel-item img {
        filter: brightness(0.8);
    }
    
    /* Responsive tweaks */
    @media (max-width: 767.98px) {
        .carousel-caption {
            position: relative;
            background: #343a40 !important;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 15px;
        }
    }
</style>
@endsection 