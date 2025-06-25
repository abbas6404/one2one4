<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.view']);

        return view('backend.pages.users.index', [
            'users' => User::orderBy('id', 'desc')->get(),
        ]);
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.create']);

        return view('backend.pages.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['user.create']);

        // Validate and store the user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'nullable|string|min:8|confirmed',
            'blood_group' => 'required|string',
            'gender' => 'required|string',
            'last_donation_date' => 'required|date',
            'total_blood_donation' => 'required|integer|min:0',
            'present_division_id' => 'required|exists:divisions,id',
            'present_district_id' => 'required|exists:districts,id',
            'present_upazila_id' => 'required|exists:upazilas,id',
            'present_address' => 'nullable|string|max:255',
        ]);

        // Generate a random password if not provided
        $password = $request->password ? $request->password : Str::random(10);
        
        // Get the current admin ID
        $adminId = Auth::guard('admin')->id();

        DB::beginTransaction();
        
        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($password),
                'blood_group' => $request->blood_group,
                'gender' => $request->gender,
                'is_donor' => true, // Default to true since we removed the field
                'mode' => 'donor', // Default to donor since we removed the field
                'last_donation_date' => $request->last_donation_date,
                'total_blood_donation' => $request->total_blood_donation,
                'created_by' => $adminId
            ]);
            
            // Create present location
            Location::create([
                'user_id' => $user->id,
                'type' => 'present',
                'division_id' => $request->present_division_id,
                'district_id' => $request->present_district_id,
                'upazila_id' => $request->present_upazila_id,
                'address' => $request->present_address,
            ]);
            
            DB::commit();
            session()->flash('success', 'User has been created.');
            return redirect()->route('admin.users.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating user: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.view']);

        $user = User::findOrFail($id);
        return view('backend.pages.users.show', compact('user'));
    }

    public function edit($id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.edit']);

        $user = User::with(['locations' => function($query) {
            $query->where('type', 'present');
        }])->findOrFail($id);
        
        return view('backend.pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['user.edit']);

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'blood_group' => 'required|string',
            'gender' => 'required|string',
            'last_donation_date' => 'required|date',
            'total_blood_donation' => 'required|integer|min:0',
            'present_division_id' => 'required|exists:divisions,id',
            'present_district_id' => 'required|exists:districts,id',
            'present_upazila_id' => 'required|exists:upazilas,id',
            'present_address' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        
        try {
            // Update the user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'blood_group' => $request->blood_group,
                'gender' => $request->gender,
                'is_donor' => true, // Default to true since we removed the field
                'mode' => 'donor', // Default to donor since we removed the field
                'last_donation_date' => $request->last_donation_date,
                'total_blood_donation' => $request->total_blood_donation,
            ]);
            
            // Update or create present location
            Location::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'type' => 'present'
                ],
                [
                    'division_id' => $request->present_division_id,
                    'district_id' => $request->present_district_id,
                    'upazila_id' => $request->present_upazila_id,
                    'address' => $request->present_address,
                ]
            );
            
            DB::commit();
            session()->flash('success', 'User has been updated.');
            return redirect()->route('admin.users.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error updating user: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['user.delete']);

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User has been deleted.');
        return redirect()->route('admin.users.index');
    }
    
    /**
     * Check if a phone number already exists in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPhone(Request $request)
    {
        $phone = $request->get('phone');
        
        $user = User::where('phone', $phone)->first();
        
        if ($user) {
            return response()->json([
                'exists' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'blood_group' => $user->blood_group,
                    'gender' => $user->gender,
                    'last_donation_date' => $user->last_donation_date,
                    'total_blood_donation' => $user->total_blood_donation,
                ]
            ]);
        }
        
        return response()->json(['exists' => false]);
    }
}