<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//register
Route::post('/register',[RegisterController::class, 'register']);
//Login
Route::post('/login', [LoginController::class, 'Login']);
//Logout
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:api');
