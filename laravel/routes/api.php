<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;


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

     // Task 3 APIs
    Route::controller(AuthorController::class)->prefix('authors')->group(function () {
        Route::post('/', 'store');
        Route::get('/{authorId}/articles', 'getArticles');
        Route::get('/{authorId}/audiences', 'getAudiences');
    });

    Route::controller(ArticleController::class)->prefix('articles')->group(function () {
        Route::post('/', 'store');
        Route::get('/{articleId}/audiences', 'getAudiences');
        Route::get('/{articleId}/comments', 'getComments');
    });

    Route::controller(AudienceController::class)->prefix('audiences')->group(function () {
        Route::post('/', 'store');
        Route::get('/{audienceId}/comments', 'getComments');
    });

    Route::controller(SubscriptionController::class)->prefix('subscriptions')->group(function () {
        Route::post('/', 'subscribe');
    });

    Route::controller(CommentController::class)->prefix('comments')->group(function () {
        Route::post('/', 'store');
        Route::get('/audience/{audienceId}', 'getByAudience');
        Route::get('/topic/search', 'getByTopic');
    });
});