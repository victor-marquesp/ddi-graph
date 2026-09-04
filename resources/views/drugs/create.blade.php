<x-layouts.app>

    <x-slot:title>Novo Medicamento</x-slot:title>

    <form method="POST" action="{{ route('drugs.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" name="name" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">
                Descrição
                <span class="text-muted small">(opcional)</span>
            </label>
            <input type="text" id="description" name="description" class="form-control" />
        </div>

        <div class="mb-3">
            <label for="classification" class="form-label"></label>
            <select id="classification" name="classification_id" class="form-select" required>
                @foreach ($classifications as $classification)
                    <option value="{{ $classification->id }}">{{ $classification->name  }}</option>
                @endforeach
            </select>
        </div>
            
        <button type="submit" class="btn btn-success">Criar</button>

    </form>

</x-layouts.app>