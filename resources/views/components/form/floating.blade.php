@props([
'name',
'type',
'showpassword',
])

<div class="form-floating mb-3">
    <input @isset($showpassword) @if($showpassword==false) type="{{$type}}" @else type="text" @endif @endisset
        type="{{$type}}" class="form-control @error($name) is-invalid @else 'is-valid' @enderror" id="{{$name}}"
        placeholder="{{$name}}" wire:model.blur='{{$name}}'>
    <label for="{{$name}}">
        {{$slot}}
    </label>
    @error($name)
    <span class="text-danger">{{$message}}</span>
    @enderror
</div>