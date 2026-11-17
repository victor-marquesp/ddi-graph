@props([
    'label',
    'value' => null,
    'fallback' => 'Não informado',
    'full' => false,
])

<div {{ $attributes->class([
    'detail-item',
    'detail-item--full' => $full,
]) }}>

    <dt class="detail-item__label">
        {{ $label }}
    </dt>

    <dd class="detail-item__value">
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @elseif ($value !== null && $value !== '')
            {{ $value }}
        @else
            <span class="text-muted">
                {{ $fallback }}
            </span>
        @endif
    </dd>

</div>
