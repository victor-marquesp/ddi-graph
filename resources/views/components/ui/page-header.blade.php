@props(['title', 'subtitle' => null])

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="mb-1">
        <h3>{{ $title }}</h3>
        @if ($subtitle)
            <p class="text-muted mb-0">{{ $subtitle }}</p>
        @endif
    </div>

    @isset($action)
        <div>
            {{ $action }}
        </div>
    @endisset
</div>