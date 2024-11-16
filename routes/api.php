<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Infrastructure\Framework\Laravel\Controllers\ProductController;


Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id?}', [ProductController::class, 'index']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

