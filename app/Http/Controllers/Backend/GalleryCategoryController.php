<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the gallery categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.view']);
        
        $categories = GalleryCategory::withCount('galleries')->get();
        return view('backend.pages.gallery.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new gallery category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.create']);
        
        return view('backend.pages.gallery.categories.create');
    }

    /**
     * Store a newly created gallery category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.create']);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        GalleryCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        
        session()->flash('success', 'Gallery category created successfully');
        return redirect()->route('admin.gallery-categories.index');
    }

    /**
     * Display the specified gallery category.
     *
     * @param  \App\Models\GalleryCategory  $gallery_category
     * @return \Illuminate\View\View
     */
    public function show(GalleryCategory $gallery_category)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.view']);
        
        $gallery_category->load(['galleries' => function($query) {
            $query->where('is_active', 1);
        }]);
        
        return view('backend.pages.gallery.categories.show', compact('gallery_category'));
    }

    /**
     * Show the form for editing the specified gallery category.
     *
     * @param  \App\Models\GalleryCategory  $gallery_category
     * @return \Illuminate\View\View
     */
    public function edit(GalleryCategory $gallery_category)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.edit']);
        
        return view('backend.pages.gallery.categories.edit', compact('gallery_category'));
    }

    /**
     * Update the specified gallery category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GalleryCategory  $gallery_category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, GalleryCategory $gallery_category)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.edit']);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name,' . $gallery_category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];
        
        // Update slug only if name changed
        if ($gallery_category->name != $request->name) {
            $data['slug'] = Str::slug($request->name);
        }
        
        $gallery_category->update($data);
        
        session()->flash('success', 'Gallery category updated successfully');
        return redirect()->route('admin.gallery-categories.index');
    }

    /**
     * Remove the specified gallery category from storage.
     *
     * @param  \App\Models\GalleryCategory  $gallery_category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(GalleryCategory $gallery_category)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.category.delete']);
        
        // Check if category has galleries
        $galleryCount = $gallery_category->galleries()->count();
        
        if ($galleryCount > 0) {
            session()->flash('error', 'Cannot delete category with associated galleries. Please delete or reassign all galleries first.');
            return back();
        }
        
        $gallery_category->delete();
        
        session()->flash('success', 'Gallery category deleted successfully');
        return redirect()->route('admin.gallery-categories.index');
    }
} 