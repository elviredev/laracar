<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Car Search
Route::get('/car/search', [CarController::class, 'search'])->name('car.search');

// Routes for user not authenticated
Route::middleware(['guest'])->group(function () {
  // Login, Signup
  Route::get('/signup', [SignupController::class, 'create'])->name('signup');
  Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');
  Route::get('/login', [LoginController::class, 'create'])->name('login');
  Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Routes for user authenticated
Route::middleware(['auth'])->group(function () {
  // Middleware Verify Email
  Route::middleware(['verified'])->group(function () {
    Route::get('/car/watchlist', [CarController::class, 'watchlist'])->name('car.watchlist');
    // Car
    Route::resource('car', CarController::class)->except(['show']);
    Route::get('/car/{car}/images', [CarController::class, 'carImages'])->name('car.images');
    Route::put('/car/{car}/images', [CarController::class, 'updateImages'])->name('car.updateImages');
    Route::post('/car/{car}/images', [CarController::class, 'addImages'])->name('car.addImages');
  });

  // logout
  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Route car.show accessible si user non authentifié
Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');

// Reset Password
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])
  ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
  ->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])
  ->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
  ->name('password.update');

// Verify Email
Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verify'])
  ->middleware(['auth', 'signed'])
  ->name('verification.verify');
Route::get('/email/verify', [EmailVerifyController::class, 'notice'])
  ->middleware('auth')
  ->name('verification.notice');
Route::post('/email/verification-notification', [EmailVerifyController::class, 'send'])
  ->middleware(['auth', 'throttle:6,1'])
  ->name('verification.send');

// Authentification avec Google ou Facebook
Route::get('/login/oauth/{provider}', [SocialiteController::class, 'redirectToProvider'])
  ->name('login.oauth');
Route::get('/callback/oauth/{provider}', [SocialiteController::class, 'handleCallback']);





