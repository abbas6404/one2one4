<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'name',
        'bn_name',
        'url',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the division that owns the district.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the upazilas for the district.
     */
    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }

    /**
     * Get users who have this as their permanent district.
     */
    public function permanentResidents()
    {
        return $this->hasMany(User::class, 'permanent_district_id');
    }

    /**
     * Get users who have this as their present district.
     */
    public function presentResidents()
    {
        return $this->hasMany(User::class, 'present_district_id');
    }
}
