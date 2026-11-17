@extends('layouts.app')

@section('title', 'Editar usuário')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Usuários',
            'href' => route('users.index'),
        ],
        [
            'label' => $user->name,
            'href' => route('users.show', $user),
        ],
        [
            'label' => 'Editar',
        ],
    ]" />

    <x-layout.page-header
        title="Editar usuário"
        description="Atualize as informações do usuário."
        icon="pencil"
    />

    <x-ui.card title="Dados do usuário">

        <form
            method="POST"
            action="{{ route('users.update', $user) }}"
            class="form">

            @csrf
            @method('PUT')

            @include('users._form')

            <div class="form__actions">

                <x-ui.button
                    variant="secondary"
                    :href="route('users.show', $user)">

                    Cancelar

                </x-ui.button>

                <x-ui.button type="submit">

                    Salvar alterações

                </x-ui.button>

            </div>

        </form>

    </x-ui.card>

@endsection
