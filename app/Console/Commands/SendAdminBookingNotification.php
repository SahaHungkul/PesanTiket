<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminBookingNotificationMail;

class SendAdminBookingNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-admin-booking-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = Booking::where('status', 'confirmed')
            ->whereNull('admin_notified_at')
            ->get();
        if ($bookings->isEmpty()) {
            $this->info('Tidak ada booking baru untuk admin.');
            return;
        }

        foreach ($bookings as $booking) {
            // Kirim email ke admin
            Mail::to('superadmin@example.com')->send(
                new AdminBookingNotificationMail($booking)
            );

            // Update supaya tidak dikirim ulang
            $booking->update(['admin_notified_at' => now()]);

            $this->info("Notifikasi untuk booking #{$booking->id} sudah dikirim ke admin.");
        }
    }
}
