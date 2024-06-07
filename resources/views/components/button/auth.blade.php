@props([
'type' => 'submit',
'as' => 'button',
])

@php
$classes = "btn btn-primary py-3 w-100 mb-4";
@endphp


@if ($as === 'button')
<button type="{{$type}}" {{ $attributes->merge(['class' => $classes]) }} >
    {{ $slot }}
</button>
@else
<a {{ $attributes->merge(['class' => $classes]) }} >
    {{ $slot }}
</a>
@endif