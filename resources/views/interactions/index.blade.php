@extends('layouts.app')

@section('title', 'Interações medicamentosas')

@section('content')

    <x-layout.breadcrumb :items="[
        ['label' => 'Interações'],
    ]" />

    <x-layout.page-header
        title="Interações medicamentosas"
        description="Consulte as interações entre medicamentos."
        icon="network">

        @auth

            <x-ui.button :href="route('interactions.create')">

                <x-ui.icon name="plus" size="sm" />

                Nova interação

            </x-ui.button>

        @endauth

    </x-layout.page-header>

    <x-domain.educational-notice />

    <div class="split">

        <x-domain.analysis-nav :ids="$ids" />

        <x-ui.button
            variant="secondary"
            :href="route('selection', $ids !== null
                ? ['drug_ids' => $ids]
                : [])">

            Alterar seleção

        </x-ui.button>

    </div>

    <x-ui.card :flush="true">

        <x-slot:header>

            <div class="split">

                <div class="stack stack--sm">

                    <h2 class="card__title">

                        {{ $ids !== null
                            ? 'Interações selecionadas'
                            : 'Interações cadastradas' }}

                    </h2>

                    <p class="card__description">

                        {{ $interactions->count() }}
                        interação(ões) encontrada(s).

                    </p>

                </div>

                <x-ui.badge :variant="$ids !== null
                    ? 'primary'
                    : 'neutral'">

                    {{ $ids !== null
                        ? 'Rede selecionada'
                        : 'Rede completa' }}

                </x-ui.badge>

            </div>

        </x-slot:header>

        @if ($interactions->isEmpty())

            <x-ui.empty-state
                title="Nenhuma interação encontrada"
                :description="$ids !== null
                    ? 'Não existem interações cadastradas entre os medicamentos selecionados.'
                    : 'Ainda não existem interações cadastradas na base de dados.'"
                icon="network">

                @if ($ids !== null)

                    <x-ui.button
                        variant="secondary"
                        :href="route('interactions.index')">

                        Visualizar todas as interações

                    </x-ui.button>

                @else

                    @auth

                        <x-ui.button
                            :href="route('interactions.create')">

                            Cadastrar interação

                        </x-ui.button>

                    @endauth

                @endif

            </x-ui.empty-state>

        @else

            <x-ui.table>

                <x-slot:head>

                    <tr>
                        <th scope="col">Medicamento A</th>
                        <th scope="col">Medicamento B</th>
                        <th scope="col">Severidade</th>
                        <th scope="col" class="text-right">Ações</th>
                    </tr>

                </x-slot:head>

                @foreach ($interactions as $interaction)

                    @php
                        $params = [
                            'drugA' => $interaction->drugA_id,
                            'drugB' => $interaction->drugB_id,
                        ];
                    @endphp

                    <tr>

                        <td class="font-medium">

                            <a href="{{ route(
                                'drugs.show',
                                $interaction->drugA_id
                            ) }}">

                                {{ $interaction->drugA->name }}

                            </a>

                        </td>

                        <td class="font-medium">

                            <a href="{{ route(
                                'drugs.show',
                                $interaction->drugB_id
                            ) }}">

                                {{ $interaction->drugB->name }}

                            </a>

                        </td>

                        <td>

                            <x-domain.severity
                                :severity="$interaction->severity"
                            />

                        </td>

                        <td>

                            <div class="table__actions">

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route(
                                        'interactions.show',
                                        $params
                                    )"
                                    title="Visualizar interação"
                                    aria-label="Visualizar interação">

                                    <x-ui.icon name="eye" size="sm" />

                                </x-ui.button>

                                @auth

                                    <x-ui.button
                                        variant="ghost"
                                        size="sm"
                                        :href="route(
                                            'interactions.edit',
                                            $params
                                        )"
                                        title="Editar interação"
                                        aria-label="Editar interação">

                                        <x-ui.icon
                                            name="pencil"
                                            size="sm"
                                        />

                                    </x-ui.button>

                                @endauth

                            </div>

                        </td>

                    </tr>

                @endforeach

            </x-ui.table>

        @endif

    </x-ui.card>

@endsection
