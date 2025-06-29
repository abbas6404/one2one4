<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\DivisionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/districts/{district}/upazilas', [DistrictController::class, 'getUpazilas']);
Route::get('/divisions/{division}/districts', [DivisionController::class, 'getDistricts']);

// Routes for cascading dropdowns
Route::get('/districts/{divisionId}', [DistrictController::class, 'getByDivision']);
Route::get('/upazilas/{districtId}', [DistrictController::class, 'getUpazilasByDistrict']);
