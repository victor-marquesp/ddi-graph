@props([
    'name',
    'label' => null,
    'id' => null,
    'value' => null,
    'rows' => 4,
    'help' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $id ??= $name;

    $invalid = $errors->has($name);

    $describedBy = implode(' ', array_filter([
        $help ? $id . '-help' : null,
        $invalid ? $id . '-error' : null,
    ]));
@endphp

<x-form.field
    :name="$name"
    :id="$id"
    :label="$label"
    :help="$help"
    :required="$required">

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"

        @required($required)
        @disabled($disabled)

        aria-invalid="{{ $invalid ? 'true' : 'false' }}"

        @if ($describedBy)
            aria-describedby="{{ $describedBy }}"
        @endif

        {{ $attributes->class([
            'form-control',
            'form-control--invalid' => $invalid,
        ]) }}
    >{{ old($name, $value) }}</textarea>

</x-form.field>
