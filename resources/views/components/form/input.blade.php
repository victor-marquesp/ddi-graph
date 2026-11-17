@props([
    'name',
    'label' => null,
    'id' => null,
    'type' => 'text',
    'value' => null,
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

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"

        @if (!in_array($type, ['password', 'file'], true))
            value="{{ old($name, $value) }}"
        @endif

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
    >

</x-form.field>
