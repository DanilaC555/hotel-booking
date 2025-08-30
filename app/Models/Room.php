<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'poster_url',
        'floor_area',
        'type',
        'price',
        'hotel_id',
    ];

    // обратная связи Один ко многим
    public function hotel(): BelongsTo
    {
        // разрешить номеру доступ к его родительскому отелю
        return $this->belongsTo(Hotel::class);
        // return $room->hotel->name;
    }

    public function facilities():BelongsToMany
    {
        // $room->facilities as $room
        return $this->belongsToMany(Facility::class, 'facility_room');
    }

    public function bookings(): HasMany // комната может содержать много броней
    {
        return $this->hasMany(Booking::class);
    }
}
