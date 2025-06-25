<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'slug',
        'description', 
        'image', 
        'category_id',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
    
    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }
    
    /**
     * Scope a query to only include active galleries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 