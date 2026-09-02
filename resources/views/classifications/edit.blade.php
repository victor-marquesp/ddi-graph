<x-layouts.app>

    <x-slot:title>Nova Classe</x-slot:title>

    <form method="POST" action="{{ route('classifications.update', $classification) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $classification->name }}" required />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">
                Descrição
                <span class="text-muted small">(opcional)</span>
            </label>
            <input type="text" 
                    id="description" 
                    name="description" 
                    class="form-control" 
                    value="{{ $classification->description }}" 
                />
        <div class="mb-3">
    
        <button type="submit" class="btn btn-success">Salvar</button>

    </form>

</x-layouts.app>