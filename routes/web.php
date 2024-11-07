<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Car
Route::get('/car/search', [CarController::class, 'search'])->name('car.search');
Route::get('/car/watchlist', [CarController::class, 'watchlist'])->name('car.watchlist');

Route::resource('car', CarController::class);

Route::get('/car/{car}/images', [CarController::class, 'carImages'])->name('car.images');
Route::put('/car/{car}/images', [CarController::class, 'updateImages'])->name('car.updateImages');
Route::post('/car/{car}/images', [CarController::class, 'addImages'])->name('car.addImages');

// Login, Signup
Route::get('/signup', [SignupController::class, 'create'])->name('signup');
Route::get('/login', [LoginController::class, 'create'])->name('login');

