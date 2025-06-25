<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Show the Gallery page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get gallery header content from WebsiteContent
        $galleryTitle = WebsiteContent::where('key', 'gallery.title')
            ->where('is_active', true)
            ->value('content') ?? 'Photo Gallery';
            
        $galleryDescription = WebsiteContent::where('key', 'gallery.description')
            ->where('is_active', true)
            ->value('content') ?? 'Explore our blood donation events, camps, and community activities through our beautiful photo gallery.';
        
        // Get pagination limit from website content
        $perPage = (int) WebsiteContent::where('key', 'gallery.per_page')
            ->where('is_active', true)
            ->value('content') ?? 9;
            
        // Get all active gallery categories
        $categoriesData = GalleryCategory::where('is_active', true)->get();
        
        // Format categories for the view
        $categories = ['all' => 'All'];
        foreach ($categoriesData as $category) {
            $categories[$category->slug] = $category->name;
        }
        
        // Get paginated gallery items
        $galleryItems = Gallery::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->through(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'description' => $item->description,
                    'image' => $item->image,
                    'date' => $item->created_at->format('Y-m-d'),
                    'category' => $item->category->slug
                ];
            });

        return view('gallery', compact(
            'galleryTitle',
            'galleryDescription',
            'galleryItems', 
            'categories'
        ));
    }
    
    /**
     * Filter gallery by category.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $categorySlug = $request->category;
        
        // Get gallery header content
        $galleryTitle = WebsiteContent::where('key', 'gallery.title')
            ->where('is_active', true)
            ->value('content') ?? 'Photo Gallery';
            
        $galleryDescription = WebsiteContent::where('key', 'gallery.description')
            ->where('is_active', true)
            ->value('content') ?? 'Explore our blood donation events, camps, and community activities through our beautiful photo gallery.';
            
        // Get pagination limit from website content
        $perPage = (int) WebsiteContent::where('key', 'gallery.per_page')
            ->where('is_active', true)
            ->value('content') ?? 9;
        
        // Get all active gallery categories
        $categoriesData = GalleryCategory::where('is_active', true)->get();
        
        // Format categories for the view
        $categories = ['all' => 'All'];
        foreach ($categoriesData as $category) {
            $categories[$category->slug] = $category->name;
        }
        
        // Filter gallery items by category if provided
        $query = Gallery::with('category')->where('is_active', true);
        
        if ($categorySlug && $categorySlug != 'all') {
            $categoryId = GalleryCategory::where('slug', $categorySlug)->value('id');
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
        }
        
        $galleryItems = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->through(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'description' => $item->description,
                    'image' => $item->image,
                    'date' => $item->created_at->format('Y-m-d'),
                    'category' => $item->category->slug
                ];
            });
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.gallery-items', compact('galleryItems', 'categories'))->render(),
                'count' => $galleryItems->total()
            ]);
        }
        
        return view('gallery', compact(
            'galleryTitle',
            'galleryDescription',
            'galleryItems', 
            'categories'
        ));
    }

    /**
     * Show a specific gallery with all its images.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        $gallery = Gallery::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        // Get gallery header content
        $galleryTitle = WebsiteContent::where('key', 'gallery.title')
            ->where('is_active', true)
            ->value('content') ?? 'Photo Gallery';
            
        $galleryDescription = WebsiteContent::where('key', 'gallery.description')
            ->where('is_active', true)
            ->value('content') ?? 'Explore our blood donation events, camps, and community activities through our beautiful photo gallery.';
            
        // Get all active gallery categories for navigation
        $categories = GalleryCategory::where('is_active', true)
            ->get()
            ->pluck('name', 'slug')
            ->toArray();
            
        // Add "All" category at the beginning
        $categories = ['all' => 'All'] + $categories;
        
        // Get related galleries from the same category
        $relatedGalleries = Gallery::with('category')
            ->where('category_id', $gallery->category_id)
            ->where('id', '!=', $gallery->id)
            ->where('is_active', true)
            ->take(3)
            ->get();
            
        // Format all gallery images including the main image
        $allImages = [
            [
                'id' => 0,
                'image' => $gallery->image,
                'is_main' => true
            ]
        ];
        
        foreach ($gallery->images as $index => $image) {
            $allImages[] = [
                'id' => $image->id,
                'image' => $image->image,
                'is_main' => false
            ];
        }
        
        return view('gallery-detail', compact(
            'gallery',
            'allImages',
            'galleryTitle',
            'galleryDescription',
            'categories',
            'relatedGalleries'
        ));
    }
} 