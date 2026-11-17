@props([
    'title' => 'Nenhum registro encontrado',
    'description' => null,
    'icon' => 'inbox',
])

<div {{ $attributes->class(['empty-state']) }}>

    <div class="empty-state__icon">
        <x-ui.icon :name="$icon" size="xl" />
    </div>

    <h3 class="empty-state__title">
        {{ $title }}
    </h3>

    @if ($description)
        <p class="empty-state__description">
            {{ $description }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="empty-state__actions">
            {{ $slot }}
        </div>
    @endif

</div>
