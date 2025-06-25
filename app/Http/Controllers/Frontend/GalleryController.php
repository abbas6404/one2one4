<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryCategory;

class GalleryController extends Controller
{
    /**
     * Show the Gallery page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get all gallery categories
        $categories = GalleryCategory::all();
        
        // Get all gallery images with pagination
        $galleries = Gallery::where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
        
        return view('gallery', compact('galleries', 'categories'));
    }
    
    public function filter(Request $request)
    {
        $categoryId = $request->category_id;
        
        // Get all gallery categories
        $categories = GalleryCategory::all();
        
        // Filter gallery images by category if provided
        $query = Gallery::where('status', 1);
        
        if ($categoryId && $categoryId != 'all') {
            $query->where('category_id', $categoryId);
        }
        
        $galleries = $query->orderBy('created_at', 'desc')->paginate(12);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.gallery-items', compact('galleries'))->render(),
                'lastPage' => $galleries->lastPage()
            ]);
        }
        
        return view('gallery', compact('galleries', 'categories'));
    }
}