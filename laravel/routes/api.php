<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;

// Public login endpoint
Route::post('/login', [AuthController::class, 'login']);

// Protected routes - require API token (Passport)
Route::middleware('auth:api')->group(function () {
    // Get current user with roles
    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'roles' => $request->user()->load('roles')->roles,
        ]);
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'getCategories');
        Route::post('/', 'createCategory');
        Route::get('/{categoryId}', 'getCategory');
        Route::put('/{categoryId}', 'updateCategory');
        Route::delete('/{categoryId}', 'deleteCategory');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function() {
        Route::get('/', 'getProducts');
        Route::post('/', 'createProduct');
        Route::get('/{categoryId}', 'getProduct');
        Route::put('/{categoryId}', 'updateProduct');
        Route::delete('/{categoryId}', 'deleteProduct');
    });
});