@extends('frontend.layouts.frontend')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Notifications</h1>
        <p class="text-muted">Stay updated with your donation activities</p>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Notification Filter & Actions Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <!-- Tabs -->
            <div class="d-flex mb-3">
                <div class="notification-tab active me-4" data-filter="all">
                    <span>All</span>
                    <span class="badge-count">{{ $allNotifications->count() }}</span>
                </div>
                <div class="notification-tab me-4" data-filter="unread">
                    <span>Unread</span>
                    <span class="badge-count">{{ $unreadCount }}</span>
                </div>
                <div class="notification-tab" data-filter="donations">
                    <span>Donations</span>
                    <span class="badge-count">{{ $donationCount }}</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex mb-3">
                <form action="{{ route('user.notifications.mark-all-read') }}" method="POST" class="me-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                    </button>
                </form>
                
                <form action="{{ route('user.notifications.delete-all') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete all notifications?')">
                        <i class="fas fa-trash me-1"></i>Clear All
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="notifications-list" id="notifications-container">
        @include('frontend.notifications.partials.notification-items', ['notifications' => $allNotifications])
    </div>
</div>
@endsection

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
        background: none;
        border: none;
        cursor: pointer;
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter notifications
        const tabs = document.querySelectorAll('.notification-tab');
        const notificationsContainer = document.getElementById('notifications-container');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Get filter type
                const filter = this.dataset.filter;
                
                // Send AJAX request
                fetch(`{{ route('user.notifications.filter') }}?filter=${filter}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    notificationsContainer.innerHTML = data.notifications;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endpush 