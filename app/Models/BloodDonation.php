<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BloodDonation extends Model
{
    use HasFactory;

    /**
     * Status constants
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'donor_id',
        'blood_request_id',
        'volume',
        'status',
        'rejection_reason',
        'donation_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'donation_date' => 'datetime',
        'volume' => 'decimal:2'
    ];

    /**
     * Get the donor associated with the blood donation.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    /**
     * Get the blood request associated with the donation.
     */
    public function bloodRequest(): BelongsTo
    {
        return $this->belongsTo(BloodRequest::class, 'blood_request_id');
    }

    /**
     * Scope a query to only include completed donations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending donations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
} 