<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'slug',
        'description',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
    
    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
} 