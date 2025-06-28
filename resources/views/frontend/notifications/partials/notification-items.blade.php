@if(isset($notifications) && $notifications->count() > 0)
    @foreach($notifications as $notification)
        <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
            <div class="notification-icon {{ $notification->getBgColorClass() }}">
                <i class="{{ $notification->getIconClass() }}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-header">
                    <h6>{{ ucfirst(str_replace('_', ' ', $notification->type)) }}</h6>
                    <span class="notification-time">{{ $notification->getTimeForHumans() }}</span>
                </div>
                <p>{{ $notification->message }}</p>
                <div class="notification-actions">
                    @if($notification->blood_request_id)
                        <a href="{{ route('user.blood-requests.show', $notification->blood_request_id) }}" class="btn-link">View Details</a>
                    @endif
                    
                    @if(!$notification->is_read)
                        <form action="{{ route('user.notifications.mark-read', $notification->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-link">Mark as Read</button>
                        </form>
                    @endif
                    
                    <form action="{{ route('user.notifications.delete', $notification->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-link text-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-bell-slash fa-3x text-muted"></i>
        </div>
        <p class="text-muted">No notifications to display</p>
    </div>
@endif 