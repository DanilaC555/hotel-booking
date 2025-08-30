@component('mail::message')
# Отмена бронирования №{{ $booking->id }}

Здравствуйте, {{ $booking->user->name }}.
Ваше бронирование отменено.

Если это ошибка — свяжитесь с поддержкой.
@endcomponent
