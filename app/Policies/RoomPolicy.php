<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Room;

class RoomPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Room $room): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Room $room): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Room $room): bool
    {
        return $user->role === 'admin';
    }
}
