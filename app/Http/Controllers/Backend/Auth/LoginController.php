<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Show login form for admin guard
     *
     * @return Renderable
     */
    public function showLoginForm(): Renderable
    {
        return view('backend.auth.login');
    }

    /**
     * Login admin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate Login Data
        $request->validate([
            'email' => 'required|max:50|email',
            'password' => 'required',
        ]);

        // Check if admin exists
        $admin = Admin::where('email', $request->email)->first();
        
        if (!$admin) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'No admin account found with this email address.']);
        }

        // Attempt to log the admin in
        if (Auth::guard('admin')->attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->filled('remember')
        )) {
            // Success
            session()->flash('success', 'Successfully logged in!');
            return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD);
        }

        // Failed login
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    /**
     * Logout admin guard
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    /**
     * Override the guard to use the admin guard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
