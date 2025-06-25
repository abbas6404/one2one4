<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class

class ProgramController extends Controller
{
    /**
     * Show the Internal Program page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Example: Fetch program details from the database
        // $programs = Program::all(); // Uncomment if you have a Program model
        $programs = []; // Placeholder for now

        return view('internal-program', compact('programs')); // Render the 'internal-program' Blade view
    }
}