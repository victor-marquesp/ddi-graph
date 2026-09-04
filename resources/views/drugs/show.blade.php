<x-layouts.app>

    <x-slot:title>Drug Details</x-slot:title>

    <x-ui.page-header title="Drug Details">
        <x-slot:action>
            <a href="{{ route('drugs.index') }}" class="btn btn-outline-primary">Voltar</a>
        </x-slot:action>
    </x-ui.page-header>

    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h1 class="h4 mb-1">{{ $drug->name }}</h1>
                <small class="text-body-secondary">drug #{{ $drug->id }}</small>
            </div>

            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ $drug->name }}</dd>

                    <dt class="col-sm-3">Classificação</dt>
                    <dd class="col-sm-9">{{ $drug->classification->name }}</dd>

                    <dt class="col-sm-3">Descrição</dt>
                    <dd class="col-sm-9">{{ $drug->description ?? 'sem desc' }}</dd>

                    <dt class="col-sm-3">Created at</dt>
                    <dd class="col-sm-9">{{ $drug->created_at }}</dd>

                    <dt class="col-sm-3">Updated at</dt>
                    <dd class="col-sm-9">{{ $drug->updated_at }}</dd>
                </dl>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('drugs.edit', $drug) }}" class="btn btn-warning">
                    Edit
                </a>

                <form action="{{ route('drugs.destroy', $drug) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure?')">
                        Delete
                    </button>
                </form>
                
            </div>
        </div>
    </div>

</x-layouts.app>