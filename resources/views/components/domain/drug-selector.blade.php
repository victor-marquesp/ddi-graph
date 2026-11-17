@props([
    'drugs',
    'selected' => [],
])

@php
    $selectedIds = array_map(
        'strval',
        (array) old('drug_ids', $selected)
    );

    $drugs = collect($drugs)->sortBy('name');
@endphp

<div
    data-drug-selector
    {{ $attributes->class(['drug-selector']) }}>

    <div class="drug-selector__grid">

        {{-- Available drugs --}}

        <section class="drug-selector__panel">

            <div class="drug-selector__header">

                <h3 class="drug-selector__title">
                    Disponíveis
                </h3>

                <span
                    class="drug-selector__count"
                    data-available-count>
                </span>

            </div>

            <div class="drug-selector__toolbar">

                <input
                    type="search"
                    class="form-control"
                    placeholder="Buscar medicamento..."
                    aria-label="Buscar medicamento"
                    data-drug-search
                >

                <x-ui.button
                    variant="secondary"
                    size="sm"
                    data-add-all
                    :block="true">

                    Adicionar todos

                </x-ui.button>

            </div>

            <ul
                class="drug-selector__list"
                data-available-list>
            </ul>

            <p
                class="drug-selector__empty"
                data-available-empty
                hidden>

                Nenhum medicamento disponível.

            </p>

        </section>

        {{-- Selected drugs --}}

        <section class="
            drug-selector__panel
            drug-selector__panel--selected
        ">

            <div class="drug-selector__header">

                <h3 class="drug-selector__title">
                    Selecionados
                </h3>

                <span
                    class="drug-selector__count"
                    data-selected-count
                    aria-live="polite">
                </span>

            </div>

            <div class="drug-selector__toolbar">

                <x-ui.button
                    variant="secondary"
                    size="sm"
                    data-remove-all
                    :block="true">

                    Remover todos

                </x-ui.button>

            </div>

            <ul
                class="drug-selector__list"
                data-selected-list>
            </ul>

            <p
                class="drug-selector__empty"
                data-selected-empty
                hidden>

                Nenhum medicamento selecionado.

            </p>

        </section>

    </div>

    {{-- Initial items --}}

    <ul data-drug-items hidden>

        @foreach ($drugs as $drug)

            <li
                class="drug-selector__item"
                data-drug-id="{{ $drug->id }}"
                data-drug-name="{{ $drug->name }}"
                data-selected="{{ in_array(
                    (string) $drug->id,
                    $selectedIds,
                    true
                ) ? 'true' : 'false' }}">

                <span class="drug-selector__name">
                    {{ $drug->name }}
                </span>

                <button
                    type="button"
                    class="drug-selector__action"
                    aria-label="Adicionar {{ $drug->name }}"
                    data-drug-add>

                    <x-ui.icon name="plus" size="sm" />

                </button>

                <button
                    type="button"
                    class="
                        drug-selector__action
                        drug-selector__action--remove
                    "
                    aria-label="Remover {{ $drug->name }}"
                    data-drug-remove
                    hidden>

                    <x-ui.icon name="x" size="sm" />

                </button>

                <input
                    type="hidden"
                    name="drug_ids[]"
                    value="{{ $drug->id }}"
                    disabled
                >

            </li>

        @endforeach

    </ul>

    <p class="text-muted text-xs" data-selection-summary></p>

    @error('drug_ids')
        <p class="field__error">{{ $message }}</p>
    @enderror

    @error('drug_ids.*')
        <p class="field__error">{{ $message }}</p>
    @enderror

    <noscript>
        É necessário habilitar o JavaScript para selecionar medicamentos.
    </noscript>

</div>
