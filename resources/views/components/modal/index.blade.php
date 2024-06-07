@props([
'title' => '',
'action' => '',
'id' => '',
])

<div wire:ignore.self class="modal fade" id="{{$id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{$title}}</h1>
                <button wire:click='closeModel' type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form wire:submit.prevent='{{$action}}'>
                @csrf
                <div class="modal-body">
                    {{$slot}}
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModel' type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Kembali</button>
                    <x-button.index>
                        Simpan
                    </x-button.index>
                </div>
            </form>
        </div>
    </div>
</div>