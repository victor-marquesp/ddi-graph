@extends('layouts.app')

@section('title', 'Editar interação')
@section('container-class', 'container--form')

@section('content')

    @php
        $params = [
            'drugA' => $interaction->drugA_id,
            'drugB' => $interaction->drugB_id,
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
            'href' => route('interactions.show', $params),
        ],
        [
            'label' => 'Editar',
        ],
    ]" />

    <x-layout.page-header
        title="Editar interação"
        description="Atualize as informações da interação medicamentosa."
        icon="pencil"
    />

    <x-ui.card title="Dados da interação">

        <form
            method="POST"
            action="{{ route(
                'interactions.update',
                $params
            ) }}"
            class="form">

            @csrf
            @method('PUT')

            @include('interactions._form')

            <div class="form__actions">

                <x-ui.button
                    variant="secondary"
                    :href="route(
                        'interactions.show',
                        $params
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
