@extends('layouts.app')

@section('title', $user->name)

@section('content')

    @php
        $isCurrentUser = auth()->id() === $user->id;
    @endphp

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Usuários',
            'href' => route('users.index'),
        ],
        [
            'label' => $user->name,
        ],
    ]" />

    <x-layout.page-header
        :title="$user->name"
        description="Informações sobre o usuário."
        icon="users">

        <x-ui.button
            variant="secondary"
            :href="route('users.edit', $user)">

            <x-ui.icon name="pencil" size="sm" />

            Editar

        </x-ui.button>

        <x-ui.button
            variant="danger"
            :disabled="$isLastUser"
            data-modal-open="delete-user">

            <x-ui.icon name="trash-2" size="sm" />

            Excluir

        </x-ui.button>

    </x-layout.page-header>

    @if ($isCurrentUser)

        <x-ui.alert variant="info">

            Esta é a sua conta de usuário.

        </x-ui.alert>

    @endif

    @if ($isLastUser)

        <x-ui.alert variant="warning">

            Este usuário não pode ser excluído, pois o sistema
            deve possuir pelo menos um usuário cadastrado.

        </x-ui.alert>

    @endif

    <x-ui.card title="Informações gerais">

        <x-ui.detail-list :columns="2">

            <x-ui.detail-item
                label="Nome"
                :value="$user->name"
            />

            <x-ui.detail-item
                label="E-mail"
                :value="$user->email"
            />

            <x-ui.detail-item
                label="Data de cadastro"
                :value="$user->created_at?->format('d/m/Y')"
            />

            <x-ui.detail-item
                label="Última atualização"
                :value="$user->updated_at?->format('d/m/Y')"
            />

        </x-ui.detail-list>

    </x-ui.card>

    <div class="cluster">

        <x-ui.button
            variant="ghost"
            :href="route('users.index')">

            <x-ui.icon name="arrow-left" size="sm" />

            Voltar para usuários

        </x-ui.button>

    </div>

    @unless ($isLastUser)

        <x-ui.modal id="delete-user" title="Excluir usuário">

            <div class="stack">

                <p>
                    Tem certeza de que deseja excluir
                    <strong>{{ $user->name }}</strong>?
                </p>

                @if ($isCurrentUser)

                    <x-ui.alert variant="warning">

                        Você está excluindo sua própria conta.
                        Sua sessão será encerrada e você perderá
                        o acesso administrativo ao sistema.

                    </x-ui.alert>

                @endif

                <p class="text-muted">
                    Essa ação não poderá ser desfeita.
                </p>

            </div>

            <x-slot:footer>

                <x-ui.button
                    variant="secondary"
                    data-modal-close
                    autofocus>

                    Cancelar

                </x-ui.button>

                <form
                    method="POST"
                    action="{{ route('users.destroy', $user) }}">

                    @csrf
                    @method('DELETE')

                    <x-ui.button
                        variant="danger"
                        type="submit">

                        Confirmar exclusão

                    </x-ui.button>

                </form>

            </x-slot:footer>

        </x-ui.modal>

    @endunless

@endsection
