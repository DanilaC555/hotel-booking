<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hotel;

class HotelPolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // список отелей доступен всем
    }

    public function view(?User $user, Hotel $hotel): bool
    {
        return true; // просмотр отеля доступен всем
    }

    // public function create(User $user): bool
    // {
    //     return $user->role === 'admin';
    // }

    // public function update(User $user, Hotel $hotel): bool
    // {
    //     return $user->role === 'admin';
    // }

    // public function delete(User $user, Hotel $hotel): bool
    // {
    //     return $user->role === 'admin';
    // }
}
