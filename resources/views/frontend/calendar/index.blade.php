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
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-calendar-alt me-1"></i> View Options
                </button>
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
                            <h5 class="mb-0">March 2024</h5>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
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
                        <div class="calendar-grid">
                            <!-- Calendar cells will be populated dynamically -->
                            <div class="calendar-cell">
                                <div class="date">25</div>
                                <div class="events">
                                    <div class="event bg-primary">Donation</div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="date">26</div>
                            </div>
                            <div class="calendar-cell">
                                <div class="date">27</div>
                            </div>
                            <div class="calendar-cell">
                                <div class="date">28</div>
                                <div class="events">
                                    <div class="event bg-success">Appointment</div>
                                </div>
                            </div>
                            <div class="calendar-cell">
                                <div class="date">29</div>
                            </div>
                            <div class="calendar-cell">
                                <div class="date">30</div>
                            </div>
                            <div class="calendar-cell">
                                <div class="date">31</div>
                            </div>
                            <!-- More cells... -->
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
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="event-dot bg-primary"></div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Blood Donation</h6>
                                    <small class="text-muted">Today, 10:00 AM</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="event-dot bg-success"></div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Follow-up Checkup</h6>
                                    <small class="text-muted">Tomorrow, 2:00 PM</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="event-dot bg-info"></div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Next Donation</h6>
                                    <small class="text-muted">Apr 15, 11:00 AM</small>
                                </div>
                            </div>
                        </div>
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
                        <h3 class="mb-0 text-primary">5</h3>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Next Donation</h6>
                            <small class="text-muted">Days Remaining</small>
                        </div>
                        <h3 class="mb-0 text-success">15</h3>
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
                <form>
                    <div class="mb-3">
                        <label for="appointmentDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="appointmentDate">
                    </div>
                    <div class="mb-3">
                        <label for="appointmentTime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="appointmentTime">
                    </div>
                    <div class="mb-3">
                        <label for="appointmentType" class="form-label">Type</label>
                        <select class="form-select" id="appointmentType">
                            <option>Blood Donation</option>
                            <option>Check-up</option>
                            <option>Consultation</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="appointmentNotes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Schedule</button>
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
}

.calendar-cell .date {
    font-weight: bold;
    margin-bottom: 5px;
}

.calendar-cell .events {
    position: absolute;
    bottom: 5px;
    left: 5px;
    right: 5px;
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
</style>
@endpush
@endsection 