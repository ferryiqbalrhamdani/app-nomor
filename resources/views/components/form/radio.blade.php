@props([
'name',
'value',
])

<div class="form-check">
    <input class="form-check-input" type="radio" value="{{$value}}" wire:model.live='{{$name}}' id="{{$value}}">
    <label class="form-check-label" for="{{$value}}">
        {{$slot}}
    </label>
    @error($name)
    <span class="text-danger">{{$message}}</span>
    @enderror
</div>