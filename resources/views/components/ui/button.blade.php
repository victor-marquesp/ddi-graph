@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'block' => false,
    'disabled' => false,
])

@php
    $classes = [
        'button',
        'button--' . $variant,
        'button--' . $size,
        'button--block' => $block,
    ];
@endphp

@if ($href !== null && !$disabled)

    <a href="{{ $href }}"
        {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>

@else

    <button
        type="{{ $type }}"
        @disabled($disabled)
        {{ $attributes->class($classes) }}>
        {{ $slot }}
    </button>

@endif
