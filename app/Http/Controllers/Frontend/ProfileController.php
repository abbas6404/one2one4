<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\Location;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('frontend.profile.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('frontend.profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Debug the request data
        Log::info('Profile update request:', $request->all());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'dob' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'marital_status' => ['nullable', 'string', 'in:single,married,divorced,widowed'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'religion' => ['nullable', 'string', 'max:50'],
            'blood_group' => ['required', 'string', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],
            'permanent_division_id' => ['nullable', 'integer', 'exists:divisions,id'],
            'permanent_district_id' => ['nullable', 'integer', 'exists:districts,id'],
            'permanent_upazila_id' => ['nullable', 'integer', 'exists:upazilas,id'],
            'permanent_address' => ['nullable', 'string', 'max:255'],
            'present_division_id' => ['required', 'integer', 'exists:divisions,id'],
            'present_district_id' => ['required', 'integer', 'exists:districts,id'],
            'present_upazila_id' => ['required', 'integer', 'exists:upazilas,id'],
            'present_address' => ['required', 'string', 'max:255'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'ssc_exam_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_donor' => ['required', 'integer', 'in:0,1'],
            'medical_conditions' => ['nullable', 'string', 'max:500'],
            'total_blood_donation' => ['nullable', 'integer', 'min:0', 'max:100'],
            'last_donation_date' => ['nullable', 'date'],
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                @unlink(public_path($user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile_pictures'), $imageName);
            $validated['profile_picture'] = 'images/profile_pictures/' . $imageName;
        }

        // Handle is_donor field
        $validated['is_donor'] = (int)$request->input('is_donor');

        // Extract location data from validated data
        $permanentLocationData = [
            'division_id' => $validated['permanent_division_id'] ?? null,
            'district_id' => $validated['permanent_district_id'] ?? null,
            'upazila_id' => $validated['permanent_upazila_id'] ?? null,
            'address' => $validated['permanent_address'] ?? null,
        ];
        
        $presentLocationData = [
            'division_id' => $validated['present_division_id'] ?? null,
            'district_id' => $validated['present_district_id'] ?? null,
            'upazila_id' => $validated['present_upazila_id'] ?? null,
            'address' => $validated['present_address'] ?? null,
        ];
        
        // Remove location fields from validated data
        unset(
            $validated['permanent_division_id'],
            $validated['permanent_district_id'],
            $validated['permanent_upazila_id'],
            $validated['permanent_address'],
            $validated['present_division_id'],
            $validated['present_district_id'],
            $validated['present_upazila_id'],
            $validated['present_address']
        );

        // Debug the validated data
        Log::info('Profile update validated data:', $validated);

        try {
            // Update user information - create an array of user data
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'blood_group' => $validated['blood_group'],
                'is_donor' => $validated['is_donor']
            ];
            
            // Add optional fields only if they're set
            if (isset($validated['dob'])) $userData['dob'] = $validated['dob'];
            if (isset($validated['gender'])) $userData['gender'] = $validated['gender'];
            if (isset($validated['national_id'])) $userData['national_id'] = $validated['national_id'];
            if (isset($validated['marital_status'])) $userData['marital_status'] = $validated['marital_status'];
            if (isset($validated['occupation'])) $userData['occupation'] = $validated['occupation'];
            if (isset($validated['religion'])) $userData['religion'] = $validated['religion'];
            if (isset($validated['emergency_contact'])) $userData['emergency_contact'] = $validated['emergency_contact'];
            if (isset($validated['ssc_exam_year'])) $userData['ssc_exam_year'] = $validated['ssc_exam_year'];
            if (isset($validated['medical_conditions'])) $userData['medical_conditions'] = $validated['medical_conditions'];
            if (isset($validated['profile_picture'])) $userData['profile_picture'] = $validated['profile_picture'];
            if (isset($validated['total_blood_donation'])) $userData['total_blood_donation'] = $validated['total_blood_donation'];
            if (isset($validated['last_donation_date'])) $userData['last_donation_date'] = $validated['last_donation_date'];
            
            // Update the user
            User::where('id', $user->id)->update($userData);
            
            // Update or create permanent location if address is provided
            if (!empty($permanentLocationData['address'])) {
                Location::updateOrCreate(
                    ['user_id' => $user->id, 'type' => 'permanent'],
                    $permanentLocationData
                );
            }
            
            // Update or create present location
            Location::updateOrCreate(
                ['user_id' => $user->id, 'type' => 'present'],
                $presentLocationData
            );
            
            return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Profile update error:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Auth::user();
        User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('user.profile')->with('success', 'Password changed successfully!');
    }
} 