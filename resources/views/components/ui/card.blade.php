@props([
    'title' => null,
    'description' => null,
    'compact' => false,
    'flush' => false,
])

<div {{ $attributes->class([
    'card',
    'card--compact' => $compact,
    'card--flush' => $flush,
]) }}>

    @if ($title || $description || isset($header))
        <div class="card__header">

            @if (isset($header))
                {{ $header }}
            @else
                @if ($title)
                    <h2 class="card__title">{{ $title }}</h2>
                @endif

                @if ($description)
                    <p class="card__description">
                        {{ $description }}
                    </p>
                @endif
            @endif

        </div>
    @endif

    <div class="card__body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card__footer">
            {{ $footer }}
        </div>
    @endisset

</div>
