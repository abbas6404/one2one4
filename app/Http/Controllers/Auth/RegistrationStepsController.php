<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use App\Models\District;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegistrationStepsController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->only(['showRegistrationForm', 'register']);
    }

    /**
     * Show the registration form for step 1.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        
        $divisions = \App\Models\Division::all();
        return view('auth.registration.step1', compact('divisions'));
    }

    /**
     * Handle the registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'in:male,female,other'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],
            'last_donation' => ['nullable', 'date'],
            'present_division_id' => ['required', 'exists:divisions,id'],
            'present_district_id' => ['required', 'exists:districts,id'],
            'present_upazila_id' => ['required', 'exists:upazilas,id'],
            'present_address' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'blood_group' => $data['blood_group'],
            'last_donation_date' => $data['last_donation'],
            'is_donor' => true,
            'registration_step' => 3, // Mark as completed
            'profile_completed' => true,
        ]);

        // Create present location
        Location::create([
            'user_id' => $user->id,
            'type' => 'present',
            'division_id' => $data['present_division_id'],
            'district_id' => $data['present_district_id'],
            'upazila_id' => $data['present_upazila_id'],
            'address' => $data['present_address'],
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }
} 