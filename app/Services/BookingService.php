<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;

class BookingService
{
    public function store(array $validated, User $user): Booking
    {
        return DB::transaction(function () use ($validated, $user) {
            $event = Event::lockForUpdate()->findOrFail($validated['event_id']);

            if ($event->kuota < $validated['jumlah']) {
                throw new \Exception('Kuota tidak mencukupi.');
            }

            $event->kuota -= $validated['jumlah'];
            $event->save();

            $booking = Booking::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'jumlah' => $validated['jumlah'],
                'kode_booking' => Str::upper(Str::random(10)),
            ]);

            Mail::to($user->email)->queue(new BookingConfirmationMail($booking));

            return $booking;
        });
    }
}
