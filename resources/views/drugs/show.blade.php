@extends('layouts.app')

@section('title', $drug->name)

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Medicamentos',
            'href' => route('drugs.index'),
        ],
        [
            'label' => $drug->name,
        ],
    ]" />

    <x-layout.page-header
        :title="$drug->name"
        description="Informações sobre o medicamento."
        icon="pill">

        @auth

            <x-ui.button
                variant="secondary"
                :href="route('drugs.edit', $drug)">

                <x-ui.icon name="pencil" size="sm" />

                Editar

            </x-ui.button>

            <x-ui.button
                variant="danger"
                data-modal-open="delete-drug">

                <x-ui.icon name="trash-2" size="sm" />

                Excluir

            </x-ui.button>

        @endauth

    </x-layout.page-header>

    <x-domain.educational-notice />

    <x-ui.card title="Informações gerais">

        <x-ui.detail-list :columns="2">

            <x-ui.detail-item
                label="Nome"
                :value="$drug->name"
            />

            <x-ui.detail-item label="Classificação terapêutica">

                <a href="{{ route(
                    'classifications.show',
                    $drug->classification_id
                ) }}">
                    {{ $drug->classification->name }}
                </a>

            </x-ui.detail-item>

            <x-ui.detail-item
                label="Descrição"
                :value="$drug->description"
                :full="true"
            />

            <x-ui.detail-item
                label="Data de cadastro"
                :value="$drug->created_at?->format('d/m/Y')"
            />

            <x-ui.detail-item
                label="Última atualização"
                :value="$drug->updated_at?->format('d/m/Y')"
            />

        </x-ui.detail-list>

    </x-ui.card>

    <x-ui.card title="Análise de interações">

        <div class="stack">

            <p class="text-muted">
                Selecione medicamentos para analisar suas
                interações por meio das ferramentas
                disponíveis no sistema.
            </p>

            <div class="cluster">

                <x-ui.button :href="route('selection', [
                    'drug_ids' => [$drug->id],
                ])">

                    <x-ui.icon name="network" size="sm" />

                    Iniciar análise

                </x-ui.button>

            </div>

        </div>

    </x-ui.card>

    <div class="cluster">

        <x-ui.button
            variant="ghost"
            :href="route('drugs.index')">

            <x-ui.icon name="arrow-left" size="sm" />

            Voltar para medicamentos

        </x-ui.button>

    </div>

    @auth

        <x-ui.modal
            id="delete-drug"
            title="Excluir medicamento">

            <div class="stack">

                <p>
                    Tem certeza de que deseja excluir
                    <strong>{{ $drug->name }}</strong>?
                </p>

                <x-ui.alert variant="warning">

                    Todas as interações associadas a este
                    medicamento também serão excluídas.

                </x-ui.alert>

                <p class="text-muted">
                    Essa ação não poderá ser desfeita.
                </p>

            </div>

            <x-slot:footer>

                <x-ui.button
                    variant="secondary"
                    data-modal-close
                    autofocus>

                    Cancelar

                </x-ui.button>

                <form
                    method="POST"
                    action="{{ route('drugs.destroy', $drug) }}">

                    @csrf
                    @method('DELETE')

                    <x-ui.button
                        variant="danger"
                        type="submit">

                        Confirmar exclusão

                    </x-ui.button>

                </form>

            </x-slot:footer>

        </x-ui.modal>

    @endauth

@endsection
