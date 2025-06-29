<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
use App\Facades\Seo;
use App\Http\Controllers\SponsorController;

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

// Special login route that bypasses CSRF verification
Route::post('/login-no-csrf', function (Illuminate\Http\Request $request) {
    // Manually authenticate the user
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Regenerate session after login
        $request->session()->regenerate();
        
        // Redirect to dashboard
        return redirect('/user/dashboard');
    }
    
    // Failed login
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Special registration route that bypasses CSRF verification
Route::post('/register-no-csrf', function (Illuminate\Http\Request $request) {
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'phone' => ['required', 'string', 'max:20'],
        'gender' => ['required', 'in:male,female,other'],
        'blood_group' => ['required', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],
        'last_donation' => ['nullable', 'date'],
        'present_division_id' => ['required', 'exists:divisions,id'],
        'present_district_id' => ['required', 'exists:districts,id'],
        'present_upazila_id' => ['required', 'exists:upazilas,id'],
        'present_address' => ['required', 'string', 'max:255'],
    ]);
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }
    
    // Create the user
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'gender' => $request->gender,
        'blood_group' => $request->blood_group,
        'last_donation_date' => $request->last_donation,
        'is_donor' => true,
        'registration_step' => 3, // Mark as completed
        'profile_completed' => true,
    ]);

    // Create present location
    \App\Models\Location::create([
        'user_id' => $user->id,
        'type' => 'present',
        'division_id' => $request->present_division_id,
        'district_id' => $request->present_district_id,
        'upazila_id' => $request->present_upazila_id,
        'address' => $request->present_address,
    ]);

    // Log the user in
    Auth::login($user);

    // Redirect to dashboard
    return redirect('/user/dashboard');
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Special sponsor route that bypasses CSRF verification
Route::post('/sponsor-no-csrf', function (Illuminate\Http\Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'logo' => 'nullable|image|max:2048',
        'url' => 'nullable|url|max:255',
        'payment_method' => 'required|string|max:50',
        'payment_amount' => 'required|string|max:50',
        'payment_transaction_id' => 'nullable|string|max:255',
        'payment_screenshot' => 'required|image|max:2048',
    ]);
    
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }
    
    // Handle payment screenshot upload directly to public folder
    $screenshotPath = null;
    if ($request->hasFile('payment_screenshot')) {
        $screenshotFile = $request->file('payment_screenshot');
        $screenshotName = time() . '_' . Str::random(10) . '.' . $screenshotFile->getClientOriginalExtension();
        $screenshotDirectory = 'images/sponsors/payments';
        
        // Create directory if it doesn't exist
        if (!File::exists(public_path($screenshotDirectory))) {
            File::makeDirectory(public_path($screenshotDirectory), 0755, true);
        }
        
        $screenshotFile->move(public_path($screenshotDirectory), $screenshotName);
        $screenshotPath = $screenshotDirectory . '/' . $screenshotName;
    }

    // Create new sponsor with inactive status
    $sponsor = \App\Models\Sponsor::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'logo' => null,
        'url' => $request->url,
        'payment_method' => $request->payment_method,
        'payment_amount' => $request->payment_amount,
        'payment_transaction_id' => $request->payment_transaction_id,
        'payment_screenshot' => $screenshotPath,
        'payment_status' => 'pending',
        'status' => 'inactive',
        'order' => 0, // Default order
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Thank you for your application! We will review it and contact you soon.',
        'sponsor' => $sponsor
    ]);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Special internal program registration route that bypasses CSRF verification
