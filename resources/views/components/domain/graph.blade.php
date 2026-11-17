@props([
    'id',
    'elements',
    'preview' => false,
    'controls' => true,
    'legend' => true,
])

<div
    data-graph
    data-graph-elements="{{ json_encode($elements, JSON_THROW_ON_ERROR) }}"
    data-graph-preview="{{ $preview ? 'true' : 'false' }}"
    {{ $attributes->class([
        'graph',
        'graph--preview' => $preview
    ]) }}>

    <div class="graph__viewport">

        <div
            id="{{ $id }}"
            class="graph__canvas"
            data-graph-canvas
            role="region"
            aria-label="Grafo de interações medicamentosas">
        </div>

        @if ($controls)

            <div class="graph__toolbar">

                <button
                    type="button"
                    class="graph__control"
                    data-graph-zoom-in
                    aria-label="Aumentar zoom"
                    disabled>

                    <x-ui.icon name="plus" size="sm" />

                </button>

                <button
                    type="button"
                    class="graph__control"
                    data-graph-zoom-out
                    aria-label="Diminuir zoom"
                    disabled>

                    <x-ui.icon name="minus" size="sm" />

                </button>

                <button
                    type="button"
                    class="graph__control"
                    data-graph-fit
                    aria-label="Centralizar grafo"
                    disabled>

                    <x-ui.icon name="maximize" size="sm" />

                </button>

            </div>

        @endif

    </div>

    @if ($legend)

        <div class="graph__legend">

            @foreach ([
                'minor' => 'Leve',
                'moderate' => 'Moderada',
                'major' => 'Grave',
                'contraindicated' => 'Contraindicada',
            ] as $severity => $label)

                <span class="graph__legend-item">

                    <span class="
                        graph__legend-line
                        graph__legend-line--{{ $severity }}
                    "></span>

                    {{ $label }}

                </span>

            @endforeach

        </div>

    @endif

</div>
