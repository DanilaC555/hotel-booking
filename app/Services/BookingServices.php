<?php

namespace App\Services;
use App\Models\Booking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmedMail;
use App\Mail\BookingCancelledMail;

class BookingServices
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Booking::class);
        // Мы говорим: «Возьми брони (Booking) и сразу подтяни комнату и её отель».
        // Laravel видит:
        // В Booking есть метод room() → belongsTo(Room::class).
        // Значит, у каждой записи в таблице bookings есть поле room_id, которое указывает на rooms.id.
        // В Room есть метод hotel() → belongsTo(Hotel::class).
        // Значит, у каждой комнаты есть поле hotel_id, которое указывает на hotels.id.
        return Booking::with('room.hotel')->where('user_id', Auth::id())->latest()->get();
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return $booking->load('room.hotel', 'user');
    }

    public function store($data)
    {
        $this->authorize('create', Booking::class);

        $room = Room::findOrFail($data['room_id']);

        // Проверка пересечения дат
        $overlap = Booking::where('room_id', $room->id)
            ->where('started_at', '<=', $data['finished_at'])   // бронь начинается до конца нашей даты
            ->where('finished_at', '>=', $data['started_at'])   // и заканчивается после начала нашей даты
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'dates' => 'На выбранные даты номер уже занят',
            ]);
        }

        $days = Carbon::parse($data['started_at'])->diffInDays(Carbon::parse($data['finished_at']));
        $days = max(1, $days);

        $booking = Booking::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'started_at' => $data['started_at'],
            'finished_at' => $data['finished_at'],
            'days' => $days,
            'price' => $room->price * $days,
        ]);

        // напоминание за 1 день до заезда
        $booking->remind_at = Carbon::parse($booking->started_at)->subDay();
        $booking->save();

        // письмо подтверждения
        Mail::to($booking->user->email)->send(new BookingConfirmedMail($booking));

        return $booking;
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        if (! $booking->canBeCancelled()) {
            // уже началось или в прошлом — не даём
            throw ValidationException::withMessages([
                'booking' => 'Нельзя отменить бронирование после даты заезда.',
            ]);
        }

        // письмо об отмене
        Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));

        return $booking->delete();
    }
}
