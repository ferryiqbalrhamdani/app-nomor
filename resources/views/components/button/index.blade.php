@props([
'type' => 'submit',
'as' => 'button',
'modal' => false,
'dataToggle' => '',
'dataTarget' => '',
])

@php
$classes = "btn btn-primary";
@endphp


@if ($as === 'button')
<button type="{{$type}}" {{ $attributes->merge(['class' => $classes]) }} @if($modal == true)
    data-bs-toggle="{{$dataToggle}}"
    data-bs-target="#{{$dataTarget}}" @endif >
    {{ $slot }}
</button>
@else
<a {{ $attributes->merge(['class' => $classes]) }} >
    {{ $slot }}
</a>
@endif