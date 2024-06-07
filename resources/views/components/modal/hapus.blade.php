@props([
'action' => '',
'id' => '',
'name' => 'Hapus',
'class' => 'btn-danger',
])



<div wire:ignore.self class="modal fade" id="{{$id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi</h1>
                <button wire:click='closeModel' type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
            <div class="modal-footer">
                <button wire:click='closeModel' type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Kembali</button>
                <form wire:submit.prevent='{{$action}}'>
                    @csrf
                    <x-button.index class="{{$class}}">
                        {{$name}} Data
                    </x-button.index>
                </form>
            </div>
        </div>
    </div>
</div>