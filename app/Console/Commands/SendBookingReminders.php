<?php

namespace App\Console\Commands;

use App\Mail\BookingReminderMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBookingReminders extends Command
{
    protected $signature = 'notifications:send-reminders';
    protected $description = 'Send upcoming check-in reminders';

    public function handle(): int
    {
        $now = Carbon::now();
        $windowEnd = $now->copy()->addHour(); // шлём тем, у кого remind_at в ближайший час

        $query = Booking::with(['user','room.hotel'])
            ->whereNull('reminded_at')
            ->whereNotNull('remind_at')
            ->whereBetween('remind_at', [$now, $windowEnd]);

        $count = 0;

        $query->chunkById(200, function ($bookings) use (&$count) {
            foreach ($bookings as $b) {
                Mail::to($b->user->email)->send(new BookingReminderMail($b));
                $b->forceFill(['reminded_at' => now()])->save();
                $count++;
            }
        });

        $this->info("Reminders sent: {$count}");
        return self::SUCCESS;
    }
}
