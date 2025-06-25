<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class BloodRequest extends Model
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
        'user_id',
        'blood_type',
        'units_needed',
        'urgency_level',
        'hospital_name',
        'hospital_division_id',
        'hospital_district_id',
        'hospital_upazila_id',
        'hospital_address',
        'needed_date',
        'additional_notes',
        'status',
        'rejection_reason'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'needed_date' => 'datetime',
        'units_needed' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Dhaka');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Asia/Dhaka');
    }

    public function getNeededDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->setTimezone(config('app.timezone')) : null;
    }

    public function setNeededDateAttribute($value)
    {
        $this->attributes['needed_date'] = $value ? Carbon::parse($value, config('app.timezone'))->setTimezone('UTC') : null;
    }

    /**
     * Get the user who created the blood request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the donations for this blood request.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(BloodDonation::class);
    }

    /**
     * Get donor responses for this blood request.
     * Commented out until DonorResponse model is implemented.
     */
    /* 
    public function responses()
    {
        return $this->hasMany(DonorResponse::class);
    }
    */

    /**
     * Get the division associated with the blood request.
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'hospital_division_id');
    }

    /**
     * Get the district associated with the blood request.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'hospital_district_id');
    }

    /**
     * Get the upazila associated with the blood request.
     */
    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'hospital_upazila_id');
    }

    /**
     * Get the formatted location address.
     */
    public function getFormattedAddressAttribute()
    {
        $address = [];
        
        if ($this->upazila) {
            $address[] = $this->upazila->name;
        }
        
        if ($this->district) {
            $address[] = $this->district->name;
        }
        
        if ($this->division) {
            $address[] = $this->division->name;
        }
        
        if ($this->hospital_address) {
            $address[] = $this->hospital_address;
        }
        
        return implode(', ', $address);
    }
} 