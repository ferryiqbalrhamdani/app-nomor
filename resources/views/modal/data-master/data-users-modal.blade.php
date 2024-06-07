<x-modal id="tambahData" title="Tambah User" action="actionTambah">
    <div class="row">
        <div class="col-12 col-lg-6">
            <x-form type="text" name="first_name">
                Nama Depan
            </x-form>
        </div>
        <div class="col-12 col-lg-6">
            <x-form type="text" name="last_name">
                Nama Belakang
            </x-form>
        </div>
        <div class="col-12 col-lg-6">
            <x-form.select name="role_id" labelData='Pilih Role'>
                <option value="">-</option>
                @foreach ($roles as $r)
                <option value="{{$r->id}}">{{$r->name}}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="col-12 col-lg-6">
            <label class="form-label">Jenis Kelamin</label>
            <x-form.radio name='jk' value="l">Laki-Laki</x-form.radio>
            <x-form.radio name='jk' value="p">Perempuan</x-form.radio>
        </div>
        <div class="col-12">
            <x-form.select name="pt_id" labelData='Pilih PT'>
                @foreach ($pt as $p)
                <option value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </x-form.select>
        </div>
    </div>
</x-modal>

<x-modal id="ubah" title="Ubah User" action="actionUbah">
    <div class="row">
        <div class="col-12 col-lg-6">
            <x-form type="text" name="first_name">
                Nama Depan
            </x-form>
        </div>
        <div class="col-12 col-lg-6">
            <x-form type="text" name="last_name">
                Nama Belakang
            </x-form>
        </div>
        <div class="col-12 col-lg-6">
            <x-form.select name="role_id" labelData='Pilih Role'>
                <option value="">-</option>
                @foreach ($roles as $r)
                <option value="{{$r->id}}">{{$r->name}}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="col-12 col-lg-6">
            <label class="form-label">Jenis Kelamin</label>
            <x-form.radio name='jk' value="l">Laki-Laki</x-form.radio>
            <x-form.radio name='jk' value="p">Perempuan</x-form.radio>
        </div>
        <div class="col-12">
            <x-form.select name="pt_id" labelData='Pilih PT'>
                @foreach ($pt as $p)
                <option value="{{$p->id}}">{{$p->name}}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="col-12">
            <label class="form-label">Status User</label>
            <div class="row">
                <div class="col">
                    <x-form.radio name='status' value="1">Aktif</x-form.radio>
                </div>
                <div class="col">
                    <x-form.radio name='status' value="0">Tidak Aktif</x-form.radio>
                </div>
            </div>
        </div>
    </div>
</x-modal>

<x-modal.hapus id="hapus" action="actionHapus">
    <p class="text-center">Apakah anda yakin ingin menghapus data <b>{{$first_name}}</b>?</p>
</x-modal.hapus>

<x-modal.hapus id="hapusSelected" action="hapusSelected">
    <p class="text-center">Apakah anda yakin ingin menghapus <b>{{count($mySelected)}}</b> data?</p>
</x-modal.hapus>

<x-modal.detail id="detail" title="Detail User">
    <div class="row">
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Nama Lengkap</label>
            <p class="form-control">{{$first_name.' '.$last_name}}</p>
        </div>
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Username</label>
            <p class="form-control">{{$username}}</p>
        </div>
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Role User</label>
            <p class="form-control">{{$role_id}}</p>
        </div>
        <div class="col-12 col-lg-6">
            <label for="" class="form-label">Jenis Kelamin</label>
            <p class="form-control">
                @if ($jk == 'l')
                Laki-laki
                @else
                Perempuan
                @endif
            </p>
        </div>
        <div class="col-12">
            <label for="" class="form-label">PT</label>
            <p class="form-control">{{$pt_id}}</p>
        </div>
        <div class="col-12">
            <label for="" class="form-label">Status User</label>
            <p class="form-control">{{ $status === true ? 'Aktif' : 'Tidak Aktif' }}</p>
        </div>
    </div>
</x-modal.detail>

@push('data-user')
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
    window.addEventListener('showDetail', event =>{
        $('#detail').modal('show');
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