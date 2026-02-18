<?php

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

// Callback routes (no auth needed – called by Safaricom servers)
Route::post('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback']);
Route::post('/mpesa/callback', [\App\Http\Controllers\PaymentController::class, 'callback']);

// Payment routes that need web session auth (called from browser JS)
Route::middleware('web')->group(function () {
    Route::get('/payment/status/{checkoutRequestId}', [\App\Http\Controllers\PaymentController::class, 'status']);
    Route::post('/payment/initiate', [\App\Http\Controllers\PaymentController::class, 'initiateApi']);
});
