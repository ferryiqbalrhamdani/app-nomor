<x-modal id="tambahTahun" title="Tambah Tahun" action="saveTahun">
    <x-form readonly type="text" name="nama_tahun">
        Nama Tahun
    </x-form>
</x-modal>
<x-modal id="tambahData" title="Tambah Data Nomor Surat" action="save">
    <x-form.select name="namaPt" labelData="Pilih PT">
        @foreach ($dataPT as $t)
        <option value="{{$t->slug}}">{{ $t->slug }}</option>
        @endforeach
    </x-form.select>
</x-modal>

@push('data-nomor-surat')
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
    window.addEventListener('tambahTahun', event =>{
        $('#tambahTahun').modal('show');
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