<?php

namespace Database\Seeders;

use App\Models\{User, Hotel, Room, Facility, Booking};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Админ
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        // Обычный пользователь
        $user = User::updateOrCreate(
            ['email' => 'user@example.com'], // для отправки письма на почту свой email
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        // Удобства (уникальные)
        $facilityNames = [
            'Wi-Fi','Завтрак','Парковка','Кондиционер','Бассейн',
            'Фитнес','Спа','24/7 ресепшн','Трансфер','Бар',
        ];
        $facilities = collect();
        foreach ($facilityNames as $n) {
            $facilities->push(Facility::firstOrCreate(['name' => $n]));
        }

        // Отели + комнаты
        $hotels = Hotel::factory(8)->create();

        $rooms = collect();
        foreach ($hotels as $hotel) {
            // Привяжем удобства к отелю
            $hotel->facilities()->sync(
                $facilities->random(rand(3, 6))->pluck('id')->all()
            );

            // 3-5 комнат
            $hotelRooms = Room::factory(rand(3, 5))->create([
                'hotel_id' => $hotel->id
            ]);

            // Привяжем удобства к комнатам
            foreach ($hotelRooms as $room) {
                $room->facilities()->sync(
                    $facilities->random(rand(2, 5))->pluck('id')->all()
                );
                $rooms->push($room);
            }
        }

        // Создаём брони без пересечений по каждой комнате
        foreach ($rooms as $room) {
            $bookingsCount = rand(0, 3);
            $attempts = 0;

            for ($i = 0; $i < $bookingsCount; $i++) {
                // пытаемся подобрать окно дат без пересечения
                $created = false;
                while (!$created && $attempts < 30) {
                    $attempts++;

                    $start = Carbon::now()->addDays(rand(1, 90));
                    $days = rand(1, 7);
                    $end = (clone $start)->addDays($days);

                    $overlap = Booking::where('room_id', $room->id)
                        ->where(function($q) use ($start, $end) {
                            $q->whereBetween('started_at', [$start, $end])
                              ->orWhereBetween('finished_at', [$start, $end])
                              ->orWhere(function($qq) use ($start, $end) {
                                  $qq->where('started_at', '<=', $start)
                                     ->where('finished_at', '>=', $end);
                              });
                        })->exists();

                    if (! $overlap) {
                        $price = $room->price * $days;
                        Booking::create([
                            'room_id'     => $room->id,
                            'user_id'     => $user->id,
                            'started_at'  => $start,
                            'finished_at' => $end,
                            'days'        => $days,
                            'price'       => $price,
                        ]);
                        $created = true;
                    }
                }
            }
        }
    }
}
