<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\LocationController;
use App\Http\Controllers\Backend\WebsiteContentController;
use App\Http\Controllers\Backend\BloodRequestController;
use App\Http\Controllers\Backend\BloodDonationController;
use App\Http\Controllers\Backend\GalleryCategoryController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\SponsorController;
use App\Http\Controllers\Backend\MilestoneController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\InternalProgramController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ContactController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

Route::prefix('admin')->group(function () {
// Admin Auth Routes (No auth required)
    Route::middleware('guest:admin')->group(function () {
        // Login Routes
        Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
        
        // Password Reset Routes
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
        Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
        Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');
});

// Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Admin Logout
        Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
        
        // Admin Profile Routes
        Route::get('profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('admin.profile.change-password');
        Route::post('profile/change-password', [ProfileController::class, 'changePassword']);

    // Admin Resource Routes
        Route::resource('roles', RolesController::class)->names([
            'index' => 'admin.roles.index',
            'create' => 'admin.roles.create',
            'store' => 'admin.roles.store',
            'edit' => 'admin.roles.edit',
            'update' => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy',
        ]);
        
        Route::resource('admins', AdminsController::class)->names([
            'index' => 'admin.admins.index',
            'create' => 'admin.admins.create',
            'store' => 'admin.admins.store',
            'edit' => 'admin.admins.edit',
            'update' => 'admin.admins.update',
            'destroy' => 'admin.admins.destroy',
        ]);
        
        Route::resource('users', UsersController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);

        // Location Management
        Route::get('locations', [LocationController::class, 'hierarchy'])->name('admin.locations.index');
        
        // Division Routes
        Route::prefix('locations')->group(function () {
            Route::get('/divisions', [LocationController::class, 'divisions'])->name('admin.locations.divisions');
            Route::get('/divisions/create', [LocationController::class, 'createDivision'])->name('admin.locations.divisions.create');
            Route::post('/divisions', [LocationController::class, 'storeDivision'])->name('admin.locations.divisions.store');
            Route::get('/divisions/{division}/edit', [LocationController::class, 'editDivision'])->name('admin.locations.divisions.edit');
            Route::put('/divisions/{division}', [LocationController::class, 'updateDivision'])->name('admin.locations.divisions.update');
            Route::delete('/divisions/{division}', [LocationController::class, 'destroyDivision'])->name('admin.locations.divisions.destroy');
            
            // District Routes
            Route::get('/districts', [LocationController::class, 'districts'])->name('admin.locations.districts');
            Route::get('/districts/create', [LocationController::class, 'createDistrict'])->name('admin.locations.districts.create');
            Route::post('/districts', [LocationController::class, 'storeDistrict'])->name('admin.locations.districts.store');
            Route::get('/districts/{district}/edit', [LocationController::class, 'editDistrict'])->name('admin.locations.districts.edit');
            Route::put('/districts/{district}', [LocationController::class, 'updateDistrict'])->name('admin.locations.districts.update');
            Route::delete('/districts/{district}', [LocationController::class, 'destroyDistrict'])->name('admin.locations.districts.destroy');
            
            // Upazila Routes
            Route::get('/upazilas', [LocationController::class, 'upazilas'])->name('admin.locations.upazilas');
            Route::get('/upazilas/create', [LocationController::class, 'createUpazila'])->name('admin.locations.upazilas.create');
            Route::post('/upazilas', [LocationController::class, 'storeUpazila'])->name('admin.locations.upazilas.store');
            Route::get('/upazilas/{upazila}/edit', [LocationController::class, 'editUpazila'])->name('admin.locations.upazilas.edit');
            Route::put('/upazilas/{upazila}', [LocationController::class, 'updateUpazila'])->name('admin.locations.upazilas.update');
            Route::delete('/upazilas/{upazila}', [LocationController::class, 'destroyUpazila'])->name('admin.locations.upazilas.destroy');
        });
        
        // Web Template Management
        Route::get('web-template', [WebsiteContentController::class, 'webTemplate'])->name('admin.web-template.index');
        Route::post('web-template/update', [WebsiteContentController::class, 'updateWebTemplate'])->name('admin.web-template.update');

        // Website Content Management
        Route::resource('website-contents', WebsiteContentController::class)->names([
            'index' => 'admin.website_contents.index',
            'create' => 'admin.website_contents.create',
            'store' => 'admin.website_contents.store',
            'edit' => 'admin.website_contents.edit',
            'update' => 'admin.website_contents.update',
            'destroy' => 'admin.website_contents.destroy',
        ]);

        // Milestone Management
        Route::post('milestone/store', [MilestoneController::class, 'store'])->name('admin.milestone.store');
        Route::post('milestone/update', [MilestoneController::class, 'update'])->name('admin.milestone.update');
        Route::post('milestone/delete', [MilestoneController::class, 'delete'])->name('admin.milestone.delete');

        // Team Management
        Route::post('team/store', [TeamController::class, 'store'])->name('admin.team.store');
        Route::post('team/update', [TeamController::class, 'update'])->name('admin.team.update');
        Route::post('team/delete', [TeamController::class, 'delete'])->name('admin.team.delete');

        // Blood Request Management
        Route::prefix('blood-requests')->group(function () {
            Route::get('/', [BloodRequestController::class, 'index'])->name('admin.blood_requests.index');
            Route::get('/create', [BloodRequestController::class, 'create'])->name('admin.blood_requests.create');
            Route::post('/', [BloodRequestController::class, 'store'])->name('admin.blood_requests.store');
            Route::get('/{bloodRequest}', [BloodRequestController::class, 'show'])->name('admin.blood_requests.show');
            Route::get('/{bloodRequest}/edit', [BloodRequestController::class, 'edit'])->name('admin.blood_requests.edit');
            Route::put('/{bloodRequest}', [BloodRequestController::class, 'update'])->name('admin.blood_requests.update');
            Route::delete('/{bloodRequest}', [BloodRequestController::class, 'destroy'])->name('admin.blood_requests.destroy');

            // Additional Blood Request Routes
            Route::post('/{bloodRequest}/assign-donor', [BloodRequestController::class, 'assignDonor'])
                ->name('admin.blood_requests.assign_donor')
                ->middleware('web');
            Route::delete('/{bloodRequest}/donors/{donation}', [BloodRequestController::class, 'removeDonor'])
                ->name('admin.blood_requests.remove_donor');
            Route::patch('/{bloodRequest}/update-status', [BloodRequestController::class, 'updateStatus'])
                ->name('admin.blood_requests.update_status');
            Route::get('/{bloodRequest}/assign-donor-page', [BloodRequestController::class, 'assignDonorPage'])->name('admin.blood_requests.assign_donor_page');
        });

        // API Endpoints for Admin
        Route::prefix('api')->group(function () {
            Route::get('/potential-donors', [BloodRequestController::class, 'getPotentialDonors'])->name('admin.api.potential_donors');
            Route::get('/nearby-hospital-requests', [BloodRequestController::class, 'getNearbyHospitalRequests'])->name('admin.api.nearby_hospital_requests');
        });

        // Blood Donation Management
        Route::prefix('blood-donations')->group(function () {
            Route::get('/', [BloodDonationController::class, 'index'])->name('admin.blood_donations.index');
            Route::get('/create', [BloodDonationController::class, 'create'])->name('admin.blood_donations.create');
            Route::post('/', [BloodDonationController::class, 'store'])->name('admin.blood_donations.store');
            Route::get('/{donation}', [BloodDonationController::class, 'show'])->name('admin.blood_donations.show');
            Route::get('/{donation}/edit', [BloodDonationController::class, 'edit'])->name('admin.blood_donations.edit');
            Route::put('/{donation}', [BloodDonationController::class, 'update'])->name('admin.blood_donations.update');
            Route::delete('/{donation}', [BloodDonationController::class, 'destroy'])->name('admin.blood_donations.destroy');
            
            // Additional Blood Donation Routes
            Route::patch('/{donation}/update-status', [BloodDonationController::class, 'updateStatus'])
                ->name('admin.blood_donations.update_status');
        });

        // Gallery Management
        Route::prefix('gallery')->group(function () {
            // Gallery Categories
            Route::resource('gallery-categories', GalleryCategoryController::class)->names([
                'index' => 'admin.gallery-categories.index',
                'create' => 'admin.gallery-categories.create',
                'store' => 'admin.gallery-categories.store',
                'show' => 'admin.gallery-categories.show',
                'edit' => 'admin.gallery-categories.edit',
                'update' => 'admin.gallery-categories.update',
                'destroy' => 'admin.gallery-categories.destroy',
            ]);
            
            // Gallery Items
            Route::resource('gallery', GalleryController::class)->names([
                'index' => 'admin.gallery.index',
                'create' => 'admin.gallery.create',
                'store' => 'admin.gallery.store',
                'show' => 'admin.gallery.show',
                'edit' => 'admin.gallery.edit',
                'update' => 'admin.gallery.update',
                'destroy' => 'admin.gallery.destroy',
            ]);
            
            // Additional Gallery Image Routes
            Route::delete('images/{id}', [GalleryController::class, 'deleteImage'])->name('admin.gallery.image.delete');
            Route::post('images/order', [GalleryController::class, 'updateImagesOrder'])->name('admin.gallery.images.order');
        });

        // Testimonials Management
        Route::resource('testimonials', TestimonialController::class)->names([
            'index' => 'admin.testimonials.index',
            'create' => 'admin.testimonials.create',
            'store' => 'admin.testimonials.store',
            'show' => 'admin.testimonials.show',
            'edit' => 'admin.testimonials.edit',
            'update' => 'admin.testimonials.update',
            'destroy' => 'admin.testimonials.destroy',
        ]);
        
        // Sponsors Management
        Route::resource('sponsors', SponsorController::class)->names([
            'index' => 'admin.sponsors.index',
            'create' => 'admin.sponsors.create',
            'store' => 'admin.sponsors.store',
            'show' => 'admin.sponsors.show',
            'edit' => 'admin.sponsors.edit',
            'update' => 'admin.sponsors.update',
            'destroy' => 'admin.sponsors.destroy',
        ]);
        
        // Events Management
        Route::resource('events', EventController::class)->names([
            'index' => 'admin.events.index',
            'create' => 'admin.events.create',
            'store' => 'admin.events.store',
            'show' => 'admin.events.show',
            'edit' => 'admin.events.edit',
            'update' => 'admin.events.update',
            'destroy' => 'admin.events.destroy',
        ]);
        
        // Internal Programs Management
        Route::prefix('internal-programs')->group(function () {
            Route::get('/', [InternalProgramController::class, 'index'])->name('admin.internal-programs.index');
            Route::get('/create', [InternalProgramController::class, 'create'])->name('admin.internal-programs.create');
            Route::post('/', [InternalProgramController::class, 'store'])->name('admin.internal-programs.store');
            Route::get('/{internalProgram}', [InternalProgramController::class, 'show'])->name('admin.internal-programs.show');
            Route::get('/{internalProgram}/edit', [InternalProgramController::class, 'edit'])->name('admin.internal-programs.edit');
            Route::put('/{internalProgram}', [InternalProgramController::class, 'update'])->name('admin.internal-programs.update');
            
            // Additional Internal Program Routes
            Route::patch('/{internalProgram}/update-status', [InternalProgramController::class, 'updateStatus'])
                ->name('admin.internal-programs.update_status');
        });

        // Contact Messages
        Route::resource('contacts', ContactController::class)->except(['create', 'edit', 'store'])->names([
            'index' => 'admin.contacts.index',
            'show' => 'admin.contacts.show',
            'update' => 'admin.contacts.update',
            'destroy' => 'admin.contacts.destroy',
        ]);
        Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('admin.contacts.reply');
    });
}); 