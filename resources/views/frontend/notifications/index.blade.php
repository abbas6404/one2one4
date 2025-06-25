@extends('frontend.layouts.frontend')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Notifications</h1>
        <p class="text-muted">Stay updated with your donation activities</p>
    </div>
    
    <!-- Coming Soon Banner -->
    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
        <div class="coming-soon-icon me-3">
            <i class="fas fa-tools"></i>
        </div>
        <div>
            <p class="mb-0">This is a preview of notifications. Full functionality coming soon!</p>
        </div>
    </div>

    <!-- Notification Filter & Actions Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <!-- Tabs -->
            <div class="d-flex mb-3">
                <div class="notification-tab active me-4">
                    <span>All</span>
                    <span class="badge-count">5</span>
                </div>
                <div class="notification-tab me-4">
                    <span>Unread</span>
                    <span class="badge-count">3</span>
                </div>
                <div class="notification-tab">
                    <span>Donations</span>
                    <span class="badge-count">2</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex mb-3">
                <button class="btn btn-outline-primary me-2 btn-sm">
                    <i class="fas fa-check-double me-1"></i>Mark All as Read
                </button>
                <button class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash me-1"></i>Clear All
                </button>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="notifications-list">
        <!-- Notification Item -->
        <div class="notification-item unread">
            <div class="notification-icon bg-primary">
                <i class="fas fa-user-plus"></i>
                                        </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h6>New Donor Assignment</h6>
                    <span class="notification-time">2 minutes ago</span>
                                    </div>
                <p>Mr. Bianka Kirlin has been assigned to your blood request at Ibne Sina Hospital.</p>
                <div class="notification-actions">
                    <a href="#" class="btn-link">View Details</a>
                    <a href="#" class="btn-link">Mark as Read</a>
                                    </div>
                                </div>
                            </div>

        <!-- Notification Item -->
        <div class="notification-item unread">
            <div class="notification-icon bg-success">
                <i class="fas fa-check-circle"></i>
                                        </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h6>Donation Completed</h6>
                    <span class="notification-time">1 hour ago</span>
                                    </div>
                <p>Your blood donation at Dhaka Medical College has been successfully completed. Thank you!</p>
                <div class="notification-actions">
                    <a href="#" class="btn-link">View Certificate</a>
                    <a href="#" class="btn-link">Mark as Read</a>
                                    </div>
                                </div>
                            </div>

        <!-- Notification Item -->
        <div class="notification-item">
            <div class="notification-icon bg-warning">
                <i class="fas fa-clock"></i>
                                        </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h6>Donation Reminder</h6>
                    <span class="notification-time">3 hours ago</span>
                                    </div>
                <p>Reminder: Your scheduled donation at Square Hospital is tomorrow at 10:00 AM.</p>
                <div class="notification-actions">
                    <a href="#" class="btn-link">View Appointment</a>
                                    </div>
                                </div>
                            </div>
        
        <!-- Notification Item -->
        <div class="notification-item">
            <div class="notification-icon bg-info">
                <i class="fas fa-bell"></i>
                        </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h6>New Blood Request</h6>
                    <span class="notification-time">Yesterday</span>
                </div>
                <p>A new A+ blood request has been posted in your area. Check if you can help.</p>
                <div class="notification-actions">
                    <a href="#" class="btn-link">View Request</a>
                </div>
                    </div>
                </div>

        <!-- Notification Item -->
        <div class="notification-item">
            <div class="notification-icon bg-secondary">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h6>Donation Eligibility</h6>
                    <span class="notification-time">3 days ago</span>
                </div>
                <p>You are now eligible to donate blood again. Your last donation was 3 months ago.</p>
                <div class="notification-actions">
                    <a href="#" class="btn-link">Schedule Donation</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Coming Soon Animation */
    .coming-soon-icon {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    /* Notification Tabs */
    .notification-tab {
        display: flex;
        align-items: center;
        color: #5a5c69;
        cursor: pointer;
        padding: 8px 0;
        position: relative;
        font-weight: 500;
    }
    
    .notification-tab.active {
        color: #dc3545;
        font-weight: 600;
    }
    
    .badge-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        font-size: 0.75rem;
        margin-left: 8px;
    }
    
    /* Notification List */
    .notifications-list {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .notification-item {
        display: flex;
        padding: 16px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 16px;
    }
    
    .notification-item.unread {
        border-left: 4px solid #dc3545;
    }
    
    .notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
        color: white;
        margin-right: 16px;
        flex-shrink: 0;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .notification-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1rem;
}

    .notification-time {
        color: #858796;
        font-size: 0.75rem;
}

    .notification-content p {
        color: #5a5c69;
        margin-bottom: 12px;
        font-size: 0.9rem;
}

    .notification-actions {
        display: flex;
        gap: 16px;
    }
    
    .btn-link {
        color: #4e73df;
        font-size: 0.85rem;
        text-decoration: none;
        padding: 0;
}

    .btn-link:hover {
        text-decoration: underline;
    }
    
    /* For mobile devices */
    @media (max-width: 576px) {
        .notification-header {
            flex-direction: column;
            align-items: flex-start;
}

        .notification-time {
            margin-top: 4px;
            margin-bottom: 4px;
        }
        
        .notification-item {
            padding: 12px;
        }
        
        .notification-icon {
            width: 36px;
            height: 36px;
        }
}
</style>
@endpush
@endsection 