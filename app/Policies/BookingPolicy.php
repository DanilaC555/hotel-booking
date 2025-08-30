<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        // страница /bookings только для авторизованных
        return (bool) $user;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->role === 'admin' || $booking->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return (bool) $user; // любой авторизованный может бронировать
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->role === 'admin' || $booking->user_id === $user->id;
    }
}
