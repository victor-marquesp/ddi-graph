@extends('layouts.app')

@section('title', 'Dashboard de métricas')

@section('content')

    @php
        $ids = $ids ?? null;

        $params = $ids !== null
            ? ['drug_ids' => $ids]
            : [];

        $graphRoute = $ids !== null
            ? 'graph.selected'
            : 'graph.all';

        $maximumDegree = $result->maximumDegree['degree'];

        $maximumDegreeNodes = $result->maximumDegree['nodeIds'];

        $severePercentage = $result->edgeCount > 0
            ? ($result->severeInteractions / $result->edgeCount) * 100
            : null;

        $severityPercentage = $result->averageEdgeSeverity !== null
            ? ($result->averageEdgeSeverity / 4) * 100
            : null;
    @endphp

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Análise',
            'href' => route('selection', $params),
        ],
        [
            'label' => 'Métricas',
        ],
    ]" />

    <x-layout.page-header
        title="Dashboard de métricas"
        description="Indicadores quantitativos da rede de interações medicamentosas."
        icon="chart-no-axes-column"
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
                    ['mode' => 'metrics']
                ))">

                Alterar seleção

            </x-ui.button>

        </div>

    </div>

    @if ($result->nodeCount === 0)

        <x-ui.alert variant="info">

            A rede analisada não possui medicamentos.
            Algumas métricas não se aplicam a uma rede vazia.

        </x-ui.alert>

    @endif

    {{-- Estrutura da rede --}}

    <section class="metrics-section">

        <div class="metrics-section__header">

            <h2>Estrutura da rede</h2>

            <p class="metrics-section__description">
                Indicadores gerais sobre a composição do grafo.
            </p>

        </div>

        <div class="grid grid--3">

            <x-domain.metric-card
                label="Medicamentos"
                :value="$result->nodeCount"
                description="Quantidade de vértices da rede."
                icon="pill"
            />

            <x-domain.metric-card
                label="Interações"
                :value="$result->edgeCount"
                description="Quantidade de arestas da rede."
                icon="network"
            />

            <x-domain.metric-card
                label="Componentes conectados"
                :value="$result->connectedComponents"
                description="Quantidade de grupos de vértices mutuamente alcançáveis."
                icon="layers"
            />

        </div>

    </section>

    {{-- Conectividade --}}

    <section class="metrics-section">

        <div class="metrics-section__header">

            <h2>Conectividade</h2>

            <p class="metrics-section__description">

                Indicadores sobre a distribuição e a
                quantidade de conexões entre os medicamentos.

            </p>

        </div>

        <div class="grid grid--3">

            <x-domain.metric-card
                label="Grau médio"
                :value="$result->nodeCount > 0
                    ? number_format($result->averageDegree, 2, ',', '.')
                    : 'Não se aplica'"
                description="Número médio de interações por medicamento."
            />

            <x-domain.metric-card
                label="Grau máximo"
                :value="$maximumDegree ?? 'Não se aplica'"
                description="Maior número de interações de um medicamento na rede."
            />

            <x-domain.metric-card
                label="Densidade"
                :value="$result->nodeCount > 1
                    ? number_format($result->density * 100, 2, ',', '.')
                    : 'Não se aplica'"
                :unit="$result->nodeCount > 1 ? '%' : null"
                description="Proporção entre as interações existentes e as possíveis."
            />

        </div>

    </section>

    {{-- Severidade --}}

    <section class="metrics-section">

        <div class="metrics-section__header">

            <h2>Severidade das interações</h2>

            <p class="metrics-section__description">

                Indicadores relacionados à severidade
                das interações cadastradas na rede analisada.

            </p>

        </div>

        <div class="grid grid--2">

            <x-domain.metric-card
                label="Severidade média"
                :value="$result->averageEdgeSeverity !== null
                    ? number_format($result->averageEdgeSeverity, 2, ',', '.')
                    : 'Não se aplica'"
                :unit="$result->averageEdgeSeverity !== null
                    ? '/ 4'
                    : null"
                description="Média aritmética dos pesos de severidade."
                icon="triangle-alert">

                @if ($severityPercentage !== null)

                    <div
                        class="metric-progress"
                        role="meter"
                        aria-label="Severidade média"
                        aria-valuemin="0"
                        aria-valuemax="4"
                        aria-valuenow="{{ $result->averageEdgeSeverity }}">

                        <div
                            class="metric-progress__fill"
                            style="width: {{ $severityPercentage }}%">
                        </div>

                    </div>

                @endif

            </x-domain.metric-card>

            <x-domain.metric-card
                label="Interações graves"
                :value="$result->severeInteractions"
                :unit="'/ ' . $result->edgeCount"
                description="Interações classificadas como graves ou contraindicadas."
                icon="triangle-alert">

                @if ($severePercentage !== null)

                    <div class="stack stack--sm">

                        <div
                            class="metric-progress"
                            role="meter"
                            aria-label="Proporção de interações graves"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-valuenow="{{ $severePercentage }}">

                            <div
                                class="metric-progress__fill metric-progress__fill--danger"
                                style="width: {{ $severePercentage }}%">
                            </div>

                        </div>

                        <span class="text-muted text-xs">

                            {{ number_format(
                                $severePercentage, 2, ',', '.'
                            ) }}% das interações da rede.

                        </span>

                    </div>

                @endif

            </x-domain.metric-card>

        </div>

        <x-ui.card title="Escala de severidade">

            <div class="grid grid--4">

                @foreach ([
                    ['severity' => 'minor', 'weight' => 1],
                    ['severity' => 'moderate', 'weight' => 2],
                    ['severity' => 'major', 'weight' => 3],
                    ['severity' => 'contraindicated', 'weight' => 4],
                ] as $level)

                    <div class="cluster">

                        <x-domain.severity
                            :severity="$level['severity']"
                        />

                        <span class="text-muted">
                            Peso {{ $level['weight'] }}
                        </span>

                    </div>

                @endforeach

            </div>

        </x-ui.card>

        <p class="text-muted text-sm">

            A severidade média representa um indicador descritivo
            da rede e não constitui uma avaliação de risco clínico.

        </p>

    </section>

    {{-- Medicamentos com maior grau --}}

    <x-ui.card
        title="Medicamentos com maior grau"
        description="Medicamentos com o maior número de interações na rede analisada."
        :flush="true">

        @if (empty($maximumDegreeNodes))

            <x-ui.empty-state
                title="Nenhum medicamento identificado"
                description="Não existem vértices disponíveis para esta métrica."
                icon="pill"
            />

        @else

            <x-ui.table>

                <x-slot:head>

                    <tr>
                        <th scope="col">Medicamento</th>
                        <th scope="col">Classificação</th>
                        <th scope="col">Grau</th>
                        <th scope="col" class="text-right">Ações</th>
                    </tr>

                </x-slot:head>

                @foreach ($maximumDegreeNodes as $nodeId)

                    @php
                        $node = $graph->getNode($nodeId);

                        $name = $node->properties['name']
                    @endphp

                    <tr>

                        <td class="font-medium">
                            {{ $name }}
                        </td>

                        <td>
                            {{ $node->classification->name }}
                        </td>

                        <td class="tabular-nums">
                            {{ $maximumDegree }}
                        </td>

                        <td>

                            <div class="table__actions">

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route('drugs.show', $node->id)"
                                    aria-label="Visualizar medicamento"
                                    title="Visualizar medicamento">

                                    <x-ui.icon name="eye" size="sm" />

                                </x-ui.button>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </x-ui.table>

        @endif

    </x-ui.card>

    {{-- Pré-visualização do grafo --}}

    <x-ui.card>

        <x-slot:header>

            <div class="split">

                <div class="stack stack--sm">

                    <h2 class="card__title">
                        Visualização da rede
                    </h2>

                    <p class="card__description">
                        Representação gráfica da rede analisada.
                    </p>

                </div>

                <x-ui.button
                    variant="secondary"
                    :href="route($graphRoute, $params)">

                    Abrir grafo

                    <x-ui.icon name="arrow-right" size="sm" />

                </x-ui.button>

            </div>

        </x-slot:header>

        @if ($result->nodeCount === 0)

            <x-ui.empty-state
                title="Rede vazia"
                description="Não existem medicamentos para representar."
                icon="network"
            />

        @else

            <x-domain.graph
                id="dashboard-graph"
                :elements="$elements"
                :preview="true"
                :controls="false"
            />

        @endif

    </x-ui.card>

@endsection
