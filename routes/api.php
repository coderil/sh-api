<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Shop\ShopController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//      Public Routes
Route::prefix('users')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::controller(ShopController::class)->group(function() {
    Route::get('/shops', 'index');
    Route::get('/shops/{shop}');
});

Route::controller(ProductController::class)->group(function() {
    Route::get('/products', 'index');
    Route::get('/products/{product}');
});

//      Protected Routes
Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('users')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::controller(ShopController::class)->group(function() {
        Route::post('/shops', 'index');
        Route::put('/shops/{shop}', 'update');
        Route::delete('/shops/{shop}', 'destroy');
        // Route::post('/shops/{id}/deactivate', 'deactivate');
        // Route::post('/shops/{id}/activate', 'activate');
    });

    Route::controller(ProductController::class)->group(function() {
        Route::post('/products', 'index');
        Route::put('/products/{product}', 'update');
        Route::delete('/products/{product}', 'destroy');
    });
});
