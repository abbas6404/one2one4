<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserPreference;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('authorized.dashboard.settings', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        $user->update($request->only(['first_name', 'last_name', 'email', 'phone']));

        return redirect()->back()->with('success', 'Account information updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'email_notifications' => 'array',
            'sms_notifications' => 'array',
        ]);

        $user = Auth::user();
        
        // Update or create user preferences
        $preferences = $user->preferences ?? new UserPreference();
        $preferences->email_notifications = $request->email_notifications ?? [];
        $preferences->sms_notifications = $request->sms_notifications ?? [];
        
        $user->preferences()->save($preferences);

        return redirect()->back()->with('success', 'Notification preferences updated successfully.');
    }

    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'profile_visibility' => 'required|in:public,private,donors',
            'show_donation_history' => 'boolean',
            'allow_contact' => 'boolean',
        ]);

        $user = Auth::user();
        $preferences = $user->preferences ?? new UserPreference();
        
        $preferences->profile_visibility = $request->profile_visibility;
        $preferences->show_donation_history = $request->show_donation_history;
        $preferences->allow_contact = $request->allow_contact;
        
        $user->preferences()->save($preferences);

        return redirect()->back()->with('success', 'Privacy settings updated successfully.');
    }

    public function updatePreferences(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,es,fr',
            'timezone' => 'required|string',
            'distance_unit' => 'required|string|in:km,mi',
        ]);

        $user = Auth::user();
        $preferences = $user->preferences ?? new UserPreference();
        
        $preferences->language = $request->language;
        $preferences->timezone = $request->timezone;
        $preferences->distance_unit = $request->distance_unit;
        
        $user->preferences()->save($preferences);

        return redirect()->back()->with('success', 'App preferences updated successfully.');
    }
} 