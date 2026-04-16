<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/login', [FrontendController::class, 'login'])->name('login');
Route::get('/register', [FrontendController::class, 'register'])->name('register');
Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
Route::get('/blogs/create', [FrontendController::class, 'createBlog'])->name('blogs.create');
Route::get('/blogs/{blog}/edit', [FrontendController::class, 'editBlog'])->name('blogs.edit');
Route::get('/stories/{slug}', [FrontendController::class, 'blogDetail'])->name('blogs.show');
Route::get('/profiles/{user}', [FrontendController::class, 'profile'])->name('profiles.show');
