@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')

    <x-layout.breadcrumb :items="[
        ['label' => 'Medicamentos'],
    ]" />

    <x-layout.page-header
        title="Medicamentos"
        description="Consulte os medicamentos cadastrados no sistema."
        icon="pill">

        @auth

            <x-ui.button :href="route('drugs.create')">

                <x-ui.icon name="plus" size="sm" />

                Novo medicamento

            </x-ui.button>

        @endauth

    </x-layout.page-header>

    <x-domain.educational-notice />

    <x-ui.card
        title="Medicamentos cadastrados"
        :description="$drugs->count() . ' medicamento(s) encontrado(s).'"
        :flush="true">

        @if ($drugs->isEmpty())

            <x-ui.empty-state
                title="Nenhum medicamento cadastrado"
                description="Ainda não existem medicamentos na base de dados."
                icon="pill">

                @auth

                    <x-ui.button :href="route('drugs.create')">
                        Cadastrar medicamento
                    </x-ui.button>

                @endauth

            </x-ui.empty-state>

        @else

            <x-ui.table>

                <x-slot:head>

                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Classificação</th>
                        <th scope="col" class="text-right">Ações</th>
                    </tr>

                </x-slot:head>

                @foreach ($drugs as $drug)

                    <tr>

                        <td class="font-medium">
                            {{ $drug->name }}
                        </td>

                        <td>

                            <a href="{{ route(
                                'classifications.show',
                                $drug->classification_id
                            ) }}">
                                {{ $drug->classification->name }}
                            </a>

                        </td>

                        <td>

                            <div class="table__actions">

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route('drugs.show', $drug)"
                                    title="Visualizar medicamento"
                                    aria-label="Visualizar medicamento">

                                    <x-ui.icon name="eye" size="sm" />

                                </x-ui.button>

                                @auth

                                    <x-ui.button
                                        variant="ghost"
                                        size="sm"
                                        :href="route('drugs.edit', $drug)"
                                        title="Editar medicamento"
                                        aria-label="Editar medicamento">

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
