@extends('layouts.app')

@section('title', 'Cadastrar medicamento')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Medicamentos',
            'href' => route('drugs.index'),
        ],
        [
            'label' => 'Cadastrar',
        ],
    ]" />

    <x-layout.page-header
        title="Cadastrar medicamento"
        description="Adicione um novo medicamento à base de dados."
        icon="pill"
    />

    <x-ui.card title="Dados do medicamento">

        @if ($classifications->isEmpty())

            <div class="stack">

                <x-ui.alert variant="warning">

                    É necessário cadastrar pelo menos uma
                    classificação terapêutica antes de
                    cadastrar um medicamento.

                </x-ui.alert>

                <div class="cluster">

                    <x-ui.button
                        :href="route('classifications.create')">

                        Cadastrar classificação

                    </x-ui.button>

                    <x-ui.button
                        variant="secondary"
                        :href="route('drugs.index')">

                        Voltar

                    </x-ui.button>

                </div>

            </div>

        @else

            <form
                method="POST"
                action="{{ route('drugs.store') }}"
                class="form">

                @csrf

                @include('drugs._form')

                <div class="form__actions">

                    <x-ui.button
                        variant="secondary"
                        :href="route('drugs.index')">

                        Cancelar

                    </x-ui.button>

                    <x-ui.button type="submit">

                        Cadastrar medicamento

                    </x-ui.button>

                </div>

            </form>

        @endif

    </x-ui.card>

@endsection
