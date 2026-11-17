@props([
    'columns' => 1,
])

<dl {{ $attributes->class([
    'detail-list',
    'detail-list--2' => $columns == 2,
]) }}>

    {{ $slot }}

</dl>
