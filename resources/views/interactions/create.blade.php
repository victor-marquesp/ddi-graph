<x-layouts.app>

    <x-slot:title>Nova Interação</x-slot:title>

    <form method="POST" action="{{ route('interactions.store') }}">
        @csrf

        <div class="mb-3">
            <label for="drugA" class="form-label">Medicamento A</label>
            <select id="drugA" name="drugA_id" class="form-select" required>
                @foreach ($drugs as $drug)
                    <option value="{{ $drug->id }}">{{ $drug->name }}</option>                    
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="drugB" class="form-label">Medicamento B</label>
            <select id="drugB" name="drugB_id" class="form-select" required>
                @foreach ($drugs as $drug)
                    <option value="{{ $drug->id }}">{{ $drug->name }}</option>                    
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="description" class="form-label">
                Descrição
                <span class="text-muted small">(opcional)</span>
            </label>
            <input type="text" id="description" name="description" class="form-control" />
        </div>

        <div class="mb-3">
            <label for="severity" class="form-label"></label>
            <select id="severity" name="severity" class="form-select">
                @foreach (App\Enums\Severity::cases() as $severity)
                    <option value="{{ $severity }}">
                        {{ $severity }}
                    </option>
                @endforeach
            </select>
        </div>
            
        <button type="submit" class="btn btn-success">Salvar</button>

    </form>

</x-layouts.app>