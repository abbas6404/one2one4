<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Process the form submission (e.g., save to database or send an email)
        // Example: Save to database
        // Contact::create($request->all());

        // Example: Send an email (requires Mail setup)
        // Mail::to('admin@example.com')->send(new ContactFormMail($request->all()));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}