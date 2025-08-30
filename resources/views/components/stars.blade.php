@props([
    'value' => null,   // 1..5 или null
    'max' => 5,
    'size' => 'w-4 h-4',
])

@php
    $v = (int) ($value ?? 0);
@endphp

<div class="inline-flex items-center" aria-label="{{ $v ? $v . ' из ' . $max : 'без категории' }}">
    @for ($i = 1; $i <= $max; $i++)
        @if($i <= $v)
            {{-- filled star --}}
            <svg class="{{ $size }} mr-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.176 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.88 8.72c-.783-.57-.38-1.81.588-1.81H6.93a1 1 0 00.95-.69l1.17-3.292z"/>
            </svg>
        @else
            {{-- empty star (stroke) --}}
            <svg class="{{ $size }} mr-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path stroke-width="1.5" d="M12 17.27l5.556 3.326-1.473-6.215 4.589-3.984-6.07-.52L12 4l-2.602 5.877-6.07.52 4.59 3.984-1.474 6.215L12 17.27z"/>
            </svg>
        @endif
    @endfor

    <span class="ml-2 text-sm text-gray-600">
        {{ $v ? "{$v}★" : 'Без категории' }}
    </span>
</div>
