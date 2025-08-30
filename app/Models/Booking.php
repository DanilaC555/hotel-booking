<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'started_at',
        'finished_at',
        'days',
        'price'
    ];

    protected function casts(): array
    {
        return [
            'started_at'  => 'datetime',
            'finished_at' => 'datetime',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
            'remind_at'   => 'datetime',
            'reminded_at' => 'datetime',
        ];
    }


    // обратные связи Один ко многим
    public function user(): BelongsTo // бронирование принадлежит одному пользователю
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo // каждая бронь принадлежит одной комнате
    {
        return $this->belongsTo(Room::class);
    }

    public function canBeCancelled(): bool
    {
        return now()->lt(\Carbon\Carbon::parse($this->started_at));
    }
}
