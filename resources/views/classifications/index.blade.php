@extends('layouts.app')

@section('title', 'Classificações')

@section('content')

    <x-layout.breadcrumb :items="[
        ['label' => 'Classificações'],
    ]" />

    <x-layout.page-header
        title="Classificações"
        description="Consulte as classificações terapêuticas cadastradas."
        icon="layers">

        @auth

            <x-ui.button :href="route('classifications.create')">

                <x-ui.icon name="plus" size="sm" />

                Nova classificação

            </x-ui.button>

        @endauth

    </x-layout.page-header>

    <x-ui.card
        title="Classificações cadastradas"
        :description="$classifications->count() . ' classificação(ões) encontrada(s).'"
        :flush="true">

        @if ($classifications->isEmpty())

            <x-ui.empty-state
                title="Nenhuma classificação cadastrada"
                description="Ainda não existem classificações terapêuticas na base de dados."
                icon="layers">

                @auth

                    <x-ui.button
                        :href="route('classifications.create')">

                        Cadastrar classificação

                    </x-ui.button>

                @endauth

            </x-ui.empty-state>

        @else

            <x-ui.table>

                <x-slot:head>

                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col" class="text-right">Ações</th>
                    </tr>

                </x-slot:head>

                @foreach ($classifications as $classification)

                    <tr>

                        <td class="font-medium">
                            {{ $classification->name }}
                        </td>

                        <td class="text-muted">

                            {{ $classification->description
                                ? \Illuminate\Support\Str::limit(
                                    $classification->description,
                                    100
                                )
                                : 'Não informada' }}

                        </td>

                        <td>

                            <div class="table__actions">

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route(
                                        'classifications.show',
                                        $classification
                                    )"
                                    title="Visualizar classificação"
                                    aria-label="Visualizar classificação">

                                    <x-ui.icon name="eye" size="sm" />

                                </x-ui.button>

                                @auth

                                    <x-ui.button
                                        variant="ghost"
                                        size="sm"
                                        :href="route(
                                            'classifications.edit',
                                            $classification
                                        )"
                                        title="Editar classificação"
                                        aria-label="Editar classificação">

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
