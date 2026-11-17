@php
    $editing = isset($interaction);

    $severityOptions = [
        'minor' => 'Leve',
        'moderate' => 'Moderada',
        'major' => 'Grave',
        'contraindicated' => 'Contraindicada',
    ];
@endphp

@if ($editing)

    <x-ui.detail-list :columns="2">

        <x-ui.detail-item
            label="Medicamento A"
            :value="$interaction->drugA->name"
        />

        <x-ui.detail-item
            label="Medicamento B"
            :value="$interaction->drugB->name"
        />

    </x-ui.detail-list>

    <x-ui.alert variant="info">

        Os medicamentos associados a uma interação
        não podem ser alterados após seu cadastro.

    </x-ui.alert>

@else

    @php
        $drugOptions = $drugs
            ->sortBy('name')
            ->pluck('name', 'id');
    @endphp

    <div class="grid grid--2">

        <x-form.select
            name="drugA_id"
            label="Medicamento A"
            :options="$drugOptions"
            placeholder="Selecione um medicamento"
            :required="true"
        />

        <x-form.select
            name="drugB_id"
            label="Medicamento B"
            :options="$drugOptions"
            placeholder="Selecione um medicamento"
            :required="true"
        />

    </div>

    <p class="text-muted text-xs">

        Selecione dois medicamentos distintos.
        A ordem dos medicamentos não altera a interação.

    </p>

@endif

<x-form.select
    name="severity"
    label="Severidade"
    :options="$severityOptions"
    :value="$interaction->severity->value ?? null"
    placeholder="Selecione a severidade"
    :required="true"
/>

<x-form.textarea
    name="description"
    label="Descrição"
    :value="$interaction->description ?? null"
    placeholder="Descreva a interação entre os medicamentos..."
    help="Campo opcional."
    maxlength="65535"
    :rows="5"
/>
