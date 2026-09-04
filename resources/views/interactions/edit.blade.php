<x-layouts.app>

    <x-slot:title>Editar Interação</x-slot:title>

    <form method="POST" action="{{ route('interactions.update', [$interaction->drugA_id, $interaction->drugB_id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="description" class="form-label">
                Descrição
                <span class="text-muted small">(opcional)</span>
            </label>
            <input type="text" 
                id="description" 
                name="description" 
                class="form-control" 
                value="{{ $interaction->description }}"/>
        </div>

        <div class="mb-3">
            <label for="severity" class="form-label"></label>
            <select id="severity" name="severity" class="form-select">
                @foreach (App\Enums\Severity::cases() as $severity)
                    <option 
                    value="{{ $severity }}"
                    @selected($severity === $interaction->severity)>
                        {{ $severity }}
                    </option>
                @endforeach
            </select>
        </div>
            
        <button type="submit" class="btn btn-warning">Salvar</button>

    </form>

</x-layouts.app>