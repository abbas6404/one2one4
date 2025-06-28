@extends('frontend.layouts.frontend')

@section('title', 'Calendar')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Calendar</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
                    <i class="fas fa-plus me-1"></i> New Appointment
                </button>
                <a href="{{ route('user.blood-requests.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-tint me-1"></i> Blood Requests
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Calendar View -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0" id="month-display">{{ $calendarData['month'] }}</h5>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" id="prev-month">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="next-month">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="calendar">
                        <!-- Calendar Header -->
                        <div class="calendar-header">
                            <div class="calendar-day">Sun</div>
                            <div class="calendar-day">Mon</div>
                            <div class="calendar-day">Tue</div>
                            <div class="calendar-day">Wed</div>
                            <div class="calendar-day">Thu</div>
                            <div class="calendar-day">Fri</div>
                            <div class="calendar-day">Sat</div>
                        </div>
                        <!-- Calendar Grid -->
                        <div class="calendar-grid" id="calendar-grid">
                            @foreach($calendarData['days'] as $day)
                                <div class="calendar-cell 
                                    {{ $day['isToday'] ? 'today' : '' }} 
                                    {{ !$day['isCurrentMonth'] ? 'other-month' : '' }}"
                                    data-date="{{ $day['date'] }}">
                                    <div class="date">{{ $day['day'] }}</div>
                                    <div class="events">
                                        @if(isset($events[$day['date']]))
                                            @foreach($events[$day['date']] as $event)
                                                <div class="event {{ $event['color'] }}" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#eventModal"
                                                   data-event-id="{{ $event['id'] }}"
                                                   data-event-title="{{ $event['title'] }}"
                                                   data-event-date="{{ $day['date'] }}"
                                                   data-event-time="{{ $event['time'] }}"
                                                   data-event-type="{{ $event['type'] }}"
                                                   data-event-status="{{ $event['status'] ?? '' }}"
                                                   data-event-url="{{ $event['url'] }}"
                                                   style="cursor: pointer;">
                                                    {{ $event['title'] }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upcoming Events</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($upcomingEvents as $event)
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="event-dot {{ $event['color'] }}"></div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">
                                            <a href="#" class="text-decoration-none event-link"
                                               data-bs-toggle="modal" 
                                               data-bs-target="#eventModal"
                                               data-event-id="{{ $event['id'] }}"
                                               data-event-title="{{ $event['title'] }}"
                                               data-event-date="{{ $event['date'] }}"
                                               data-event-time="{{ $event['time'] }}"
                                               data-event-type="{{ $event['type'] }}"
                                               data-event-status="{{ $event['status'] ?? '' }}"
                                               data-event-url="{{ $event['url'] }}">
                                                {{ $event['title'] }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $event['dateForHumans'] }}, {{ $event['time'] }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item py-4">
                                <div class="text-center">
                                    <div class="text-muted mb-2"><i class="fas fa-calendar fa-2x opacity-25"></i></div>
                                    <p class="text-muted mb-0">No upcoming events</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">Total Appointments</h6>
                            <small class="text-muted">This Month</small>
                        </div>
                        <h3 class="mb-0 text-primary">{{ $stats['totalAppointments'] }}</h3>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Next Donation</h6>
                            <small class="text-muted">Days Remaining</small>
                        </div>
                        <h3 class="mb-0 text-success">{{ $stats['formattedTimeRemaining'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Appointment Modal -->
<div class="modal fade" id="newAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.donation.schedule.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="appointmentDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="appointmentDate" name="donation_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentTime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="appointmentTime" name="donation_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="hospital" class="form-label">Hospital/Location</label>
                        <input type="text" class="form-control" id="hospital" name="hospital" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="appointmentNotes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Event Details Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalTitle">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="event-details">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-day me-2 text-primary"></i>
                            <span class="fw-bold">Date:</span>
                            <span id="eventModalDate" class="ms-2"></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            <span class="fw-bold">Time:</span>
                            <span id="eventModalTime" class="ms-2"></span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            <span class="fw-bold">Type:</span>
                            <span id="eventModalType" class="ms-2"></span>
                        </div>
                        <div class="d-flex align-items-center mb-2" id="eventStatusContainer">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <span class="fw-bold">Status:</span>
                            <span id="eventModalStatus" class="ms-2"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary" id="eventModalViewBtn">View Details</a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.calendar {
    width: 100%;
}

.calendar-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
    margin-bottom: 10px;
}

.calendar-day {
    text-align: center;
    font-weight: bold;
    padding: 5px;
    color: #6c757d;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}

.calendar-cell {
    aspect-ratio: 1;
    border: 1px solid #dee2e6;
    padding: 5px;
    position: relative;
    transition: all 0.2s ease;
    cursor: pointer;
}

.calendar-cell:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.calendar-cell .date {
    font-weight: bold;
    margin-bottom: 5px;
}

.calendar-cell.other-month .date {
    opacity: 0.3;
}

.calendar-cell .events {
    position: absolute;
    bottom: 5px;
    left: 5px;
    right: 5px;
    display: flex;
    flex-direction: column;
}

.event {
    color: white;
    padding: 2px 5px;
    border-radius: 3px;
    font-size: 0.8rem;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-decoration: none;
}

.event:hover {
    opacity: 0.9;
    color: white;
}

.event-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.list-group-item {
    border-left: none;
    border-right: none;
    padding: 1rem;
}

.list-group-item:first-child {
    border-top: none;
}

.list-group-item:last-child {
    border-bottom: none;
}

.calendar-cell.today {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}

.calendar-cell.selected {
    background-color: rgba(var(--bs-primary-rgb), 0.2);
}

.event-link {
    cursor: pointer;
}

/* Event type badges */
.event-badge {
    display: inline-block;
    padding: 0.25em 0.6em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    color: #fff;
}

.event-badge.donation {
    background-color: #dc3545;
}

.event-badge.request {
    background-color: #0d6efd;
}

.event-badge.event {
    background-color: #0dcaf0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
    
    // Calendar navigation
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const monthDisplay = document.getElementById('month-display');
    const calendarGrid = document.getElementById('calendar-grid');
    
    let currentMonth = '{{ $calendarData["monthStart"] }}';
    
    prevMonthBtn.addEventListener('click', function() {
        changeMonth(-1);
    });
    
    nextMonthBtn.addEventListener('click', function() {
        changeMonth(1);
    });
    
    // Event Modal
    const eventModal = document.getElementById('eventModal');
    if (eventModal) {
        eventModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const eventId = button.getAttribute('data-event-id');
            const eventTitle = button.getAttribute('data-event-title');
            const eventDate = button.getAttribute('data-event-date');
            const eventTime = button.getAttribute('data-event-time');
            const eventType = button.getAttribute('data-event-type');
            const eventStatus = button.getAttribute('data-event-status');
            const eventUrl = button.getAttribute('data-event-url');
            
            // Set modal content
            document.getElementById('eventModalTitle').textContent = eventTitle;
            document.getElementById('eventModalDate').textContent = formatDate(eventDate);
            document.getElementById('eventModalTime').textContent = eventTime;
            
            // Format event type
            const eventTypeElem = document.getElementById('eventModalType');
            let typeText = capitalizeFirstLetter(eventType);
            let badgeClass = '';
            
            switch(eventType) {
                case 'donation':
                    badgeClass = 'bg-danger';
                    break;
                case 'request':
                    badgeClass = 'bg-primary';
                    break;
                case 'event':
                    badgeClass = 'bg-info';
                    break;
                default:
                    badgeClass = 'bg-secondary';
            }
            
            eventTypeElem.innerHTML = `<span class="badge ${badgeClass}">${typeText}</span>`;
            
            // Show/hide status based on availability
            const statusContainer = document.getElementById('eventStatusContainer');
            const statusElem = document.getElementById('eventModalStatus');
            
            if (eventStatus && eventStatus !== '') {
                statusContainer.style.display = 'flex';
                statusElem.textContent = capitalizeFirstLetter(eventStatus);
            } else {
                statusContainer.style.display = 'none';
            }
            
            // Set view button URL
            document.getElementById('eventModalViewBtn').href = eventUrl;
        });
    }
    
    function changeMonth(direction) {
        const date = new Date(currentMonth);
        date.setMonth(date.getMonth() + direction);
        
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const newMonth = `${year}-${month}-01`;
        
        fetch(`{{ route('user.calendar.change-month') }}?month=${newMonth}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            currentMonth = data.calendarData.monthStart;
            monthDisplay.textContent = data.monthDisplay;
            
            // Update calendar grid
            calendarGrid.innerHTML = '';
            
            data.calendarData.days.forEach(day => {
                const cell = document.createElement('div');
                cell.className = `calendar-cell ${day.isToday ? 'today' : ''} ${!day.isCurrentMonth ? 'other-month' : ''}`;
                cell.dataset.date = day.date;
                
                const dateDiv = document.createElement('div');
                dateDiv.className = 'date';
                dateDiv.textContent = day.day;
                cell.appendChild(dateDiv);
                
                const eventsDiv = document.createElement('div');
                eventsDiv.className = 'events';
                
                // Add events if any
                if (data.events[day.date]) {
                    data.events[day.date].forEach(event => {
                        const eventDiv = document.createElement('div');
                        eventDiv.className = `event ${event.color}`;
                        eventDiv.textContent = event.title;
                        eventDiv.dataset.bsToggle = 'modal';
                        eventDiv.dataset.bsTarget = '#eventModal';
                        eventDiv.dataset.eventId = event.id;
                        eventDiv.dataset.eventTitle = event.title;
                        eventDiv.dataset.eventDate = day.date;
                        eventDiv.dataset.eventTime = event.time;
                        eventDiv.dataset.eventType = event.type;
                        eventDiv.dataset.eventStatus = event.status || '';
                        eventDiv.dataset.eventUrl = event.url;
                        eventDiv.style.cursor = 'pointer';
                        eventsDiv.appendChild(eventDiv);
                    });
                }
                
                cell.appendChild(eventsDiv);
                calendarGrid.appendChild(cell);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Helper functions
    function formatDate(dateString) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }
    
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>
@endpush
@endsection 