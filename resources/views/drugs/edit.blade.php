@extends('layouts.app')

@section('title', 'Editar medicamento')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Medicamentos',
            'href' => route('drugs.index'),
        ],
        [
            'label' => $drug->name,
            'href' => route('drugs.show', $drug),
        ],
        [
            'label' => 'Editar',
        ],
    ]" />

    <x-layout.page-header
        title="Editar medicamento"
        :description="'Atualize as informações de ' . $drug->name . '.'"
        icon="pencil"
    />

    <x-ui.card title="Dados do medicamento">

        <form
            method="POST"
            action="{{ route('drugs.update', $drug) }}"
            class="form">

            @csrf
            @method('PUT')

            @include('drugs._form')

            <div class="form__actions">

                <x-ui.button
                    variant="secondary"
                    :href="route('drugs.show', $drug)">

                    Cancelar

                </x-ui.button>

                <x-ui.button type="submit">

                    Salvar alterações

                </x-ui.button>

            </div>

        </form>

    </x-ui.card>

@endsection
