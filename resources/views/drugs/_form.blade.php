<x-form.input
    name="name"
    label="Nome"
    :value="$drug->name ?? null"
    placeholder="Nome do medicamento"
    :required="true"
/>

<x-form.select
    name="classification_id"
    label="Classificação terapêutica"
    :options="$classifications->sortBy('name')->pluck('name', 'id')"
    :value="$drug->classification_id ?? null"
    placeholder="Selecione uma classificação"
    :required="true"
/>

<x-form.textarea
    name="description"
    label="Descrição"
    :value="$drug->description ?? null"
    placeholder="Descreva o medicamento..."
    help="Campo opcional."
    :rows="5"
/>
