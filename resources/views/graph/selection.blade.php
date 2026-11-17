@extends('layouts.app')

@section('title', 'Análise de interações')

@section('content')

    @php
        $representations = [
            [
                'mode' => 'table',
                'label' => 'Visualizar tabela',
                'icon' => 'table',
                'all' => 'interactions.index',
                'selected' => 'interactions.index',
            ],
            [
                'mode' => 'graph',
                'label' => 'Visualizar grafo',
                'icon' => 'network',
                'all' => 'graph.all',
                'selected' => 'graph.selected',
            ],
            [
                'mode' => 'metrics',
                'label' => 'Analisar métricas',
                'icon' => 'chart-no-axes-column',
                'all' => 'metrics.all',
                'selected' => 'metrics.selected',
            ],
        ];
    @endphp

    <x-layout.breadcrumb :items="[
        ['label' => 'Análise'],
    ]" />

    <x-layout.page-header
        title="Análise de interações"
        description="Defina os medicamentos que deseja analisar e escolha uma forma de representação."
        icon="network"
    />

    @if ($drugs->isEmpty())

        <x-ui.card>

            <x-ui.empty-state
                title="Nenhum medicamento disponível"
                description="É necessário possuir medicamentos cadastrados para realizar uma análise."
                icon="pill">

                @auth

                    <x-ui.button :href="route('drugs.create')">

                        Cadastrar medicamento

                    </x-ui.button>

                @endauth

            </x-ui.empty-state>

        </x-ui.card>

    @else

        <x-ui.card
            title="Analisar rede completa"
            description="Utilize todos os medicamentos e interações cadastrados na base de dados.">

            <div class="cluster">

                @foreach ($representations as $representation)

                    <x-ui.button
                        :variant="$mode === $representation['mode']
                            ? 'primary'
                            : 'secondary'"
                        :href="route($representation['all'])">

                        <x-ui.icon
                            :name="$representation['icon']"
                            size="sm"
                        />

                        {{ $representation['label'] }}

                    </x-ui.button>

                @endforeach

            </div>

        </x-ui.card>

        <x-ui.card
            title="Analisar rede selecionada"
            description="Selecione os medicamentos que farão parte da rede analisada.">

            <form
                method="GET"
                action="{{ route('graph.selected') }}"
                class="form"
                data-selection-form>

                <x-domain.drug-selector
                    :drugs="$drugs"
                    :selected="$selected"
                />

                <div class="form__actions">

                    @foreach ($representations as $representation)

                        <x-ui.button
                            type="submit"
                            :variant="$mode === $representation['mode']
                                ? 'primary'
                                : 'secondary'"
                            :formaction="route(
                                $representation['selected']
                            )"
                            :disabled="true"
                            data-selection-submit>

                            <x-ui.icon
                                :name="$representation['icon']"
                                size="sm"
                            />

                            {{ $representation['label'] }}

                        </x-ui.button>

                    @endforeach

                </div>

            </form>

        </x-ui.card>

    @endif

    <x-ui.card title="Formas de representação">

        <div class="grid grid--3">

            <div class="stack stack--sm">

                <span class="cluster text-primary">

                    <x-ui.icon name="table" />

                    <h3>Tabular</h3>

                </span>

                <p class="text-muted">

                    Apresenta as interações em uma tabela,
                    identificando os medicamentos associados
                    e os respectivos níveis de severidade.

                </p>

            </div>

            <div class="stack stack--sm">

                <span class="cluster text-primary">

                    <x-ui.icon name="network" />

                    <h3>Grafo</h3>

                </span>

                <p class="text-muted">

                    Representa os medicamentos como vértices
                    e suas interações como arestas,
                    permitindo explorar a estrutura da rede.

                </p>

            </div>

            <div class="stack stack--sm">

                <span class="cluster text-primary">

                    <x-ui.icon name="chart-no-axes-column" />

                    <h3>Métricas</h3>

                </span>

                <p class="text-muted">

                    Apresenta indicadores quantitativos sobre
                    a estrutura da rede e a severidade
                    das interações cadastradas.

                </p>

            </div>

        </div>

    </x-ui.card>

@endsection
