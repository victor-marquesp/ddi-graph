@props([
    'label',
    'value' => null,
    'unit' => null,
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->class(['metric-card']) }}>

    <div class="metric-card__header">

        <h3 class="metric-card__label">
            {{ $label }}
        </h3>

        @if ($icon)
            <x-ui.icon
                :name="$icon"
                class="metric-card__icon"
            />
        @endif

    </div>

    <div class="metric-card__value">

        {{ $value ?? '—' }}

        @if ($unit !== null && $value !== null)
            <span class="metric-card__unit">
                {{ $unit }}
            </span>
        @endif

    </div>

    @if ($description)
        <p class="metric-card__description">
            {{ $description }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="metric-card__footer">
            {{ $slot }}
        </div>
    @endif

</div>
