<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row bg-gray-50 shadow rounded-lg overflow-hidden']) }}>
    <!-- Картинка -->
    <div class="w-full md:w-2/5">
        <img class="w-full h-48 md:h-full object-cover" src="{{ $booking->room->poster_url }}" alt="image"/>
    </div>

    <!-- Контент -->
    <div class="p-4 md:w-3/5 flex flex-col justify-between">
        <!-- Заголовок и дата -->
        <div class="mb-4">
            <p class="text-lg md:text-xl font-semibold leading-6 text-gray-800">
                Бронирование #{{ $booking->id }}
            </p>
            <p class="text-sm text-gray-600">{{ $booking->created_at->format('d-m-y H:i') }}</p>
        </div>

        <!-- Инфо о номере -->
        <div class="flex flex-col space-y-2 mb-4">
            <h3 class="text-xl xl:text-2xl font-semibold text-gray-800">{{ $booking->room->name }}</h3>
            <p class="text-sm text-gray-800">
                <span>Даты: </span>
                {{ \Carbon\Carbon::parse($booking->started_at)->format('d.m.Y') }}
                по
                {{ \Carbon\Carbon::parse($booking->finished_at)->format('d.m.Y') }}
            </p>
            <p class="text-sm text-gray-800"><span>Кол-во ночей:</span> {{ $booking->days }}</p>
        </div>

        <!-- Цена и кнопка -->
        <div class="flex justify-between items-center">
            <p class="text-base xl:text-lg font-semibold text-gray-800">
                Стоимость: {{ $booking->price }} руб
            </p>
            @if($showLink ?? false)
                <x-link-button href="{{ route('bookings.show', ['booking' => $booking]) }}">Подробнее</x-link-button>
            @endif
            <form method="POST" action="{{ route('bookings.destroy', $booking) }}"
                  onsubmit="return confirm('Точно отменить бронирование #{{ $booking->id }}?')">
                @csrf
                @method('DELETE')
                <x-the-button type="submit" class="bg-red-600 hover:bg-red-700">
                    Отменить
                </x-the-button>
            </form>
        </div>
    </div>
</div>
