@extends('layouts.app')

@section('title', 'Cadastrar interação')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Interações',
            'href' => route('interactions.index'),
        ],
        [
            'label' => 'Cadastrar',
        ],
    ]" />

    <x-layout.page-header
        title="Cadastrar interação"
        description="Registre uma interação entre dois medicamentos."
        icon="network"
    />

    <x-ui.card title="Dados da interação">

        @if ($drugs->count() < 2)

            <div class="stack">

                <x-ui.alert variant="warning">

                    É necessário possuir pelo menos dois
                    medicamentos cadastrados para registrar
                    uma interação.

                </x-ui.alert>

                <div class="cluster">

                    <x-ui.button :href="route('drugs.create')">

                        Cadastrar medicamento

                    </x-ui.button>

                    <x-ui.button
                        variant="secondary"
                        :href="route('interactions.index')">

                        Voltar

                    </x-ui.button>

                </div>

            </div>

        @else

            <form
                method="POST"
                action="{{ route('interactions.store') }}"
                class="form">

                @csrf

                @include('interactions._form')

                <div class="form__actions">

                    <x-ui.button
                        variant="secondary"
                        :href="route('interactions.index')">

                        Cancelar

                    </x-ui.button>

                    <x-ui.button type="submit">

                        Cadastrar interação

                    </x-ui.button>

                </div>

            </form>

        @endif

    </x-ui.card>

@endsection
