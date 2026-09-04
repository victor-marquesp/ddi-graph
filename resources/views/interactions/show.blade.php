<x-layouts.app>

    <x-slot:title>Interaction Details</x-slot:title>

    <x-ui.page-header title="Interaction Details">
        <x-slot:action>
            <a href="{{ route('interactions.index') }}" class="btn btn-outline-primary">Voltar</a>
        </x-slot:action>
    </x-ui.page-header>

    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h1 class="h4 mb-1">{{ $interaction->name }}</h1>
                <small 
                class="text-body-secondary">
                    interaction #{{ $interaction->drugA_id }} - {{ $interaction->drugB_id }}
                </small>
            </div>

            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ $interaction->drugA->name }} + {{ $interaction->drugB->name }}</dd>

                    <dt class="col-sm-3">Gravidade</dt>
                    <dd class="col-sm-9">{{ $interaction->severity }}</dd>

                    <dt class="col-sm-3">Descrição</dt>
                    <dd class="col-sm-9">{{ $interaction->description ?? 'sem desc' }}</dd>

                    <dt class="col-sm-3">Created at</dt>
                    <dd class="col-sm-9">{{ $interaction->created_at }}</dd>

                    <dt class="col-sm-3">Updated at</dt>
                    <dd class="col-sm-9">{{ $interaction->updated_at }}</dd>
                </dl>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a 
                href="{{ route('interactions.edit', [$interaction->drugA_id, $interaction->drugB_id]) }}" 
                class="btn btn-warning">
                    Edit
                </a>

                <form 
                action="{{ route('interactions.destroy', [$interaction->drugA_id, $interaction->drugB_id]) }}" 
                method="POST">
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
