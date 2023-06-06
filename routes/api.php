<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;
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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Protected routes
Route::group(['middleware' => 'jwt.auth'], function () {
    // Car routes
    Route::post('/cars', [VehiclesController::class, 'createCar']);

    // Motor routes
    Route::post('/motors', [VehiclesController::class, 'createMotor']);
});
