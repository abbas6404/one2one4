<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class

class GalleryController extends Controller
{
    /**
     * Show the Gallery page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Example: Fetch gallery items from the database
        // $galleryItems = Gallery::all(); // Uncomment if you have a Gallery model
        $galleryItems = []; // Placeholder for now

        return view('gallery', compact('galleryItems')); // Render the 'gallery' Blade view
    }
}