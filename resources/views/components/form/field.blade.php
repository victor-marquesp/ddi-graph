@props([
    'name',
    'id',
    'label' => null,
    'help' => null,
    'required' => false,
])

<div {{ $attributes->class(['field']) }}>

    @if ($label)
        <label for="{{ $id }}" class="field__label">
            {{ $label }}

            @if ($required)
                <span class="field__required" aria-hidden="true">
                    *
                </span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($help)
        <p id="{{ $id }}-help" class="field__help">
            {{ $help }}
        </p>
    @endif

    @error($name)
        <p id="{{ $id }}-error" class="field__error">
            {{ $message }}
        </p>
    @enderror

</div>
