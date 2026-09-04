<x-layouts.app>

    <x-slot:title>Classificações</x-slot:title>

    <x-ui.page-header title="Classificações">
        <x-slot:action>
            <a href="{{ route('classifications.create') }}" class="btn btn-success">Nova Classificação</a>
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
            @foreach ($classifications as $classification)

                <tr>
                    <th scope="row">{{ $classification->id }}</th>
                    <td>{{ $classification->name }}</td>
                    <td>
                        <a href="{{ route('classifications.show', $classification->id) }}" class="btn btn-info">Detalhes</a>
                    </td>
                </tr>
                
            @endforeach
        </tbody>

    </table>

</x-layouts.app>