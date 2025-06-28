<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BloodNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_request_id',
        'user_id',
        'donor_id',
        'type',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the blood request associated with the notification.
     */
    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

    /**
     * Get the donor associated with the notification.
     */
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = Carbon::now();
            $this->save();
        }
        
        return $this;
    }

    /**
     * Get the formatted time for display.
     */
    public function getTimeForHumans()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Get icon class based on notification type.
     */
    public function getIconClass()
    {
        return match($this->type) {
            'donor_assigned' => 'fas fa-user-plus',
            'request_approved' => 'fas fa-check-circle',
            'donation_completed' => 'fas fa-check-circle',
            'request_updated' => 'fas fa-bell',
            'eligibility_update' => 'fas fa-calendar-check',
            default => 'fas fa-bell',
        };
    }

    /**
     * Get background color class based on notification type.
     */
    public function getBgColorClass()
    {
        return match($this->type) {
            'donor_assigned' => 'bg-primary',
            'request_approved' => 'bg-success',
            'donation_completed' => 'bg-success',
            'request_updated' => 'bg-info',
            'eligibility_update' => 'bg-secondary',
            default => 'bg-info',
        };
    }
} 