<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalProgram;
use Illuminate\Support\Str;

class InternalProgramController extends Controller
{
    /**
     * Show the registration form for internal programs.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('internal-program-registration');
    }

    /**
     * Handle the registration request for internal programs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'blood_group' => 'required|string|max:10',
            'present_address' => 'required|string',
            'tshirt_size' => 'required|string|max:10',
            'payment_method' => 'required|string|max:50',
            'trx_id' => 'nullable|string|max:100',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Set default status to pending
        $validated['status'] = 'pending';
        
        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $image = $request->file('screenshot');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = 'images/internal_programs/';
            $image->move(public_path($path), $filename);
            $validated['screenshot'] = $path . $filename;
        }
        
        // Create the internal program registration
        InternalProgram::create($validated);
        
        // Redirect back with success message
        return redirect()->route('internal-program.registration')
            ->with('success', 'Your registration has been submitted successfully! We will contact you soon.');
    }
} 