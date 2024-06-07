@props([
'name',
'labelData' => '',
])
<div class="form-group">
    <label for="{{$name}}">{{$labelData}}</label>
    <textarea wire:model.blur='{{$name}}' class="form-control @error($name) is-invalid @enderror" id="{{$name}}"
        rows="3"></textarea>
    @error($name)
    <span class="text-danger">{{ $message }}</span>
    @enderror
</div>