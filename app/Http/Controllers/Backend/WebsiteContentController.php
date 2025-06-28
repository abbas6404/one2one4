<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class WebsiteContentController extends Controller
{
    public function index(): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.view']);
        
        $contents = WebsiteContent::all();
        return view('backend.pages.website-contents.index', compact('contents'));
    }

    public function create(): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.create']);
        return view('backend.pages.website-contents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.create']);
        
        $request->validate([
            'key' => 'required|string|unique:website_contents,key',
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        WebsiteContent::create($request->all());
        
        session()->flash('success', 'Content created successfully');
        return redirect()->route('admin.website_contents.index');
    }

    public function edit(WebsiteContent $websiteContent): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.edit']);
        return view('backend.pages.website-contents.edit', compact('websiteContent'));
    }

    public function update(Request $request, WebsiteContent $websiteContent): RedirectResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.edit']);
        
        $request->validate([
            'key' => 'required|string|unique:website_contents,key,' . $websiteContent->id,
            'content' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $websiteContent->update($request->all());
        
        session()->flash('success', 'Content updated successfully');
        return redirect()->route('admin.website_contents.index');
    }

    public function destroy(WebsiteContent $websiteContent): RedirectResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.delete']);
        
        $websiteContent->delete();
        
        session()->flash('success', 'Content deleted successfully');
        return redirect()->route('admin.website_contents.index');
    }

    public function webTemplate(): View
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.view']);
        
        return view('backend.pages.web-template.index');
    }

    public function updateWebTemplate(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth('admin')->user(), ['website.content.edit']);
        
        $section = $request->input('section');
        
        // Handle regular content updates
        if ($request->has('content')) {
            foreach ($request->input('content') as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['key' => $key],
                    ['content' => $value, 'is_active' => true]
                );
            }
        }
        
        // Handle JSON content updates
        if ($request->has('json')) {
            foreach ($request->input('json') as $key => $values) {
                WebsiteContent::updateOrCreate(
                    ['key' => $key],
                    ['content' => json_encode($values), 'is_active' => true]
                );
            }
        }
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                // Check if it's a slide image
                if (strpos($key, 'hero.slide') !== false) {
                    // Create directory if it doesn't exist
                    $destinationPath = public_path('images/slides');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    
                    // Generate filename and save
                    $filename = time() . '_slide_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $filename);
                    $storagePath = 'images/slides/' . $filename;
                } 
                // Check if it's a logo
                else if ($key === 'site.logo') {
                    // Create directory if it doesn't exist
                    $destinationPath = public_path('images/logo');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    
                    // Generate filename and save
                    $filename = 'site-logo.' . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $filename);
                    $storagePath = 'images/logo/' . $filename;
                }
                // Check if it's a favicon
                else if ($key === 'site.favicon') {
                    // Create directory if it doesn't exist
                    $destinationPath = public_path('images/logo');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    
                    // Generate filename and save
                    $filename = 'favicon.' . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $filename);
                    $storagePath = 'images/logo/' . $filename;
                }
                else {
                    // For other images
                    $destinationPath = public_path('images');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    
                    $filename = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $filename);
                    $storagePath = 'images/' . $filename;
                }
                
                WebsiteContent::updateOrCreate(
                    ['key' => $key],
                    ['content' => $storagePath, 'is_active' => true]
                );
            }
        }
        
        session()->flash('success', ucfirst($section) . ' settings updated successfully');
        return back();
    }
} 