<x-layouts.app>

    <x-slot:title>Interações</x-slot:title>

    <x-ui.page-header title="Interações">
        <x-slot:action>
            <a href="{{ route('interactions.create') }}" class="btn btn-success">Nova Interação</a>
        </x-slot:action>
    </x-ui.page-header>

    <table class="table">

        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Ações</th> 
            </tr>
        </thead>
        
        <tbody>
            @foreach ($interactions as $interaction)

                <tr>
                    <th scope="row">{{ $interaction->drugA_id }} - {{ $interaction->drugB_id }}</th>
                    <td>{{ $interaction->drugA->name }} + {{ $interaction->drugB->name }}</td>
                    <td>
                        <a 
                        href="{{ route('interactions.show', [$interaction->drugA_id, $interaction->drugB_id]) }}" 
                        class="btn btn-info">
                            Detalhes
                        </a>
                    </td>
                </tr>
                
            @endforeach
        </tbody>

    </table>

</x-layouts.app>