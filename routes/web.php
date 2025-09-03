<?php

use Illuminate\Support\Facades\Route;
use App\Models\Booking;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/preview-view', function () {
    $booking = Booking::latest()->first();
    return view('emails.admin_booking_notification', compact('booking'));
});

Route::get('/mail-user',function(){
    $booking = Booking::latest()->first();
    return view('emails.user_booking_notif',compact('booking'));
});
