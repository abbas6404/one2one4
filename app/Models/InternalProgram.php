<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalProgram extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'blood_group',
        'upazila_id',
        'tshirt_size',
        'payment_method',
        'payment_amount',
        'event_id',
        'trx_id',
        'screenshot',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the screenshot URL attribute.
     *
     * @return string
     */
    public function getScreenshotUrlAttribute()
    {
        if ($this->screenshot) {
            return asset($this->screenshot);
        }
        return null;
    }

    /**
     * Get the upazila that the program belongs to.
     */
    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }
    
    /**
     * Get the district through the upazila relationship.
     */
    public function district()
    {
        return $this->upazila ? $this->upazila->district : null;
    }
    
    /**
     * Get the division through the upazila and district relationships.
     */
    public function division()
    {
        return $this->upazila && $this->upazila->district ? $this->upazila->district->division : null;
    }
    
    /**
     * Get the event that this program registration belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
