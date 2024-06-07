@props([
'name',
'type',
'showpassword',
])

<div class="mb-3">
    <label for="{{$name}}" class="form-label">
        {{$slot}}
    </label>
    <input {{$attributes}} @isset($showpassword) @if($showpassword==false) type="{{$type}}" @else type="text" @endif
        @endisset type="{{$type}}" class="form-control @error($name) is-invalid @else 'is-valid' @enderror"
        id="{{$name}}" wire:model.live='{{$name}}'>
    @error($name)
    <span class="text-danger">{{$message}}</span>
    @enderror
</div>