<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'content',
        'read_at',
        'deleted_by_sender',
        'deleted_by_recipient'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'deleted_by_sender' => 'boolean',
        'deleted_by_recipient' => 'boolean'
    ];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the recipient of the message.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to only include messages for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->where('deleted_by_sender', false)
              ->orWhere(function($q) use ($userId) {
                  $q->where('recipient_id', $userId)
                    ->where('deleted_by_recipient', false);
              });
        });
    }
} 