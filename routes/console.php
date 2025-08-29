<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::call(function(){
//     DB::table('bookings')->insert([
//         'id' =>
//     ]);
// });

Artisan::command('mail:test', function () {
    Mail::raw('Email percobaan via console.php.', function ($msg) {
        $msg->to('admin@example.com')->subject('Test Mailtrap Console');
    });

    $this->info('Email test terkirim ke Mailtrap.');
});

Schedule::command('app:send-admin-booking-notification')->everyThirtyMinutes();
