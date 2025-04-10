<?php

use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProviderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Appointments
    Route::get('/allAppointments', [AppointmentController::class, 'index']);
    Route::post('/storeAppointments', [AppointmentController::class, 'store']);
    Route::delete('/delete/appointments/{id}', [AppointmentController::class, 'destroy']);

    // Providers
    Route::get('/providers', [ProviderController::class, 'index']);
    Route::post('/storeProviders', [ProviderController::class, 'store']);
    Route::get('/providers/{id}', [ProviderController::class, 'show']);
    Route::post('/updateProviders/{id}', [ProviderController::class, 'update']);
});




