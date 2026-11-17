@extends('layouts.app')

@section('title', 'Grafo de interações')

@section('container-class', 'container--fluid')

@section('content')

    @php
        $ids = $ids ?? null;

        $params = $ids !== null
            ? ['drug_ids' => $ids]
            : [];
    @endphp

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Análise',
            'href' => route('selection', $params),
        ],
        [
            'label' => 'Grafo',
        ],
    ]" />

    <x-layout.page-header
        title="Grafo de interações"
        description="Explore a representação gráfica da rede de interações medicamentosas."
        icon="network"
    />

    <x-domain.educational-notice />

    <div class="split">

        <x-domain.analysis-nav :ids="$ids" />

        <div class="cluster">

            <x-ui.badge :variant="$ids !== null
                ? 'primary'
                : 'neutral'">

                {{ $ids !== null
                    ? 'Rede selecionada'
                    : 'Rede completa' }}

            </x-ui.badge>

            <x-ui.button
                variant="secondary"
                :href="route('selection', array_merge(
                    $params,
                    ['mode' => 'graph']
                ))">

                Alterar seleção

            </x-ui.button>

        </div>

    </div>

    <x-ui.card>

        <x-slot:header>

            <div class="split">

                <div class="stack stack--sm">

                    <h2 class="card__title">
                        Rede de interações
                    </h2>

                    <p class="card__description">

                        {{ $graph->nodeCount() }} medicamento(s)
                        ·
                        {{ $graph->edgeCount() }} interação(ões)

                    </p>

                </div>

            </div>

        </x-slot:header>

        @if ($graph->nodeCount() === 0)

            <x-ui.empty-state
                title="Rede vazia"
                description="Não existem medicamentos para representar."
                icon="network"
            />

        @else

            <div class="stack">

                @if ($graph->edgeCount() === 0)

                    <x-ui.alert variant="info">

                        Não existem interações cadastradas entre
                        os medicamentos desta rede.

                        Os medicamentos serão representados
                        como vértices isolados.

                    </x-ui.alert>

                @endif

                <x-domain.graph 
                    id="main-graph" 
                    :elements="$elements" 
                />

            </div>

        @endif

    </x-ui.card>

    @if ($graph->nodeCount() > 0)

        <x-ui.card
            title="Detalhes do elemento selecionado"
            data-graph-details="main-graph">

            <div data-graph-details-content>

                <x-ui.empty-state
                    title="Nenhum elemento selecionado"
                    description="Selecione um vértice ou uma aresta para visualizar suas informações."
                    icon="info"
                />

            </div>

        </x-ui.card>

    @endif

    <x-ui.card title="Como interpretar o grafo">

        <div class="grid grid--3">

            <div class="stack stack--sm">

                <h3>Vértices</h3>

                <p class="text-muted">

                    Cada vértice representa um medicamento
                    pertencente à rede analisada.

                </p>

            </div>

            <div class="stack stack--sm">

                <h3>Arestas</h3>

                <p class="text-muted">

                    Cada aresta representa uma interação
                    cadastrada entre dois medicamentos.

                    A cor indica sua severidade.

                </p>

            </div>

            <div class="stack stack--sm">

                <h3>Vértices isolados</h3>

                <p class="text-muted">

                    Representam medicamentos sem interações
                    cadastradas com os demais medicamentos
                    da rede analisada.

                </p>

            </div>

        </div>

    </x-ui.card>

@endsection
