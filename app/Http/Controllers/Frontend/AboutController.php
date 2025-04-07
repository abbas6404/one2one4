<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class

class AboutController extends Controller
{
    /**
     * Show the About Us page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('about'); // Render the 'about' Blade view
    }
}