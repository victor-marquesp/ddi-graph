@extends('layouts.app')

@section('title', 'Entrar')
@section('container-class', 'container--auth')
@section('hide-navbar', 'true')
@section('hide-footer', 'true')

@section('content')

    <div class="auth">

        <div class="auth__brand">

            <div class="auth__icon">
                <x-ui.icon name="network" size="xl" />
            </div>

            <h1 class="auth__title">
                {{ config('app.name') }}
            </h1>

            <p class="auth__description">
                Área administrativa
            </p>

        </div>

        <x-ui.card
            title="Entrar"
            description="Informe suas credenciais para acessar o sistema.">

            <form
                method="POST"
                action="{{ route('auth.login') }}"
                class="form">

                @csrf

                <x-form.input
                    name="email"
                    label="E-mail"
                    type="email"
                    placeholder="usuario@example.com"
                    autocomplete="username"
                    :required="true"
                    autofocus
                />

                <x-form.input
                    name="password"
                    label="Senha"
                    type="password"
                    placeholder="Informe sua senha"
                    autocomplete="current-password"
                    :required="true"
                />

                <div class="stack stack--sm">

                    <label class="auth__checkbox">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                        >

                        Lembrar-me

                    </label>

                    @error('remember')

                        <p class="field__error">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                <x-ui.button type="submit" :block="true">

                    <x-ui.icon name="log-in" size="sm" />

                    Entrar

                </x-ui.button>

            </form>

        </x-ui.card>

        <div class="auth__footer">

            <a href="{{ route('welcome') }}">

                <x-ui.icon name="arrow-left" size="sm" />

                Voltar para o início

            </a>

        </div>

        <p class="text-muted text-xs text-center">
            Acesso restrito a usuários autorizados.
        </p>

    </div>

@endsection
