<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UsersController;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\DonorController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\ProgramController;
use App\Http\Controllers\Frontend\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication routes
Auth::routes();

/**
 * Public-facing routes
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/donor-list', [DonorController::class, 'index'])->name('donor.list');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/internal-program', [ProgramController::class, 'index'])->name('internal.program');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
// Registration Routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
/**
 * Admin routes
 */

 Route::get('/dashboard', function () {
    return view('user.dashboard'); // Render the user dashboard view
})->name('user.dashboard');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Resource Routes
    Route::resource('roles', RolesController::class);
    Route::resource('admins', AdminsController::class);
    Route::resource('users', UsersController::class);

    // Admin Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

    // Admin Logout Routes
    Route::post('/logout/submit', [LoginController::class, 'logout'])->name('logout.submit');

    // Admin Forget Password Routes
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset/submit', [ForgotPasswordController::class, 'reset'])->name('password.update');
})->middleware('auth:admin');

/**
 * Redirect to Admin Login
 */
Route::get('secure-admin/', [LoginController::class, 'showLoginForm'])->name('secure.admin.login');