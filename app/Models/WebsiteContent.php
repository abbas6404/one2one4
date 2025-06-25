<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteContent extends Model
{
    protected $fillable = [
        'key',
        'content',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
