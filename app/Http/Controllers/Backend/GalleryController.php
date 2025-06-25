<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.view']);
        
        $galleries = Gallery::with('category')->latest()->get();
        return view('backend.pages.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new gallery.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.create']);
        
        $categories = GalleryCategory::where('is_active', true)->pluck('name', 'id');
        return view('backend.pages.gallery.create', compact('categories'));
    }

    /**
     * Store a newly created gallery in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.create']);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:gallery_categories,id',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);
        
        // Handle main image upload
        $mainImage = $request->file('main_image');
        $mainImageName = time() . '_' . uniqid() . '.' . $mainImage->getClientOriginalExtension();
        $mainImage->move(public_path('images/gallery'), $mainImageName);
        
        // Create gallery
        $gallery = Gallery::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => 'images/gallery/' . $mainImageName,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        
        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $sortOrder = 1;
            foreach ($request->file('additional_images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $sortOrder . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => 'images/gallery/' . $imageName,
                    'sort_order' => $sortOrder,
                    'is_active' => 1,
                ]);
                
                $sortOrder++;
            }
        }
        
        session()->flash('success', 'Gallery created successfully');
        return redirect()->route('admin.gallery.index');
    }

    /**
     * Display the specified gallery.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\View\View
     */
    public function show(Gallery $gallery)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.view']);
        
        $gallery->load('category', 'images');
        return view('backend.pages.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified gallery.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\View\View
     */
    public function edit(Gallery $gallery)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.edit']);
        
        $gallery->load('images');
        $categories = GalleryCategory::where('is_active', true)->pluck('name', 'id');
        return view('backend.pages.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified gallery in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Gallery $gallery)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.edit']);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:gallery_categories,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];
        
        // Update slug only if title changed
        if ($gallery->title != $request->title) {
            $data['slug'] = Str::slug($request->title);
        }
        
        // Handle main image upload if provided
        if ($request->hasFile('main_image')) {
            // Delete previous image
            if ($gallery->image && File::exists(public_path($gallery->image))) {
                File::delete(public_path($gallery->image));
            }
            
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . uniqid() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images/gallery'), $mainImageName);
            $data['image'] = 'images/gallery/' . $mainImageName;
        }
        
        // Update gallery
        $gallery->update($data);
        
        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $sortOrder = $gallery->images()->max('sort_order') ?? 0;
            foreach ($request->file('additional_images') as $image) {
                $sortOrder++;
                $imageName = time() . '_' . uniqid() . '_' . $sortOrder . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => 'images/gallery/' . $imageName,
                    'sort_order' => $sortOrder,
                    'is_active' => 1,
                ]);
            }
        }
        
        session()->flash('success', 'Gallery updated successfully');
        return redirect()->route('admin.gallery.index');
    }

    /**
     * Remove the specified gallery from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gallery $gallery)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.delete']);
        
        // Delete main image
        if ($gallery->image && File::exists(public_path($gallery->image))) {
            File::delete(public_path($gallery->image));
        }
        
        // Delete all associated images
        foreach ($gallery->images as $image) {
            if (File::exists(public_path($image->image))) {
                File::delete(public_path($image->image));
            }
        }
        
        // Delete gallery and associated images (cascade will handle the relationship)
        $gallery->delete();
        
        session()->flash('success', 'Gallery deleted successfully');
        return redirect()->route('admin.gallery.index');
    }
    
    /**
     * Remove a specific gallery image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.edit']);
        
        $image = GalleryImage::findOrFail($id);
        
        // Delete image file
        if (File::exists(public_path($image->image))) {
            File::delete(public_path($image->image));
        }
        
        // Delete record
        $image->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Update the sort order of gallery images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImagesOrder(Request $request)
    {
        $this->checkAuthorization(auth('admin')->user(), ['gallery.edit']);
        
        $request->validate([
            'images' => 'required|array',
            'images.*.id' => 'required|exists:gallery_images,id',
            'images.*.order' => 'required|integer|min:1',
        ]);
        
        foreach ($request->images as $imageData) {
            GalleryImage::where('id', $imageData['id'])->update(['sort_order' => $imageData['order']]);
        }
        
        return response()->json(['success' => true]);
    }
} 