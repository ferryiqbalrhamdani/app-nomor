@props([
'name',
'labelData' => '',
])

<div class="mb-3">
    <label for="{{$name}}" class="form-label">
        {{$labelData}}
    </label>
    <select wire:model.live='{{$name}}' class="form-select @error($name) is-invalid @else 'is-valid' @enderror"
        id="{{$name}}">
        {{$slot}}
    </select>
    @error($name)
    <span class="text-danger">{{$message}}</span>
    @enderror
</div>