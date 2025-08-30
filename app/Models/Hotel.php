<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'poster_url',
        'address',
        'stars'
    ];

    protected function casts(): array
    {
        return [
            'stars' => 'integer',
        ];
    }

    public function rooms(): HasMany // отель может содержать много комнат
    {
        // $hotel = Hotel::find(1);
        // $rooms = $hotel->rooms; // сразу получаешь все комнаты отеля
        return $this->hasMany(Room::class);
    }

    public function facilities(): BelongsToMany // многое ко мнигим
    {
        // Laravel понимает: чтобы получить удобства отеля, нужно пройти через промежуточную таблицу
        return $this->belongsToMany(Facility::class, 'facility_hotel');
        // $hotel->facilities as $facility можем так использовать
    }
}
