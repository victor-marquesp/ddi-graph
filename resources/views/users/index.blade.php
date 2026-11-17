@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

    <x-layout.breadcrumb :items="[
        ['label' => 'Usuários'],
    ]" />

    <x-layout.page-header
        title="Usuários"
        description="Gerencie os usuários com acesso administrativo."
        icon="users">

        <x-ui.button :href="route('users.create')">

            <x-ui.icon name="plus" size="sm" />

            Novo usuário

        </x-ui.button>

    </x-layout.page-header>

    <x-ui.card
        title="Usuários cadastrados"
        :description="$users->count() . ' usuário(s) encontrado(s).'"
        :flush="true">

        @if ($users->isEmpty())

            <x-ui.empty-state
                title="Nenhum usuário cadastrado"
                icon="users"
            />

        @else

            <x-ui.table>

                <x-slot:head>

                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col" class="text-right">Ações</th>
                    </tr>

                </x-slot:head>

                @foreach ($users as $user)

                    <tr>

                        <td>

                            <div class="cluster">

                                <span class="font-medium">
                                    {{ $user->name }}
                                </span>

                                @if (auth()->id() === $user->id)

                                    <x-ui.badge variant="primary">
                                        Você
                                    </x-ui.badge>

                                @endif

                            </div>

                        </td>

                        <td class="text-muted">
                            {{ $user->email }}
                        </td>

                        <td>

                            <div class="table__actions">

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route('users.show', $user)"
                                    title="Visualizar usuário"
                                    aria-label="Visualizar usuário">

                                    <x-ui.icon name="eye" size="sm" />

                                </x-ui.button>

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route('users.edit', $user)"
                                    title="Editar usuário"
                                    aria-label="Editar usuário">

                                    <x-ui.icon name="pencil" size="sm" />

                                </x-ui.button>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </x-ui.table>

        @endif

    </x-ui.card>

@endsection
