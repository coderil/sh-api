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

Route::group([
    'prefix' => 'users'
], function($route) {
    $route->post('/register', [AuthController::class, 'register']);
    $route->post('/login', [AuthController::class, 'login']);

    $route->post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::group([
    'prefix' => 'shops',
    'middleware' => 'auth:sanctum'
], function($route) {
    $route->get('/', [ShopController::class, 'index']);
    $route->post('/', [ShopController::class, 'store']);
    $route->get('/{shop}', [ShopController::class, 'show']);
    $route->put('/{shop}', [ShopController::class, 'update']);
    $route->delete('/{shop}', [ShopController::class, 'destroy']);
});

Route::group([
    'prefix' => 'products'
], function($route) {
    $route->get('/', [ProductController::class, 'index']);
    $route->get('/{id}', [ProductController::class, 'show']);

    $route->post('/', [ProductController::class, 'store']);
    $route->post('/{id}', [ProductController::class, 'update']);
    $route->post('/{id}', [ProductController::class, 'destroy']);
});

