<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('frontend.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'occupation' => 'nullable|string|max:255',
            'religion' => 'nullable|in:islam,hinduism,christianity,buddhism,other',
            'national_id' => 'nullable|string|max:50',
            'emergency_contact' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:5',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Permanent Address
            'permanent_district' => 'nullable|string|max:100',
            'permanent_sub_district' => 'nullable|string|max:100',
            'permanent_address' => 'nullable|string|max:255',
            // Present Address
            'present_district' => 'nullable|string|max:100',
            'present_sub_district' => 'nullable|string|max:100',
            'present_address' => 'nullable|string|max:255',
            'ssc_exam_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }
            
            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile_pictures', $filename);
            $user->profile_picture = $filename;
        }

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->marital_status = $request->marital_status;
        $user->occupation = $request->occupation;
        $user->religion = $request->religion;
        $user->national_id = $request->national_id;
        $user->emergency_contact = $request->emergency_contact;
        $user->blood_group = $request->blood_group;
        
        // Update permanent address
        $user->permanent_district = $request->permanent_district;
        $user->permanent_sub_district = $request->permanent_sub_district;
        $user->permanent_address = $request->permanent_address;
        
        // Update present address
        $user->present_district = $request->present_district;
        $user->present_sub_district = $request->present_sub_district;
        $user->present_address = $request->present_address;
        
        $user->ssc_exam_year = $request->ssc_exam_year;

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password updated successfully.');
    }
}
