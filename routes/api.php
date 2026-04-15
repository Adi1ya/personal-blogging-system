<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EngagementController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/blogs', [BlogController::class, 'index']);
        Route::get('/blogs/{id}', [BlogController::class, 'show']);
        Route::post('/blogs', [BlogController::class, 'store']);
        Route::patch('/blogs/{id}', [BlogController::class, 'update']);
        Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

        Route::post('/authors/{author}/follow', [EngagementController::class, 'follow']);
        Route::delete('/authors/{author}/unfollow', [EngagementController::class, 'unfollow']);
        Route::get('/authors/{author}/followers', [EngagementController::class, 'followers']);
        Route::get('/me/following', [EngagementController::class, 'following']);
    });
});
