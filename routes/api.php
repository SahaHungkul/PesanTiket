<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//register
Route::post('/register',[RegisterController::class, 'register']);
//Login
Route::post('/login', [LoginController::class, 'login']);
//Logout
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:api');
