<x-form.input
    name="name"
    label="Nome"
    :value="$classification->name ?? null"
    placeholder="Nome da classificação terapêutica"
    :required="true"
/>

<x-form.textarea
    name="description"
    label="Descrição"
    :value="$classification->description ?? null"
    placeholder="Descreva a classificação terapêutica..."
    help="Campo opcional."
    :rows="5"
/>
