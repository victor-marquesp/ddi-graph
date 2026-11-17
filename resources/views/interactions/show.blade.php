@extends('layouts.app')

@section('title', 'Detalhes da interação')

@section('content')

    @php
        $params = [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id,
        ];

        $drugIds = [
            $interaction->drugA_id,
            $interaction->drugB_id,
        ];

        $interactionName = $interaction->drugA->name
            . ' e '
            . $interaction->drugB->name;
    @endphp

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Interações',
            'href' => route('interactions.index'),
        ],
        [
            'label' => $interactionName,
        ],
    ]" />

    <x-layout.page-header
        title="Detalhes da interação"
        :description="$interactionName"
        icon="network">

        @auth

            <x-ui.button
                variant="secondary"
                :href="route('interactions.edit', $params)">

                <x-ui.icon name="pencil" size="sm" />

                Editar

            </x-ui.button>

            <x-ui.button
                variant="danger"
                data-modal-open="delete-interaction">

                <x-ui.icon name="trash-2" size="sm" />

                Excluir

            </x-ui.button>

        @endauth

    </x-layout.page-header>

    <x-domain.educational-notice />

    <x-ui.card title="Informações da interação">

        <x-ui.detail-list :columns="2">

            <x-ui.detail-item label="Medicamento A">

                <a href="{{ route(
                    'drugs.show',
                    $interaction->drugA_id
                ) }}">

                    {{ $interaction->drugA->name }}

                </a>

            </x-ui.detail-item>

            <x-ui.detail-item label="Medicamento B">

                <a href="{{ route(
                    'drugs.show',
                    $interaction->drugB_id
                ) }}">

                    {{ $interaction->drugB->name }}

                </a>

            </x-ui.detail-item>

            <x-ui.detail-item
                label="Severidade"
                :full="true">

                <x-domain.severity
                    :severity="$interaction->severity"
                />

            </x-ui.detail-item>

            <x-ui.detail-item
                label="Descrição"
                :value="$interaction->description"
                :full="true"
            />

            <x-ui.detail-item
                label="Data de cadastro"
                :value="$interaction->created_at?->format('d/m/Y')"
            />

            <x-ui.detail-item
                label="Última atualização"
                :value="$interaction->updated_at?->format('d/m/Y')"
            />

        </x-ui.detail-list>

    </x-ui.card>

    <x-ui.card title="Representação em grafo">

        <div class="stack">

            <p class="text-muted">

                Visualize os medicamentos associados a esta
                interação como vértices de um grafo, conectados
                por uma aresta que representa a interação.

            </p>

            <div class="cluster">

                <x-ui.button :href="route('graph.selected', [
                    'drug_ids' => $drugIds,
                ])">

                    <x-ui.icon name="network" size="sm" />

                    Visualizar grafo

                </x-ui.button>

                <x-ui.button
                    variant="secondary"
                    :href="route('selection', [
                        'drug_ids' => $drugIds,
                    ])">

                    Ampliar análise

                </x-ui.button>

            </div>

        </div>

    </x-ui.card>

    <div class="cluster">

        <x-ui.button
            variant="ghost"
            :href="route('interactions.index')">

            <x-ui.icon name="arrow-left" size="sm" />

            Voltar para interações

        </x-ui.button>

    </div>

    @auth

        <x-ui.modal
            id="delete-interaction"
            title="Excluir interação">

            <div class="stack">

                <p>

                    Tem certeza de que deseja excluir a interação
                    entre
                    <strong>{{ $interaction->drugA->name }}</strong>
                    e
                    <strong>{{ $interaction->drugB->name }}</strong>?

                </p>

                <p class="text-muted">

                    Os medicamentos associados não serão excluídos.
                    Essa ação não poderá ser desfeita.

                </p>

            </div>

            <x-slot:footer>

                <x-ui.button
                    variant="secondary"
                    data-modal-close
                    autofocus>

                    Cancelar

                </x-ui.button>

                <form
                    method="POST"
                    action="{{ route(
                        'interactions.destroy',
                        $params
                    ) }}">

                    @csrf
                    @method('DELETE')

                    <x-ui.button
                        variant="danger"
                        type="submit">

                        Confirmar exclusão

                    </x-ui.button>

                </form>

            </x-slot:footer>

        </x-ui.modal>

    @endauth

@endsection
