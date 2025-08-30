@component('mail::message')
# Подтверждение бронирования №{{ $booking->id }}

Здравствуйте, {{ $booking->user->name }}!

Ваше бронирование подтверждено.

- Отель: **{{ $booking->room->hotel->name }}**
- Номер: **{{ $booking->room->name }}**
- Даты: {{ $booking->started_at->format('d.m.Y') }} — {{ $booking->finished_at->format('d.m.Y') }}
- Сумма: {{ number_format($booking->price, 0, '', ' ') }} ₽

@component('mail::button', ['url' => route('bookings.show', $booking)])
Посмотреть бронирование
@endcomponent

Спасибо, что выбрали нас!
@endcomponent