Route::post('/internal-program-register-no-csrf', function (Illuminate\Http\Request $request) {
    // Validate the request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'blood_group' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'division_id' => 'required|exists:divisions,id',
        'district_id' => 'required|exists:districts,id',
        'upazila_id' => 'required|exists:upazilas,id',
        'tshirt_size' => 'required|string|in:S,M,L,XL,XXL',
        'event_id' => 'nullable|exists:events,id',
        'payment_method' => 'required|string',
        'payment_amount' => 'nullable|string',
        'trx_id' => 'nullable|string|max:255',
        'screenshot' => 'required|image|max:2048',
    ]);
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }
    
    // Process the screenshot upload
    $screenshotPath = null;
    if ($request->hasFile('screenshot')) {
        $screenshotFile = $request->file('screenshot');
        $screenshotName = time() . '_' . Str::random(10) . '.' . $screenshotFile->getClientOriginalExtension();
        $screenshotDirectory = 'images/internal_programs';
        
        // Create directory if it doesn't exist
        if (!File::exists(public_path($screenshotDirectory))) {
            File::makeDirectory(public_path($screenshotDirectory), 0755, true);
        }
        
        $screenshotFile->move(public_path($screenshotDirectory), $screenshotName);
        $screenshotPath = $screenshotDirectory . '/' . $screenshotName;
    }
    
    // Create the registration
    $registration = \App\Models\InternalProgramRegistration::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'blood_group' => $request->blood_group,
        'division_id' => $request->division_id,
        'district_id' => $request->district_id,
        'upazila_id' => $request->upazila_id,
        'tshirt_size' => $request->tshirt_size,
        'event_id' => $request->event_id,
        'payment_method' => $request->payment_method,
        'payment_amount' => $request->payment_amount,
        'transaction_id' => $request->trx_id,
        'payment_screenshot' => $screenshotPath,
        'status' => 'pending',
    ]);
    
    return redirect()->back()->with('success', 'Your registration has been submitted successfully! We will review it and contact you soon.');
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('internal-program.register-no-csrf');

// Special internal program status check route that bypasses CSRF verification
Route::post('/internal-program-check-status-no-csrf', function (Illuminate\Http\Request $request) {
    $validator = Validator::make($request->all(), [
        'phone_number' => 'required|string',
    ]);
    
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }
    
    // Find registration by phone number
    $registration = \App\Models\InternalProgramRegistration::where('phone', $request->phone_number)
        ->with('event')
        ->latest()
        ->first();
    
    if ($registration) {
        return response()->json([
            'success' => true,
            'registration' => $registration
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'No registration found with the provided phone number.'
    ]);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('internal-program.check-status-no-csrf');

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
Route::post('/internal-program-check-status', [App\Http\Controllers\Public\InternalProgramController::class, 'checkStatus'])->name('internal-program.check-status');
Route::get('/contact', [App\Http\Controllers\Public\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\Public\ContactController::class, 'submit'])->name('contact.store');
Route::get('/emergency', [App\Http\Controllers\Public\EmergencyController::class, 'index'])->name('emergency');
Route::post('/sponsor/register', [SponsorController::class, 'register'])->name('sponsor.register');
Route::get('/sponsor/payment-info/{method}', [SponsorController::class, 'getPaymentInfo'])->name('sponsor.payment-info');

// SEO Test Route
Route::get('/seo-test', function() {
    // Set custom SEO data for this page
    Seo::setData([
        'title' => 'SEO Test Page | One2One4',
        'description' => 'This is a test page to demonstrate the SEO middleware functionality.',
        'keywords' => 'seo test, middleware test, one2one4 seo',
        'image' => asset('images/social-share.jpg'),
        'type' => 'article',
    ]);
    
    return view('layouts.public-layout', [
        'content' => '<div class="container py-5"><h1>SEO Test Page</h1><p>This page demonstrates the SEO middleware functionality.</p><p>View the page source to see the generated meta tags.</p></div>'
    ]);
})->middleware('seo')->name('seo.test');

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
    
    // Calendar Routes
    Route::get('/calendar', [App\Http\Controllers\Frontend\CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/change-month', [App\Http\Controllers\Frontend\CalendarController::class, 'changeMonth'])->name('calendar.change-month');
    
    Route::get('/notifications', [App\Http\Controllers\Frontend\NotificationsController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\Frontend\NotificationsController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\Frontend\NotificationsController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Frontend\NotificationsController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications', [App\Http\Controllers\Frontend\NotificationsController::class, 'deleteAll'])->name('notifications.delete-all');
    Route::get('/notifications/filter', [App\Http\Controllers\Frontend\NotificationsController::class, 'filter'])->name('notifications.filter');
    
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

    // Donor search routes
    Route::get('donors/search', 'App\Http\Controllers\Backend\DonorController@search')->name('donors.search');
    Route::get('donors/get', 'App\Http\Controllers\Backend\DonorController@get')->name('donors.get');
    
    // Blood request search routes
    Route::get('blood-requests/search', 'App\Http\Controllers\Backend\BloodRequestSearchController@search')->name('blood_requests.search');
    Route::get('blood-requests/get', 'App\Http\Controllers\Backend\BloodRequestSearchController@get')->name('blood_requests.get');

    // Blood request info route for AJAX
    Route::get('blood-requests/{bloodRequest}/info', 'App\Http\Controllers\Backend\BloodRequestController@getInfo');
});