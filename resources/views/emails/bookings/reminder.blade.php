@component('mail::message')
# Напоминание о брони №{{ $booking->id }}

Здравствуйте, {{ $booking->user->name }}!
Ждём вас завтра в нашем отеле 🏨

- Отель: **{{ $booking->room->hotel->name }}**
- Номер: **{{ $booking->room->name }}**
- Даты: {{ $booking->started_at->format('d.m.Y') }} — {{ $booking->finished_at->format('d.m.Y') }}

Хорошей дороги и до встречи!
@endcomponent
