@extends('layouts.app')

@section('title', 'Cadastrar classificação')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Classificações',
            'href' => route('classifications.index'),
        ],
        [
            'label' => 'Cadastrar',
        ],
    ]" />

    <x-layout.page-header
        title="Cadastrar classificação"
        description="Adicione uma nova classificação terapêutica."
        icon="layers"
    />

    <x-ui.card title="Dados da classificação">

        <form
            method="POST"
            action="{{ route('classifications.store') }}"
            class="form">

            @csrf

            @include('classifications._form')

            <div class="form__actions">

                <x-ui.button
                    variant="secondary"
                    :href="route('classifications.index')">

                    Cancelar

                </x-ui.button>

                <x-ui.button type="submit">

                    Cadastrar classificação

                </x-ui.button>

            </div>

        </form>

    </x-ui.card>

@endsection
