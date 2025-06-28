<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Sponsor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'logo',
        'url',
        'phone',
        'email',
        'payment_method',
        'payment_status',
        'payment_amount',
        'payment_screenshot',
        'payment_transaction_id',
        'status',
        'order',
    ];

    /**
     * Scope a query to only include active sponsors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Get active sponsors with cache for homepage.
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveHomepageSponsors($limit = 8)
    {
        return Cache::remember("homepage_sponsors_{$limit}", 60 * 24, function () use ($limit) {
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
            // Clear all possible homepage sponsor caches
            foreach ([4, 5, 6, 8, 10, 12] as $possible_limit) {
                Cache::forget("homepage_sponsors_{$possible_limit}");
            }
        });
        
        static::deleted(function () {
            // Clear all possible homepage sponsor caches
            foreach ([4, 5, 6, 8, 10, 12] as $possible_limit) {
                Cache::forget("homepage_sponsors_{$possible_limit}");
            }
        });
    }
}
