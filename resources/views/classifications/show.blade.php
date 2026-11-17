@extends('layouts.app')

@section('title', $classification->name)

@section('content')

    <x-layout.breadcrumb :items="[
        [
            'label' => 'Classificações',
            'href' => route('classifications.index'),
        ],
        [
            'label' => $classification->name,
        ],
    ]" />

    <x-layout.page-header
        :title="$classification->name"
        description="Informações sobre a classificação terapêutica."
        icon="layers">

        @auth

            <x-ui.button
                variant="secondary"
                :href="route(
                    'classifications.edit',
                    $classification
                )">

                <x-ui.icon name="pencil" size="sm" />

                Editar

            </x-ui.button>

            <x-ui.button
                variant="danger"
                data-modal-open="delete-classification"
                :disabled="$classification->drugs->isNotEmpty()">

                <x-ui.icon name="trash-2" size="sm" />

                Excluir

            </x-ui.button>

        @endauth

    </x-layout.page-header>

    <x-domain.educational-notice />

    @auth

        @if ($classification->drugs->isNotEmpty())

            <x-ui.alert variant="warning">

                Esta classificação não pode ser excluída
                enquanto possuir medicamentos associados.

            </x-ui.alert>

        @endif

    @endauth

    <x-ui.card title="Informações gerais">

        <x-ui.detail-list :columns="2">

            <x-ui.detail-item
                label="Nome"
                :value="$classification->name"
                :full="true"
            />

            <x-ui.detail-item
                label="Descrição"
                :value="$classification->description"
                :full="true"
            />

            <x-ui.detail-item
                label="Data de cadastro"
                :value="$classification->created_at?->format('d/m/Y')"
            />

            <x-ui.detail-item
                label="Última atualização"
                :value="$classification->updated_at?->format('d/m/Y')"
            />

        </x-ui.detail-list>

    </x-ui.card>

    <x-ui.card
        title="Medicamentos associados"
        :description="$classification->drugs->count() . ' medicamento(s) pertence(m) a esta classificação.'"
        :flush="true">

        @if ($classification->drugs->isEmpty())

            <x-ui.empty-state
                title="Nenhum medicamento associado"
                description="Ainda não existem medicamentos pertencentes a esta classificação."
                icon="pill"
            />

        @else

            <x-ui.table>

                <x-slot:head>

                    <tr>
                        <th scope="col">Medicamento</th>
                        <th scope="col" class="text-right">Ações</th>
                    </tr>

                </x-slot:head>

                @foreach (
                    $classification->drugs->sortBy('name')
                    as $drug
                )

                    <tr>

                        <td class="font-medium">
                            {{ $drug->name }}
                        </td>

                        <td>

                            <div class="table__actions">

                                <x-ui.button
                                    variant="ghost"
                                    size="sm"
                                    :href="route('drugs.show', $drug)"
                                    title="Visualizar medicamento"
                                    aria-label="Visualizar medicamento">

                                    <x-ui.icon name="eye" size="sm" />

                                </x-ui.button>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </x-ui.table>

        @endif

    </x-ui.card>

    <div class="cluster">

        <x-ui.button
            variant="ghost"
            :href="route('classifications.index')">

            <x-ui.icon name="arrow-left" size="sm" />

            Voltar para classificações

        </x-ui.button>

    </div>

    @auth

        @if ($classification->drugs->isEmpty())

            <x-ui.modal
                id="delete-classification"
                title="Excluir classificação">

                <div class="stack">

                    <p>
                        Tem certeza de que deseja excluir
                        <strong>{{ $classification->name }}</strong>?
                    </p>

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
                        action="{{ route(
                            'classifications.destroy',
                            $classification
                        ) }}">

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

        @endif

    @endauth

@endsection
