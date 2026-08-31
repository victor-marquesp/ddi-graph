<x-layouts.app>

    <x-slot:title>Users</x-slot:title>

    <x-ui.page-header title="Users">
        <x-slot:action>
            <a href="{{ route('users.create') }}" class="btn btn-primary">New User</a>
        </x-slot:action>
    </x-ui.page-header>

    <table class="table">

        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th> 
                <th scope="col">Ações</th> 
            </tr>
        </thead>
        
        <tbody>
            @foreach ($users as $user)

                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">Detalhes</a>
                    </td>
                </tr>
                
            @endforeach
        </tbody>

    </table>

</x-layouts.app>