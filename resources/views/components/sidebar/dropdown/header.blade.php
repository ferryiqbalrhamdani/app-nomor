@props([
'routes' => []
])


<a href="#" class="nav-link dropdown-toggle @if(in_array(request()->route()->uri, $routes)) active @endif"
    data-bs-toggle="dropdown">
    {{$slot}}
</a>