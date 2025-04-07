<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // Import the base Controller class
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Redirect to the admin dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAdmin()
    {             
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('user.home');
    }
}