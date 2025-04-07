<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Show the list of donors.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $donors = []; // Placeholder for donor data
        return view('donor-list', compact('donors'));
    }

    /**
     * Show the donor registration page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view('donor-registration'); // Render the 'donor-registration' Blade view
    }

    /**
     * Handle the donor registration form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'blood_group' => 'required|string',
            'last_donation' => 'nullable|date',
        ]);

        // Process the form submission (e.g., save to database)
        // Example: Save to database
        // Donor::create($request->all());

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Registration successful!');
    }
}