<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])
  ->name('home');

// Car Search
Route::get('/car/search', [CarController::class, 'search'])
  ->name('car.search');

// Routes for user authenticated
Route::middleware(['auth'])->group(function () {
  // Middleware Verify Email
  Route::middleware(['verified'])->group(function () {
    Route::get('/car/watchlist', [CarController::class, 'watchlist'])
      ->name('car.watchlist');

    // Car
    Route::resource('car', CarController::class)
      ->except(['show']);
    Route::get('/car/{car}/images', [CarController::class, 'carImages'])
      ->name('car.images');
    Route::put('/car/{car}/images', [CarController::class, 'updateImages'])
      ->name('car.updateImages');
    Route::post('/car/{car}/images', [CarController::class, 'addImages'])
      ->name('car.addImages');
  });

  // Profile
  Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index');
  Route::put('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
  Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.updatePassword');
});

// Route car.show accessible si user non authentifié
Route::get('/car/{car}', [CarController::class, 'show'])
  ->name('car.show');

require_once __DIR__ . '/auth.php';



