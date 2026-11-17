@extends('layouts.app')

@section('title', 'Início')

@section('content')

    <x-domain.disclaimer />

    <section class="hero">

        <div class="hero__content">

            <span class="hero__eyebrow">
                Projeto acadêmico
            </span>

            <h1 class="hero__title">
                Explore as interações medicamentosas
                através de grafos.
            </h1>

            <p class="hero__description">

                Uma ferramenta para representar, visualizar
                e analisar redes de interações entre
                medicamentos utilizando a teoria dos grafos.

            </p>

            <div class="cluster">

                <x-ui.button
                    :href="route('selection', ['mode' => 'graph'])"
                    size="lg">

                    <x-ui.icon name="network" />

                    Explorar interações

                </x-ui.button>

                <x-ui.button
                    variant="secondary"
                    :href="route('selection', ['mode' => 'metrics'])"
                    size="lg">

                    <x-ui.icon name="chart-no-axes-column" />

                    Analisar métricas

                </x-ui.button>

            </div>

        </div>

        <figure class="hero__illustration">

            <x-domain.graph-illustration />

            <figcaption>
                Representação ilustrativa de uma rede.
            </figcaption>

        </figure>

    </section>

    <x-domain.educational-notice />

    <section class="stack">

        <div class="stack stack--sm">

            <h2>Base de conhecimento</h2>

            <p class="text-muted">
                Explore as informações cadastradas no sistema.
            </p>

        </div>

        <div class="grid grid--3">

            @php
                $resources = [
                    [
                        'title' => 'Medicamentos',
                        'description' => 'Consulte os medicamentos cadastrados e suas respectivas classificações terapêuticas.',
                        'icon' => 'pill',
                        'route' => 'drugs.index',
                    ],
                    [
                        'title' => 'Interações',
                        'description' => 'Explore as interações medicamentosas, suas descrições e níveis de severidade.',
                        'icon' => 'network',
                        'route' => 'interactions.index',
                    ],
                    [
                        'title' => 'Classificações',
                        'description' => 'Consulte as classificações terapêuticas e os medicamentos associados.',
                        'icon' => 'layers',
                        'route' => 'classifications.index',
                    ],
                ];
            @endphp

            @foreach ($resources as $resource)

                <x-ui.card>

                    <div class="resource-card">

                        <div class="resource-card__icon">

                            <x-ui.icon
                                :name="$resource['icon']"
                                size="lg"
                            />

                        </div>

                        <h3>{{ $resource['title'] }}</h3>

                        <p class="resource-card__description">

                            {{ $resource['description'] }}

                        </p>

                        <x-ui.button
                            variant="ghost"
                            :href="route($resource['route'])">

                            Consultar

                            <x-ui.icon
                                name="arrow-right"
                                size="sm"
                            />

                        </x-ui.button>

                    </div>

                </x-ui.card>

            @endforeach

        </div>

    </section>

    <x-ui.card title="Sobre o projeto">

        <div class="stack">

            <h3>
                Representação de Interações Medicamentosas
                Utilizando Modelagem em Grafos
            </h3>

            <p>

                Este sistema foi desenvolvido como parte de um
                projeto acadêmico voltado à aplicação da
                teoria dos grafos na representação de
                interações medicamentosas.

            </p>

            <p>

                Os medicamentos são representados como vértices,
                enquanto as interações são representadas como
                arestas de um grafo não direcionado.

                A partir dessa estrutura, é possível visualizar
                relações e calcular métricas que descrevem
                características da rede de interações.

            </p>

        </div>

    </x-ui.card>

@endsection