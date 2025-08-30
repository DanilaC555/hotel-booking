<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    // обратная связь Многие ко многим
    public function hotels(): BelongsToMany
    {
        return $this->BelongsToMany(Hotel::class, 'facility_hotel');
    }

    public function rooms(): BelongsToMany
    {
        return $this->BelongsToMany(Room::class, 'facility_room');
    }
}
