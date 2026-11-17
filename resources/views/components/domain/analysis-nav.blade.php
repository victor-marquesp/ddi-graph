@props([
    'ids' => null,
])

@php
    $selected = $ids !== null;

    $params = $selected
        ? ['drug_ids' => $ids]
        : [];

    $links = [
        [
            'label' => 'Tabular',
            'icon' => 'table',
            'route' => 'interactions.index',
        ],
        [
            'label' => 'Grafo',
            'icon' => 'network',
            'route' => $selected
                ? 'graph.selected'
                : 'graph.all',
        ],
        [
            'label' => 'Métricas',
            'icon' => 'chart-no-axes-column',
            'route' => $selected
                ? 'metrics.selected'
                : 'metrics.all',
        ],
    ];
@endphp

<nav
    aria-label="Representação da rede"
    {{ $attributes->class(['analysis-nav']) }}>

    @foreach ($links as $link)

        <a
            href="{{ route($link['route'], $params) }}"

            @class([
                'analysis-nav__link',
                'analysis-nav__link--active' =>
                    request()->routeIs($link['route']),
            ])

            @if (request()->routeIs($link['route']))
                aria-current="page"
            @endif
        >

            <x-ui.icon :name="$link['icon']" size="sm" />

            {{ $link['label'] }}

        </a>

    @endforeach

</nav>
