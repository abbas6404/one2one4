<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'name',
        'bn_name',
        'url',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the district that owns the upazila.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get users who have this as their permanent upazila.
     */
    public function permanentResidents()
    {
        return $this->hasMany(User::class, 'permanent_upazila_id');
    }

    /**
     * Get users who have this as their present upazila.
     */
    public function presentResidents()
    {
        return $this->hasMany(User::class, 'present_upazila_id');
    }
}
