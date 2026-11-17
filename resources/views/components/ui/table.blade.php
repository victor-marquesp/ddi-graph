@props([
    'compact' => false,
])

<div class="table-wrapper">

    <table {{ $attributes->class([
        'table',
        'table--compact' => $compact,
    ]) }}>

        @isset($head)
            <thead>
                {{ $head }}
            </thead>
        @endisset

        <tbody>
            {{ $slot }}
        </tbody>

    </table>

</div>
