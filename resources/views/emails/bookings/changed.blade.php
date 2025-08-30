{{-- @component('mail::message')
# Изменение бронирования №{{ $booking->id }}

Здравствуйте, {{ $booking->user->name }}!
Параметры вашей брони были изменены.

- Отель: **{{ $booking->room->hotel->name }}**
- Номер: **{{ $booking->room->name }}**
- Новые даты: {{ $booking->started_at->format('d.m.Y') }} — {{ $booking->finished_at->format('d.m.Y') }}

@component('mail::button', ['url' => route('bookings.show', $booking)])
Посмотреть бронирование
@endcomponent
@endcomponent --}}
