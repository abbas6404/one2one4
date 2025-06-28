<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SponsorController extends Controller
{
    /**
     * Display a listing of sponsors.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.view']);
        
        $query = Sponsor::query();
        
        // Apply filters if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Order by display order and then by name
        $sponsors = $query->orderBy('order', 'asc')
                          ->orderBy('name', 'asc')
                          ->paginate(10);
        
        return view('backend.pages.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new sponsor.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.create']);
        
        return view('backend.pages.sponsors.create');
    }

    /**
     * Store a newly created sponsor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.create']);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
            'order' => 'required|integer|min:0',
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string|in:pending,completed',
            'payment_transaction_id' => 'nullable|string|max:255',
            'payment_screenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->except(['logo', 'payment_screenshot']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('images/sponsors');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move($uploadPath, $logoName);
            $data['logo'] = 'images/sponsors/' . $logoName;
        }
        
        // Handle payment screenshot upload
        if ($request->hasFile('payment_screenshot')) {
            $screenshot = $request->file('payment_screenshot');
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('images/sponsors/payments');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $screenshotName = time() . '_' . uniqid() . '.' . $screenshot->getClientOriginalExtension();
            $screenshot->move($uploadPath, $screenshotName);
            $data['payment_screenshot'] = 'images/sponsors/payments/' . $screenshotName;
        }
        
        Sponsor::create($data);
        
        session()->flash('success', 'Sponsor created successfully');
        return redirect()->route('admin.sponsors.index');
    }

    /**
     * Display the specified sponsor.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\View\View
     */
    public function show(Sponsor $sponsor)
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.view']);
        
        return view('backend.pages.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified sponsor.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\View\View
     */
    public function edit(Sponsor $sponsor)
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.edit']);
        
        return view('backend.pages.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified sponsor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.edit']);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
            'order' => 'required|integer|min:0',
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string|in:pending,completed',
            'payment_transaction_id' => 'nullable|string|max:255',
        ]);
        
        // Remove payment_screenshot from request data to prevent updates
        $data = $request->except(['logo', 'payment_screenshot']);
        
        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            // Delete previous logo if exists
            if ($sponsor->logo && File::exists(public_path($sponsor->logo))) {
                File::delete(public_path($sponsor->logo));
            }
            
            $logo = $request->file('logo');
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('images/sponsors');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move($uploadPath, $logoName);
            $data['logo'] = 'images/sponsors/' . $logoName;
        }
        
        $sponsor->update($data);
        
        session()->flash('success', 'Sponsor updated successfully');
        return redirect()->route('admin.sponsors.index');
    }

    /**
     * Remove the specified sponsor from storage.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Sponsor $sponsor)
    {
        $this->checkAuthorization(auth('admin')->user(), ['sponsor.delete']);
        
        // Delete logo if exists
        if ($sponsor->logo && File::exists(public_path($sponsor->logo))) {
            File::delete(public_path($sponsor->logo));
        }
        
        $sponsor->delete();
        
        session()->flash('success', 'Sponsor deleted successfully');
        return redirect()->route('admin.sponsors.index');
    }
} 