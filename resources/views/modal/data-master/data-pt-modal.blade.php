<x-modal id="tambahData" title="Tambah PT" action="actionTambah">
    <x-form type="text" name="name">
        Nama
    </x-form>
    <x-form type="text" name="slug">
        Slug
    </x-form>
</x-modal>
<x-modal id="ubah" title="Ubah PT" action="actionUbah">
    <x-form type="text" name="name">
        Nama
    </x-form>
    <x-form type="text" name="slug">
        Slug
    </x-form>
</x-modal>
<x-modal.hapus id="hapus" action="actionHapus">
    <p class="text-center">Apakah anda yakin ingin menghapus data <b>{{$name}}</b>?</p>
</x-modal.hapus>
<x-modal.hapus id="hapusSelected" action="hapusSelected">
    <p class="text-center">Apakah anda yakin ingin menghapus <b>{{count($mySelected)}}</b> data?</p>
</x-modal.hapus>

@push('data-pt')
<script>
    window.addEventListener('closeSave', event =>{
        $('#tambahData').modal('hide');
    });
    window.addEventListener('closeUbah', event =>{
        $('#ubah').modal('hide');
    });
    window.addEventListener('closeHapus', event =>{
        $('#hapus').modal('hide');
    });
    window.addEventListener('showUbah', event =>{
        $('#ubah').modal('show');
    });
    window.addEventListener('showHapus', event =>{
        $('#hapus').modal('show');
    });
    window.addEventListener('closeHapusSelected', event =>{
        $('#hapusSelected').modal('hide');
    });

    document.addEventListener('livewire:initialized', () =>{
        @this.on('save',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top-end",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    
</script>
@endpush