<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\District;
use App\Models\Upazila;
use App\Models\Division;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'dob',
        'gender',
        'national_id',
        'marital_status',
        'occupation',
        'religion',
        'blood_group',
        'total_blood_donation',
        'emergency_contact',
        'permanent_division_id',
        'permanent_district_id',
        'permanent_upazila_id',
        'permanent_address',
        'present_division_id',
        'present_district_id',
        'present_upazila_id',
        'present_address',
        'ssc_exam_year',
        'profile_picture',
        'is_donor',
        'medical_conditions',
        'last_donation_date',
        'status',
        'mode',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dob' => 'date',
        'is_donor' => 'boolean',
        'total_blood_donation' => 'integer',
        'last_donation_date' => 'datetime',
    ];

    /**
     * The default attributes for the model.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'active',
        'mode' => 'donor',
        'is_donor' => false
    ];

    /**
     * Get the preferences associated with the user.
     */
    public function preferences()
    {
        return $this->hasOne(UserPreference::class);
    }

    /**
     * Switch user mode between donor and recipient.
     *
     * @param string $mode
     * @return bool
     */
    public function switchMode(string $mode): bool
    {
        if (!in_array($mode, ['donor', 'recipient'])) {
            return false;
        }

        $this->mode = $mode;
        return $this->save();
    }

    /**
     * Check if user is in donor mode.
     *
     * @return bool
     */
    public function isDonor(): bool
    {
        return $this->mode === 'donor';
    }

    /**
     * Check if user is in recipient mode.
     *
     * @return bool
     */
    public function isRecipient(): bool
    {
        return $this->mode === 'recipient';
    }

    /**
     * Get permission groups.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getpermissionGroups()
    {
        return DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();
    }

    /**
     * Get permissions by group name.
     *
     * @param string $group_name
     * @return \Illuminate\Support\Collection
     */
    public static function getpermissionsByGroupName($group_name)
    {
        return DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
    }

    /**
     * Check if role has permissions.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @param array $permissions
     * @return bool
     */
    public static function roleHasPermissions($role, $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the URL for the user's profile picture.
     *
     * @return string
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset($this->profile_picture);
        }
        return asset('images/avatar.png');
    }

    /**
     * Get the permanent division associated with the user.
     */
    public function permanentDivision()
    {
        return $this->belongsTo(Division::class, 'permanent_division_id');
    }

    /**
     * Get the permanent district associated with the user.
     */
    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district_id');
    }

    /**
     * Get the permanent upazila associated with the user.
     */
    public function permanentUpazila()
    {
        return $this->belongsTo(Upazila::class, 'permanent_upazila_id');
    }

    /**
     * Get the present division associated with the user.
     */
    public function presentDivision()
    {
        return $this->belongsTo(Division::class, 'present_division_id');
    }

    /**
     * Get the present district associated with the user.
     */
    public function presentDistrict()
    {
        return $this->belongsTo(District::class, 'present_district_id');
    }

    /**
     * Get the present upazila associated with the user.
     */
    public function presentUpazila()
    {
        return $this->belongsTo(Upazila::class, 'present_upazila_id');
    }

    /**
     * Get the locations associated with the user.
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the present location associated with the user.
     */
    public function presentLocation()
    {
        return $this->hasOne(Location::class)->where('type', 'present');
    }

    /**
     * Get the permanent location associated with the user.
     */
    public function permanentLocation()
    {
        return $this->hasOne(Location::class)->where('type', 'permanent');
    }

    /**
     * Get the blood donations made by the user.
     */
    public function donations()
    {
        return $this->hasMany(BloodDonation::class, 'donor_id');
    }

    public function getPermanentDistrictAttribute()
    {
        $location = $this->locations()->where('type', 'permanent')->first();
        if ($location && $location->district_id) {
            $district = District::find($location->district_id);
            return $district ? $district->name : null;
        }
        return $location->district ?? null;
    }

    public function getPermanentSubDistrictAttribute()
    {
        $location = $this->locations()->where('type', 'permanent')->first();
        if ($location && $location->upazila_id) {
            $upazila = Upazila::find($location->upazila_id);
            return $upazila ? $upazila->name : null;
        }
        return $location->sub_district ?? null;
    }

    public function getPermanentAddressAttribute()
    {
        $location = $this->locations()->where('type', 'permanent')->first();
        return $location->address ?? null;
    }

    public function getPresentDistrictAttribute()
    {
        $location = $this->locations()->where('type', 'present')->first();
        if ($location && $location->district_id) {
            $district = District::find($location->district_id);
            return $district ? $district->name : null;
        }
        return $location->district ?? null;
    }

    public function getPresentSubDistrictAttribute()
    {
        $location = $this->locations()->where('type', 'present')->first();
        if ($location && $location->upazila_id) {
            $upazila = Upazila::find($location->upazila_id);
            return $upazila ? $upazila->name : null;
        }
        return $location->sub_district ?? null;
    }

    public function getPresentAddressAttribute()
    {
        $location = $this->locations()->where('type', 'present')->first();
        return $location->address ?? null;
    }

    public function getPermanentDivisionAttribute()
    {
        $location = $this->locations()->where('type', 'permanent')->first();
        if ($location && $location->division_id) {
            $division = Division::find($location->division_id);
            return $division ? $division->name : null;
        }
        return null;
    }

    public function getPresentDivisionAttribute()
    {
        $location = $this->locations()->where('type', 'present')->first();
        if ($location && $location->division_id) {
            $division = Division::find($location->division_id);
            return $division ? $division->name : null;
        }
        return null;
    }

    /**
     * Check if the user is available for blood donation
     * 
     * @return bool
     */
    public function isAvailableForDonation()
    {
        // If they haven't donated before, they're available
        if (!$this->last_donation_date) {
            return true;
        }

        // Check if the last donation was more than 4 months ago
        return $this->last_donation_date->addMonths(4)->isPast();
    }

    /**
     * Get the number of days until the donor is eligible for donation again
     * 
     * @return int
     */
    public function getDaysUntilNextDonation()
    {
        if (!$this->last_donation_date || $this->isAvailableForDonation()) {
            return 0;
        }

        $nextEligibleDate = $this->last_donation_date->addMonths(4);
        return now()->diffInDays($nextEligibleDate, false);
    }

    /**
     * Get the next eligible donation date
     * 
     * @return string
     */
    public function getNextEligibleDonationDate()
    {
        if (!$this->last_donation_date) {
            return 'Now';
        }

        $nextEligibleDate = $this->last_donation_date->addMonths(4);
        
        if ($nextEligibleDate->isPast()) {
            return 'Now';
        }
        
        return $nextEligibleDate->format('d M, Y');
    }

    /**
     * Get the donor's experience level based on donation count
     * 
     * @return string
     */
    public function getDonorExperience()
    {
        $donations = $this->total_blood_donation ?? 0;
        
        if ($donations == 0) {
            return 'New';
        } else if ($donations < 5) {
            return 'Beginner';
        } else if ($donations < 10) {
            return 'Intermediate';
        } else if ($donations < 20) {
            return 'Experienced';
        } else {
            return 'Expert';
        }
    }
}
