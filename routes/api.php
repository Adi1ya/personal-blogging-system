<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\PublicContentController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/public/blogs', [PublicContentController::class, 'index']);
    Route::get('/public/blogs/{blog:slug}', [PublicContentController::class, 'show']);
    Route::get('/public/profiles/{user}', [PublicContentController::class, 'profile']);
    Route::get('/public/categories', [PublicContentController::class, 'categories']);
    Route::get('/public/tags', [PublicContentController::class, 'tags']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [PublicContentController::class, 'me']);

        Route::get('/blogs', [BlogController::class, 'index']);
        Route::get('/blogs/{id}', [BlogController::class, 'show']);
        Route::post('/blogs', [BlogController::class, 'store']);
        Route::patch('/blogs/{id}', [BlogController::class, 'update']);
        Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
        Route::post('blogs/{blog}/publish', [BlogController::class, 'publish']);
        Route::get('/blogs/tags/{tag}', [BlogController::class, 'searchByTag']);
        Route::get('/blogs/categories/{category}', [BlogController::class, 'searchByCategory']);

        Route::post('/authors/{author}/follow', [EngagementController::class, 'follow']);
        Route::delete('/authors/{author}/unfollow', [EngagementController::class, 'unfollow']);
        Route::get('/authors/{author}/followers', [EngagementController::class, 'followers']);
        Route::get('/me/following', [EngagementController::class, 'following']);

        Route::post('/blogs/{blog}/like', [EngagementController::class, 'like']);
        Route::delete('/blogs/{blog}/like', [EngagementController::class, 'removeLike']);
        Route::get('/blogs/{blog}/like', [EngagementController::class, 'listLikes']);
        Route::post('/blogs/{blog}/dislike', [EngagementController::class, 'dislike']);
        Route::delete('/blogs/{blog}/dislike', [EngagementController::class, 'removeDislike']);
        Route::get('/blogs/{blog}/dislike', [EngagementController::class, 'listDislikes']);
        Route::post('/blogs/{blog}/comments', [EngagementController::class, 'storeComment']);
        Route::get('/blogs/{blog}/comments', [EngagementController::class, 'listComments']);
        Route::get('/blogs/{blog}/comments/{comment}', [EngagementController::class, 'show']);
        Route::delete('/blogs/{blog}/comments/{comment}', [EngagementController::class, 'destroy']);
    });
});
