<x-layouts.app>

    <x-slot:title>Editar Medicamento</x-slot:title>

    <form method="POST" action="{{ route('drugs.update', $drug) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $drug->name }}" required />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">
                Descrição
                <span class="text-muted small">(opcional)</span>
            </label>
            <input type="text" id="description" name="description" class="form-control" value="{{ $drug->description }}"/>
        </div>

        <div class="mb-3">
            <label for="classification" class="form-label"></label>
            <select id="classification" name="classification_id" class="form-select">
                @foreach ($classifications as $classification)
                    <option 
                    value="{{ $classification->id }}"
                    @selected($drug->classification->name === $classification->name)>
                        {{ $classification->name  }}
                    </option>
                @endforeach
            </select>
        </div>
            
        <button type="submit" class="btn btn-warning">Salvar</button>

    </form>

</x-layouts.app>