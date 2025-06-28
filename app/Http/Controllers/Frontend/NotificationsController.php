<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BloodNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all notifications for the user
        $allNotifications = BloodNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Count unread notifications
        $unreadCount = $allNotifications->where('is_read', false)->count();
        
        // Count donation-related notifications
        $donationCount = $allNotifications->whereIn('type', ['donor_assigned', 'donation_completed', 'eligibility_update'])->count();
        
        return view('frontend.notifications.index', compact('allNotifications', 'unreadCount', 'donationCount'));
    }
    
    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = BloodNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notification marked as read.');
    }
    
    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        BloodNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
            
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
    
    /**
     * Delete a notification.
     */
    public function delete($id)
    {
        $notification = BloodNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $notification->delete();
        
        return redirect()->back()->with('success', 'Notification deleted.');
    }
    
    /**
     * Delete all notifications.
     */
    public function deleteAll()
    {
        BloodNotification::where('user_id', Auth::id())->delete();
        
        return redirect()->back()->with('success', 'All notifications deleted.');
    }
    
    /**
     * Filter notifications by type.
     */
    public function filter(Request $request)
    {
        $user = Auth::user();
        $filter = $request->filter;
        
        $query = BloodNotification::where('user_id', $user->id);
        
        if ($filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($filter === 'donations') {
            $query->whereIn('type', ['donor_assigned', 'donation_completed', 'eligibility_update']);
        }
        
        $filteredNotifications = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'notifications' => view('frontend.notifications.partials.notification-items', [
                'notifications' => $filteredNotifications
            ])->render()
        ]);
    }
} 