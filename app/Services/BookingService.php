<?php

namespace App\Services;

use App\Mail\AdminBookingNotificationMail;
use App\Mail\UserBookingNotifmail;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


// use Illuminate\Support\Facades\Log;

class BookingService
{
    public function store(array $validated, User $user): Booking
    {
        return DB::transaction(function () use ($validated, $user) {
            $event = Event::lockForUpdate()->findOrFail($validated['event_id']);

            if ($event->kuota < $validated['jumlah']) {
                throw new \Exception('Kuota tidak mencukupi.');
            }

            $ticketPrice = $event->ticket_price;
            $jumlah = $validated['jumlah'];
            $totalPrice = $ticketPrice * $validated['jumlah'];

            // Log::info('Booking Debug:', [
            //     'event_id'    => $event->id,
            //     'ticketPrice' => $ticketPrice,
            //     'jumlah'      => $jumlah,
            //     'totalPrice'  => $totalPrice,
            //     'user_id'     => $user->id,
            // ]);

            $event->kuota -= $validated['jumlah'];
            $event->save();

            $booking = Booking::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'jumlah' => $jumlah,
                'total_price' => $totalPrice,
                'kode_booking' => Str::upper(Str::random(10)),
                'status' => 'confirmed',
            ]);

            Mail::to($user->email)->send(new UserBookingNotifmail($booking));
            Mail::to('superadmin@example.com')->send(new AdminBookingNotificationMail($booking));

            return $booking;
        });
    }
}
