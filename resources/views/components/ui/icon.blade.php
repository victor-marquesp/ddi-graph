@props([
    'name',
    'size' => 'md',
])

@php
    $iconView = preg_match('/^[a-z0-9-]+$/', $name)
        ? 'icons.' . $name
        : null;
@endphp

<span
    aria-hidden="true"
    {{ $attributes->class([
        'icon',
        'icon--' . $size,
    ]) }}>

    @if ($iconView)
        @includeIf($iconView)
    @endif

</span>
