<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.view']);
        
        $testimonials = Testimonial::orderBy('order', 'asc')->get();
        return view('backend.pages.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.create']);
        
        $bloodGroups = [
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
            'O+' => 'O+',
            'O-' => 'O-',
        ];
        
        $types = [
            'donor' => 'Donor',
            'recipient' => 'Recipient',
            'volunteer' => 'Volunteer',
            'other' => 'Other'
        ];
        
        return view('backend.pages.testimonials.create', compact('bloodGroups', 'types'));
    }

    /**
     * Store a newly created testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.create']);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blood_group' => 'nullable|string|max:10',
            'type' => 'required|string|in:donor,recipient,volunteer,other',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'order' => 'required|integer|min:1',
        ]);
        
        $data = $request->except('avatar');
        
        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images/testimonials'), $avatarName);
            $data['avatar'] = 'images/testimonials/' . $avatarName;
        }
        
        Testimonial::create($data);
        
        session()->flash('success', 'Testimonial created successfully');
        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Display the specified testimonial.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\View\View
     */
    public function show(Testimonial $testimonial)
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.view']);
        
        return view('backend.pages.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\View\View
     */
    public function edit(Testimonial $testimonial)
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.edit']);
        
        $bloodGroups = [
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
            'O+' => 'O+',
            'O-' => 'O-',
        ];
        
        $types = [
            'donor' => 'Donor',
            'recipient' => 'Recipient',
            'volunteer' => 'Volunteer',
            'other' => 'Other'
        ];
        
        return view('backend.pages.testimonials.edit', compact('testimonial', 'bloodGroups', 'types'));
    }

    /**
     * Update the specified testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.edit']);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blood_group' => 'nullable|string|max:10',
            'type' => 'required|string|in:donor,recipient,volunteer,other',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'order' => 'required|integer|min:1',
        ]);
        
        $data = $request->except('avatar');
        
        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            // Delete previous avatar if exists
            if ($testimonial->avatar && File::exists(public_path($testimonial->avatar))) {
                File::delete(public_path($testimonial->avatar));
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images/testimonials'), $avatarName);
            $data['avatar'] = 'images/testimonials/' . $avatarName;
        }
        
        $testimonial->update($data);
        
        session()->flash('success', 'Testimonial updated successfully');
        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Remove the specified testimonial from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        $this->checkAuthorization(auth('admin')->user(), ['testimonial.delete']);
        
        // Delete avatar if exists
        if ($testimonial->avatar && File::exists(public_path($testimonial->avatar))) {
            File::delete(public_path($testimonial->avatar));
        }
        
        $testimonial->delete();
        
        session()->flash('success', 'Testimonial deleted successfully');
        return redirect()->route('admin.testimonials.index');
    }
} 