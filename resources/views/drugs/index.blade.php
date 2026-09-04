<x-layouts.app>

    <x-slot:title>Medicamentos</x-slot:title>

    <x-ui.page-header title="Medicamentos">
        <x-slot:action>
            <a href="{{ route('drugs.create') }}" class="btn btn-success">Novo Medicamento</a>
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
            @foreach ($drugs as $drug)

                <tr>
                    <th scope="row">{{ $drug->id }}</th>
                    <td>{{ $drug->name }}</td>
                    <td>
                        <a href="{{ route('drugs.show', $drug->id) }}" class="btn btn-info">Detalhes</a>
                    </td>
                </tr>
                
            @endforeach
        </tbody>

    </table>

</x-layouts.app>