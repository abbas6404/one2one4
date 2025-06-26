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
        'present_address',
        'tshirt_size',
        'payment_method',
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
}
