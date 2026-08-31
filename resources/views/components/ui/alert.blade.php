@props(['type', 'dismissible' => true])

@php
    $icon = match ($type) {
        'success' => 'bi-check-circle-fill',
        'danger' => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-circle-fill',
        default => 'bi-info-circle-fill',
    };
@endphp

<div
    class="alert alert-{{ $type }} d-flex align-items-center gap-2 {{ $dismissible ? 'alert-dismissible fade show' : '' }}"
    role="alert"
>
    <i class="bi {{ $icon }}" aria-hidden="true"></i>
    <div class="flex-grow-1">{{ $slot }}</div>

    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    @endif
</div>