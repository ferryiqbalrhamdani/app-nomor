@php
$classes = "table-primary";
@endphp

<th scope="col" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</th>