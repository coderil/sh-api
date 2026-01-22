<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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


