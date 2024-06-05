<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/', 'index');                   // List all categories
        Route::post('/', 'store');                  // Create a new category
        Route::get('/{category}', 'show');          // Show a single category
        Route::put('/{category}', 'update');        // Update a category
        Route::patch('/{category}', 'update');      // Partial update of a category
        Route::delete('/{category}', 'destroy');    // Delete a category
    });
});
