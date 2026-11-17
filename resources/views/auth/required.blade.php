@extends('layouts.app')

@section('title', 'Autenticação necessária')
@section('container-class', 'container--auth')
@section('hide-navbar', 'true')
@section('hide-footer', 'true')

@section('content')

    <div class="auth">

        <x-ui.card>

            <div class="stack stack--lg">

                <div class="auth__brand">

                    <div class="auth__icon">

                        <x-ui.icon name="lock" size="xl" />

                    </div>

                    <h1 class="auth__title">
                        Autenticação necessária
                    </h1>

                    <p class="auth__description">

                        Você precisa estar autenticado para
                        acessar esta área do sistema. Esta
                        funcionalidade é restrita a usuários
                        autorizados.

                    </p>

                </div>

                <div class="stack">

                    <x-ui.button
                        :href="route('auth.login.form')"
                        :block="true">

                        <x-ui.icon name="log-in" size="sm" />

                        Entrar no sistema

                    </x-ui.button>

                    <x-ui.button
                        variant="secondary"
                        :href="route('welcome')"
                        :block="true">

                        Voltar para o início

                    </x-ui.button>

                </div>

            </div>

        </x-ui.card>

        <div class="auth__brand">

            <span class="cluster text-muted">

                <x-ui.icon name="network" />

                {{ config('app.name') }}

            </span>

        </div>

    </div>

@endsection
