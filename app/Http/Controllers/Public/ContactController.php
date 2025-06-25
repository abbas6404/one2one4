<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\WebsiteContent;

class ContactController extends Controller
{
    /**
     * Show the Contact Us page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get website content for the contact page
        $data = [
            'title' => WebsiteContent::where('key', 'contact.title')->where('is_active', 1)->value('content'),
            'subtitle' => WebsiteContent::where('key', 'contact.subtitle')->where('is_active', 1)->value('content'),
            'info_title' => WebsiteContent::where('key', 'contact.info.title')->where('is_active', 1)->value('content'),
            'info_tagline' => WebsiteContent::where('key', 'contact.info.tagline')->where('is_active', 1)->value('content'),
            'address' => WebsiteContent::where('key', 'contact.info.address')->where('is_active', 1)->value('content'),
            'phone' => WebsiteContent::where('key', 'contact.info.phone')->where('is_active', 1)->value('content'),
            'email' => WebsiteContent::where('key', 'contact.info.email')->where('is_active', 1)->value('content'),
            'hours' => WebsiteContent::where('key', 'contact.info.hours')->where('is_active', 1)->value('content'),
            'form_title' => WebsiteContent::where('key', 'contact.form.title')->where('is_active', 1)->value('content'),
            'map_iframe' => WebsiteContent::where('key', 'contact.map_iframe')->where('is_active', 1)->value('content'),
        ];

        return view('contact', compact('data'));
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
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Save to database
        Contact::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }
} 