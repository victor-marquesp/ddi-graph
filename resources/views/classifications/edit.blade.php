@extends('layouts.app')

@section('title', 'Editar classificação')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Classificações',
            'href' => route('classifications.index'),
        ],
        [
            'label' => $classification->name,
            'href' => route(
                'classifications.show',
                $classification
            ),
        ],
        [
            'label' => 'Editar',
        ],
    ]" />

    <x-layout.page-header
        title="Editar classificação"
        description="Atualize as informações da classificação terapêutica."
        icon="pencil"
    />

    <x-ui.card title="Dados da classificação">

        <form
            method="POST"
            action="{{ route(
                'classifications.update',
                $classification
            ) }}"
            class="form">

            @csrf
            @method('PUT')

            @include('classifications._form')

            <div class="form__actions">

                <x-ui.button
                    variant="secondary"
                    :href="route(
                        'classifications.show',
                        $classification
                    )">

                    Cancelar

                </x-ui.button>

                <x-ui.button type="submit">

                    Salvar alterações

                </x-ui.button>

            </div>

        </form>

    </x-ui.card>

@endsection
