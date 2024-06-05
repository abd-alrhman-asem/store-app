<?php


use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/', 'index');      // List all products
        Route::post('/', 'store');     // Create a new product
        Route::get('/{product}', 'show');    // Show a single product
        Route::put('/{product}', 'update');  // Update a product
        Route::patch('/{product}', 'update');  // Partial update of a product
        Route::delete('/{product}', 'destroy');  // Delete a product
    });
});

