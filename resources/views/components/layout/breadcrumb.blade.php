@props([
    'items' => [],
])

<nav
    aria-label="Localização da página"
    {{ $attributes->class(['breadcrumb']) }}>

    <ol class="breadcrumb__list">

        <li class="breadcrumb__item">

            <a
                href="{{ route('welcome') }}"
                class="breadcrumb__link">

                <x-ui.icon name="house" size="xs" />

                Início

            </a>

        </li>

        @foreach ($items as $item)

            <li class="breadcrumb__item">

                <x-ui.icon
                    name="chevron-right"
                    size="xs"
                    class="breadcrumb__separator"
                />

                @if ($loop->last)

                    <span
                        class="breadcrumb__current"
                        aria-current="page">

                        {{ $item['label'] }}

                    </span>

                @elseif (isset($item['href']))

                    <a
                        href="{{ $item['href'] }}"
                        class="breadcrumb__link">

                        {{ $item['label'] }}

                    </a>

                @else

                    <span class="text-muted">
                        {{ $item['label'] }}
                    </span>

                @endif

            </li>

        @endforeach

    </ol>

</nav>
