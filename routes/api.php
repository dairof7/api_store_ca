<?php

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Framework\Laravel\Controllers\ProductController;
use App\Http\Controllers\AuthController;


// Auth routes group with middleware 'api' and 'auth' prefix
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes group for authenticated users (middleware 'auth:api' required)
Route::middleware('auth:api')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id?}', [ProductController::class, 'index']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});