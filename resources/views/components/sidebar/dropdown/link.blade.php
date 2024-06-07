<a {{$attributes}} class="dropdown-item {{request()->fullUrlIs(url($href)) ? 'active' : ''}}">

    {{$slot}}

</a>