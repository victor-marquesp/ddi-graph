@props([
    'variant' => 'info',
    'title' => null,
])

@php
    $icon = match ($variant) {
        'success' => 'check-circle',
        'danger' => 'circle-alert',
        'warning' => 'triangle-alert',
        default => 'info',
    };
@endphp

<div
    role="{{ $variant === 'danger' ? 'alert' : 'status' }}"
    {{ $attributes->class([
        'alert',
        'alert--' . $variant,
    ]) }}>

    <x-ui.icon :name="$icon" />

    <div class="alert__content">

        @if ($title)
            <strong class="alert__title">
                {{ $title }}
            </strong>
        @endif

        {{ $slot }}

    </div>

</div>
