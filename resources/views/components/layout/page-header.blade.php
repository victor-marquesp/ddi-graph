@props([
    'title',
    'description' => null,
    'icon' => null,
])

<header {{ $attributes->class(['page-header']) }}>

    <div class="page-header__main">

        @if ($icon)

            <div class="page-header__icon">
                <x-ui.icon :name="$icon" size="lg" />
            </div>

        @endif

        <div class="page-header__content">

            <h1 class="page-header__title">
                {{ $title }}
            </h1>

            @if ($description)

                <p class="page-header__description">
                    {{ $description }}
                </p>

            @endif

        </div>

    </div>

    @if ($slot->isNotEmpty())

        <div class="page-header__actions">
            {{ $slot }}
        </div>

    @endif

</header>
