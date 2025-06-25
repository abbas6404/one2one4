<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'slug',
        'description', 
        'location',
        'start_date',
        'end_date',
        'image', 
        'status',
        'is_featured'
    ];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
    ];
    
    /**
     * Scope a query to only include active events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Scope a query to only include upcoming events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->orderBy('start_date', 'asc');
    }
    
    /**
     * Scope a query to only include past events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now())->orderBy('end_date', 'desc');
    }
    
    /**
     * Scope a query to only include featured events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * Check if the event is upcoming.
     *
     * @return bool
     */
    public function isUpcoming()
    {
        return $this->start_date->gt(now());
    }
    
    /**
     * Check if the event is ongoing.
     *
     * @return bool
     */
    public function isOngoing()
    {
        return $this->start_date->lte(now()) && $this->end_date->gte(now());
    }
    
    /**
     * Check if the event has ended.
     *
     * @return bool
     */
    public function hasEnded()
    {
        return $this->end_date->lt(now());
    }
} 