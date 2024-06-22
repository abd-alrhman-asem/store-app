<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

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

Route::apiResource('/products' , ProductController::class);
Route::apiResource('/categories' , CategoryController::class);

// Include the auth routes
include __DIR__ . "/Auth/Auth.php";

// Define a fallback route for handling invalid URLs
// This will return a 404 Not Found response with a custom error message
Route::fallback(function () {
    return notFoundResponse('Invalid URL, URL not found');
});

Route::apiResource('orders', OrderController::class)
    ->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::patch('orders/{order}', [OrderController::class, 'update'])
        ->middleware('check.order.ownership');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])
        ->middleware('check.order.ownership');
});
