<?php

namespace App\Services;
use App\Models\Hotel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class HotelServices
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Hotel::class);

        // жадная загрузка, чтобы все сразу подтягивалось
        return Hotel::with('facilities')->withMin('rooms', 'price')->paginate(12);
    }

    public function show(Hotel $hotel)
    {
        $this->authorize('view', $hotel);

        $start = request('start_date', now()->format('Y-m-d'));
        $end = request('end_date', now()->addDay()->format('Y-m-d'));

        // Фильтр доступных комнат по датам (нет пересечений бронирований)
        $rooms = $hotel->rooms() // берём комнаты именно этого отеля
            ->with('facilities') // чтобы не ловить N+1, подтягиваем удобства всех выбранных комнат одним запросом
            // оставь комнаты, для которых не существует брони, удовлетворяющей условию внутри
            ->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                $q->where('started_at', '<=', $end)
                  ->where('finished_at', '>=', $start);
            })->get();

        // считаем дни и итог
        $days = max(1, Carbon::parse($start)->diffInDays(Carbon::parse($end)));
        // each аналог обычного foreach
        $rooms->each(function ($room) use ($days) {
            $room->total_days = $days;
            $room->total_price = $room->price * $days;
        });

        return [
            'hotel' => $hotel,
            'rooms' => $rooms,
        ];
    }
}
