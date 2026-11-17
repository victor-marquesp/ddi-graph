@props([
    'name',
    'label' => null,
    'id' => null,
    'options' => [],
    'value' => null,
    'placeholder' => null,
    'help' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $id ??= $name;

    $selected = old($name, $value);
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

    <select
        id="{{ $id }}"
        name="{{ $name }}"

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

        @if ($placeholder !== null)
            <option
                value=""
                @selected($selected === null || $selected === '')>
                {{ $placeholder }}
            </option>
        @endif

        @foreach ($options as $key => $option)
            <option
                value="{{ $key }}"
                @selected((string) $key === (string) $selected)>
                {{ $option }}
            </option>
        @endforeach

    </select>

</x-form.field>
