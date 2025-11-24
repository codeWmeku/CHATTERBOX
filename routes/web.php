<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLanding'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
    
    // Google OAuth
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
    
    // Apple OAuth
    Route::get('/auth/apple', [AuthController::class, 'redirectToApple'])->name('auth.apple');
    Route::get('/auth/apple/callback', [AuthController::class, 'handleAppleCallback']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PostController::class, 'index'])->name('dashboard');
    Route::get('/users/{username}', [App\Http\Controllers\PostController::class, 'profile'])->name('profile');
    Route::post('/posts/{post}/like', [App\Http\Controllers\PostController::class, 'like'])->name('posts.like');
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});