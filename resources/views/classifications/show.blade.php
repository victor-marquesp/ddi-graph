<x-layouts.app>

    <x-slot:title>Class Details</x-slot:title>

    <x-ui.page-header title="Class Details">
        <x-slot:action>
            <a href="{{ route('classifications.index') }}" class="btn btn-outline-primary">Voltar</a>
        </x-slot:action>
    </x-ui.page-header>

    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h1 class="h4 mb-1">{{ $classification->name }}</h1>
                <small class="text-body-secondary">Classification #{{ $classification->id }}</small>
            </div>

            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ $classification->name }}</dd>

                    <dt class="col-sm-3">Descrição</dt>
                    <dd class="col-sm-9">{{ $classification->desc ?? 'sem desc' }}</dd>

                    <dt class="col-sm-3">Created at</dt>
                    <dd class="col-sm-9">{{ $classification->created_at }}</dd>

                    <dt class="col-sm-3">Updated at</dt>
                    <dd class="col-sm-9">{{ $classification->updated_at }}</dd>
                </dl>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('classifications.edit', $classification) }}" class="btn btn-primary">
                    Edit
                </a>

                <form action="{{ route('classifications.destroy', $classification) }}" method="POST">
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