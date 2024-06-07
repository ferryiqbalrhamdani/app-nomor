<a {{$attributes}} class="nav-item nav-link {{request()->fullUrlIs(url($href)) ? 'active' : ''}} ">

    {{$slot}}

</a>