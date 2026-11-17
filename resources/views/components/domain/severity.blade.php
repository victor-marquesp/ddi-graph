@props([
    'severity',
])

@php
    $value = $severity instanceof \App\Enums\Severity
        ? $severity->value
        : $severity;

    $label = match ($value) {
        'minor' => 'Leve',
        'moderate' => 'Moderada',
        'major' => 'Grave',
        'contraindicated' => 'Contraindicada',
        default => 'Desconhecida',
    };

    $variant = match ($value) {
        'minor', 'moderate', 'major', 'contraindicated'
            => 'severity-' . $value,
        default => 'severity-unknown',
    };
@endphp

<x-ui.badge :variant="$variant" {{ $attributes }}>
    {{ $label }}
</x-ui.badge>
