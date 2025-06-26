<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\ProgramController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\MessageController;
use App\Http\Controllers\Frontend\UserModeController;
use App\Http\Controllers\Public\EmergencyController;
use App\Http\Controllers\DonorListController;
use App\Http\Controllers\Frontend\BloodRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\LocationController;
use App\Http\Controllers\Frontend\MyDonorsController;
use App\Http\Controllers\Public\EventController;

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

// Redirect for legacy /dashboard URL
Route::redirect('/dashboard', '/user/dashboard');

/**
 * Public-facing routes
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\Public\AboutController::class, 'index'])->name('about');
Route::get('/donor-list', [App\Http\Controllers\Public\DonorController::class, 'index'])->name('donors.index');
Route::get('/donor-search', [App\Http\Controllers\Public\DonorController::class, 'search'])->name('donors.search');
Route::get('/get-districts/{divisionId}', [App\Http\Controllers\Public\DonorController::class, 'getDistricts']);
Route::get('/get-upazilas/{districtId}', [App\Http\Controllers\Public\DonorController::class, 'getUpazilas']);
Route::get('/gallery', [App\Http\Controllers\Public\GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/filter/{category?}', [App\Http\Controllers\Public\GalleryController::class, 'filter'])->name('gallery.filter');
Route::get('/gallery/{slug}', [App\Http\Controllers\Public\GalleryController::class, 'show'])->name('gallery.show');
Route::get('/internal-program', [ProgramController::class, 'index'])->name('internal.program');
Route::get('/internal-program-registration', [App\Http\Controllers\Public\InternalProgramController::class, 'showRegistrationForm'])->name('internal-program.registration');
Route::post('/internal-program-registration', [App\Http\Controllers\Public\InternalProgramController::class, 'register'])->name('internal-program.register');
Route::get('/contact', [App\Http\Controllers\Public\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\Public\ContactController::class, 'submit'])->name('contact.store');
Route::get('/emergency', [App\Http\Controllers\Public\EmergencyController::class, 'index'])->name('emergency');

// Event Routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// Registration routes
Route::get('/register', [App\Http\Controllers\Auth\RegistrationStepsController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegistrationStepsController::class, 'register'])->name('register.submit');

// Protected User Routes
Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/dashboard', [App\Http\Controllers\Frontend\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/donation-history', [App\Http\Controllers\Frontend\DonationController::class, 'index'])->name('donation.history');
    
    Route::get('/calendar', function () {
        return view('frontend.calendar.index');
    })->name('calendar');
    
    Route::get('/notifications', function () {
        return view('frontend.notifications.index');
    })->name('notifications');
    
    Route::get('/settings', function () {
        return view('frontend.settings.index');
    })->name('settings');

    Route::get('/my-donors', [App\Http\Controllers\Frontend\MyDonorsController::class, 'index'])->name('my-donors');

    Route::get('/profile', [App\Http\Controllers\Frontend\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/{id}', [App\Http\Controllers\Frontend\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\Frontend\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Frontend\ProfileController::class, 'changePassword'])->name('profile.password');
    
    // User Mode Routes
    Route::get('/mode', [App\Http\Controllers\Frontend\UserModeController::class, 'getMode'])->name('mode.get');
    Route::post('/mode/switch', [App\Http\Controllers\Frontend\UserModeController::class, 'switch'])->name('mode.switch');
    
    // Donor List Routes for authenticated users (actual route name becomes 'user.donors.index' due to prefix)
    Route::get('/donors', [App\Http\Controllers\Frontend\DonorController::class, 'index'])->name('donors.index');
    Route::get('/donors/district/{districtId}/sub-districts', [App\Http\Controllers\Frontend\DonorController::class, 'getSubDistricts'])->name('donors.sub-districts');
    Route::get('/donors/{id}', [App\Http\Controllers\Frontend\DonorController::class, 'show'])->name('donors.show');
    Route::post('/donors/{id}/contact', [App\Http\Controllers\Frontend\DonorController::class, 'contact'])->name('donors.contact');

    // Blood Request Routes
    Route::group(['prefix' => 'blood-requests', 'as' => 'blood-requests.'], function () {
        Route::get('/', [BloodRequestController::class, 'index'])->name('index');
        Route::post('/', [BloodRequestController::class, 'store'])->name('store');
        Route::get('/{bloodRequest}/edit', [BloodRequestController::class, 'edit'])->name('edit');
        Route::put('/{bloodRequest}', [BloodRequestController::class, 'update'])->name('update');
        Route::delete('/{bloodRequest}', [BloodRequestController::class, 'destroy'])->name('destroy');
        Route::get('/{bloodRequest}', [BloodRequestController::class, 'show'])->name('show');
        Route::get('/{bloodRequest}/donors', [BloodRequestController::class, 'viewAssignedDonors'])->name('view-donors');
        Route::post('/{bloodRequest}/assign-donor', [BloodRequestController::class, 'assignDonor'])->name('assign-donor');
        Route::delete('/{bloodRequest}/donors/{donation}', [BloodRequestController::class, 'removeDonor'])->name('remove-donor');
        Route::patch('/{bloodRequest}/update-status', [BloodRequestController::class, 'updateStatus'])->name('update-status');
    });
    
    // Donation Routes
    Route::prefix('donation')->name('donation.')->group(function () {
        Route::get('/', [App\Http\Controllers\Frontend\DonationController::class, 'index'])->name('index');
        Route::get('/{donation}', [App\Http\Controllers\Frontend\DonationController::class, 'show'])->name('show');
        Route::get('/schedule', [App\Http\Controllers\Frontend\DonationController::class, 'schedule'])->name('schedule');
        Route::post('/schedule', [App\Http\Controllers\Frontend\DonationController::class, 'storeSchedule'])->name('schedule.store');
    });
});

// Temporary route to check website content
Route::get('/check-website-content', function () {
    return App\Models\WebsiteContent::all();
});

// Get location dropdown data for address forms
Route::get('/get-divisions', [LocationController::class, 'getDivisions'])->name('get.divisions');
Route::get('/get-districts/{divisionId}', [LocationController::class, 'getDistricts'])->name('get.districts');
Route::get('/get-upazilas/{districtId}', [LocationController::class, 'getUpazilas'])->name('get.upazilas');

// Admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');

    // Users Routes
    Route::resource('users', App\Http\Controllers\Backend\UsersController::class);
    Route::get('/users/check-phone', [App\Http\Controllers\Backend\UsersController::class, 'checkPhone'])->name('users.check-phone');

    // Roles Routes
    Route::resource('roles', App\Http\Controllers\Backend\RolesController::class);
});