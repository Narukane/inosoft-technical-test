<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\SalesController;
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
    Route::get('/cars', [VehiclesController::class, 'getAllCars']);
    Route::get('/cars/{carId}', [VehiclesController::class, 'getCarById']);
    Route::put('/cars/{carId}', [VehiclesController::class, 'updateCar']);
    Route::delete('/cars/{carId}', [VehiclesController::class, 'deleteCar']);

    // Motor routes
    Route::post('/motors', [VehiclesController::class, 'createMotor']);
    Route::get('/motors', [VehiclesController::class, 'getAllMotors']);
    Route::get('/motors/{motorId}', [VehiclesController::class, 'getMotorById']);
    Route::put('/motors/{motorId}', [VehiclesController::class, 'updateMotor']);
    Route::delete('/motors/{motorId}', [VehiclesController::class, 'deleteMotor']);
    
    // Sales routes
    Route::post('/sales', [SalesController::class, 'createSales']);
    Route::get('/sales', [SalesController::class, 'getAllSales']);
    Route::get('/sales/{salesId}', [SalesController::class, 'getSalesById']);
});
