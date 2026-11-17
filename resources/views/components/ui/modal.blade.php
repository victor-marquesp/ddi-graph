@props([
    'id',
    'title',
    'size' => 'md',
])

<dialog
    id="{{ $id }}"
    aria-labelledby="{{ $id }}-title"

    {{ $attributes->class([
        'modal',
        'modal--lg' => $size === 'lg',
    ]) }}
>

    <div class="modal__header">

        <h2 id="{{ $id }}-title" class="modal__title">
            {{ $title }}
        </h2>

        <button
            type="button"
            class="modal__close"
            data-modal-close
            aria-label="Fechar">

            <x-ui.icon name="x" />

        </button>

    </div>

    <div class="modal__body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="modal__footer">
            {{ $footer }}
        </div>
    @endisset

</dialog>
