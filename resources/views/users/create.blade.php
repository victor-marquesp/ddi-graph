@extends('layouts.app')

@section('title', 'Cadastrar usuário')
@section('container-class', 'container--form')

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Usuários',
            'href' => route('users.index'),
        ],
        [
            'label' => 'Cadastrar',
        ],
    ]" />

    <x-layout.page-header
        title="Cadastrar usuário"
        description="Adicione um usuário com acesso administrativo."
        icon="users"
    />

    <x-ui.card title="Dados do usuário">

        <form
            method="POST"
            action="{{ route('users.store') }}"
            class="form">

            @csrf

            @include('users._form')

            <div class="form__actions">

                <x-ui.button
                    variant="secondary"
                    :href="route('users.index')">

                    Cancelar

                </x-ui.button>

                <x-ui.button type="submit">

                    Cadastrar usuário

                </x-ui.button>

            </div>

        </form>

    </x-ui.card>

@endsection
