<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the Contact Us page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('contact'); // Render the 'contact' Blade view
    }

    /**
     * Handle contact form submissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Save to database
        Contact::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }
}