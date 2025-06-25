<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'content',
        'avatar',
        'blood_group',
        'type',
        'location',
        'status',
        'order'
    ];

    /**
     * Scope a query to only include active testimonials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Get active testimonials with cache for homepage.
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveHomepageTestimonials($limit = 6)
    {
        return Cache::remember("homepage_testimonials_{$limit}", 60 * 24, function () use ($limit) {
            return self::active()
                ->orderBy('order', 'asc')
                ->limit($limit)
                ->get();
        });
    }
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function () {
            // Clear all possible homepage testimonial caches
            foreach ([2, 3, 4, 5, 6, 8, 10, 12] as $possible_limit) {
                Cache::forget("homepage_testimonials_{$possible_limit}");
            }
        });
        
        static::deleted(function () {
            // Clear all possible homepage testimonial caches
            foreach ([2, 3, 4, 5, 6, 8, 10, 12] as $possible_limit) {
                Cache::forget("homepage_testimonials_{$possible_limit}");
            }
        });
    }
}
