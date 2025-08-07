<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\BookingController;

Route::post('/register', [RegisterController::class, 'register'])->name('Register');
Route::post('/login', [LoginController::class, 'login'])->name('Login');

Route::middleware('auth:api')->group(function () {

    // Authenticated User Routes
    Route::get('/profile', [ProfileController::class, 'profile'])->name('Me');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('Logout');

    // Route::get('/user', fn(Request $request) => $request->user());

    Route::middleware('role:superAdmin')->group(function () {
        Route::resource('/users', UserController::class);
        Route::resource('/events', EventController::class)->only(['store', 'update', 'destroy']);
    });

    Route::middleware('role:admin|superAdmin|user')->group(function () {
        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    });

    Route::middleware('role:user|admin|superAdmin')->group(function () {
        Route::resource('/bookings', BookingController::class)->only(['store', 'index', 'show', 'destroy']);
    });
});
