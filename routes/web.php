<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Public pages
Route::get('/', function () {
    return view('landingpage');
});

Route::get('/home', function () {
    return view('landingpage');
});

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Forgot password page
Route::get('/forget', function () {
    return view('forget');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
    // Logout ✅
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');