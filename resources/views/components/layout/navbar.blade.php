@php
    $links = [
        [
            'label' => 'Início',
            'route' => 'welcome',
            'active' => ['welcome'],
        ],
        [
            'label' => 'Análise',
            'route' => 'selection',
            'active' => ['selection', 'graph.*', 'metrics.*'],
        ],
        [
            'label' => 'Medicamentos',
            'route' => 'drugs.index',
            'active' => ['drugs.*'],
        ],
        [
            'label' => 'Interações',
            'route' => 'interactions.index',
            'active' => ['interactions.*'],
        ],
        [
            'label' => 'Classificações',
            'route' => 'classifications.index',
            'active' => ['classifications.*'],
        ],
    ];

    $adminLinks = [
        [
            'label' => 'Medicamentos',
            'route' => 'drugs.index',
            'icon' => 'pill',
        ],
        [
            'label' => 'Interações',
            'route' => 'interactions.index',
            'icon' => 'network',
        ],
        [
            'label' => 'Classificações',
            'route' => 'classifications.index',
            'icon' => 'layers',
        ],
        [
            'label' => 'Usuários',
            'route' => 'users.index',
            'icon' => 'users',
        ],
    ];
@endphp

<header class="navbar">

    <div class="container navbar__inner">

        <a
            href="{{ route('welcome') }}"
            class="navbar__brand">

            <x-ui.icon name="network" size="lg" />

            {{ config('app.name') }}

        </a>

        <button
            type="button"
            class="navbar__toggle"
            aria-label="Abrir menu de navegação"
            aria-expanded="false"
            aria-controls="main-navigation"
            data-navbar-toggle>

            <x-ui.icon name="menu" />

        </button>

        <nav
            id="main-navigation"
            class="navbar__navigation"
            aria-label="Navegação principal"
            data-navbar-navigation>

            @foreach ($links as $link)

                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'navbar__link',
                        'navbar__link--active' =>
                            request()->routeIs(...$link['active']),
                    ])>

                    {{ $link['label'] }}

                </a>

            @endforeach

            @auth

                <details class="navbar__dropdown">

                    <summary class="navbar__dropdown-trigger">

                        <x-ui.icon name="users" size="sm" />

                        Administrar

                        <x-ui.icon name="chevron-down" size="xs" />

                    </summary>

                    <div class="navbar__dropdown-menu">

                        <p class="navbar__dropdown-label">
                            {{ auth()->user()->name }}
                        </p>

                        <hr class="navbar__dropdown-divider">

                        @foreach ($adminLinks as $link)

                            <a
                                href="{{ route($link['route']) }}"
                                class="navbar__dropdown-item">

                                <x-ui.icon
                                    :name="$link['icon']"
                                    size="sm"
                                />

                                {{ $link['label'] }}

                            </a>

                        @endforeach

                        <hr class="navbar__dropdown-divider">

                        <form
                            method="POST"
                            action="{{ route('auth.logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="
                                    navbar__dropdown-item
                                    navbar__dropdown-item--danger
                                ">

                                <x-ui.icon name="log-out" size="sm" />

                                Sair

                            </button>

                        </form>

                    </div>

                </details>

            @endauth

        </nav>

    </div>

</header>
