<?php

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

// Include the routes defined in the products.php file located in the products directory
include __DIR__ . "/products/products.php";

// Include the routes defined in the categories.php file located in the categories directory
include __DIR__ . "/Categories/categories.php";

// Define a fallback route for handling invalid URLs
// This will return a 404 Not Found response with a custom error message
Route::fallback(function () {
    return notFoundResponse('Invalid URL, URL not found');
});
