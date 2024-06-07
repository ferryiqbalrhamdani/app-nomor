<x-modal.hapus id="konfirmGuanakan" action="actionNomorSuratHariIni" class="btn-primary" name="Gunakan">
    <div class="row text-center">
        <div class="col-12 mb-4">
            apakah anda yakin ingin menggunakan nomor surat <b>{{$nomor_surat}}</b> dihari ini?
        </div>
        <hr>
        <div class="col-12">
            <h6><b>Keterangan</b></h6>
            <p>{{$keterangan}}</p>
        </div>
    </div>
</x-modal.hapus>

<x-modal id="pilih" title="Pilih Nomor Surat" action="pakai">
    <div class="row">
        <div class="col-12 text-center mb-3">
            <h3>{{$nomor_surat_action}}</h3>
            <hr>
        </div>
        <div class="col-lg-6 col-12 mb-3">
            <x-form name="tanggal" type="date">
                Tanggal
            </x-form>
        </div>
        <div class="col-lg-6 col-12 mb-3">
            <x-form.select name="pic" labelData="PIC">
                <option value="">Pilih PIC</option>
                @foreach ($users as $u)
                <option value="{{$u->id}}">{{$u->first_name}} {{$u->last_name}}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="col-12 mb-3">
            <x-form.text-area name="keterangan" labelData="Pesan" />
        </div>
    </div>
</x-modal>

<x-modal id="edit" title="Pilih Nomor Surat" action="actionUbah">
    <div class="row">
        <div class="col-12 text-center mb-3">
            <h3>{{$nomor_surat_action}}</h3>
            <hr>
        </div>
        <div class="col-lg-6 col-12 mb-3">
            <x-form name="tanggal" type="date">
                Tanggal
            </x-form>
        </div>
        <div class="col-lg-6 col-12 mb-3">
            <x-form.select name="pic" labelData="PIC">
                <option value="">Pilih PIC</option>
                @foreach ($users as $u)
                <option value="{{$u->id}}">{{$u->first_name}} {{$u->last_name}}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="col-12 mb-3">
            <x-form.text-area name="keterangan" labelData="Pesan" />
        </div>
    </div>
</x-modal>

<x-modal.detail title="Detail Nomor Surat" id="detail">
    <div class="row">
        <div class="col">
            <h5 class="text-center"><b>{{ $nomor_surat_action }}</b></h5>
            <hr>
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Tanggal Surat</x-table.th>
                        <x-table.th>PIC</x-table.th>
                        <x-table.th>File</x-table.th>
                        <x-table.th>Status</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    <tr>
                        <x-table.td>{{ \Carbon\Carbon::parse($tgl_surat)->isoFormat('DD, MMMM YYYY') }}</x-table.td>
                        <x-table.td>{{ $pic }}</x-table.td>
                        <x-table.td>
                            @if ($file)
                            <x-button.index class="btn-sm">
                                <i class="far fa-file-pdf"></i>
                            </x-button.index>

                            @else
                            -
                            @endif
                        </x-table.td>
                        <x-table.td>
                            @if ($status == 0)
                            <x-button.index as="link" class="btn-sm btn-warning">tersedia</x-button.index>
                            @elseif($status == 1)
                            <x-button.index as="link" class="btn-sm btn-success">terpakai</x-button.index>
                            @elseif($status == 2)
                            <x-button.index as="link" class="btn-sm btn-danger">tidak terpakai</x-button.index>
                            @elseif($status == 3)
                            <x-button.index as="link" class="btn-sm btn-secondary">backdate</x-button.index>
                            @endif
                        </x-table.td>
                    </tr>
                </x-table.tbody>
                <x-table.thead>
                    <tr>
                        <x-table.th colspan="4" class="text-center">Keterangan</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    <tr>
                        <x-table.td colspan="4" class="text-center">
                            {{$keterangan}}
                        </x-table.td>
                    </tr>
                </x-table.tbody>
            </x-table>
            <div class="text-center">
                <p>History</p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Tanggal Surat</th>
                            <th>PIC</th>
                            <th>File</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($nomorSurat->arsipNoSurat))
                        <tr class="text-center">
                            <td colspan="5">Tidak ada data.</td>
                        </tr>
                        @else
                        @foreach($nomorSurat->arsipNoSurat as $data)
                        <tr>
                            <td>{{ $data->nomor_surat }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($data->tgl_surat)->isoFormat('DD, MMMM YYYY') }}
                            </td>
                            <td>{{ $data->pic }}</td>
                            <td class="text-center">
                                @if ($data->file)
                                <x-button.index wire:click='downloadFile({{$id}})' class="btn-sm" data-toggle="tooltip"
                                    data-placement="top" title="download file">
                                    <i class="far fa-file-pdf"></i>
                                </x-button.index>
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $data->keterangan }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>


            <br>
        </div>
    </div>
</x-modal.detail>

@push('kastem-admin')
<script>
    window.addEventListener('show-confrim', event =>{
        $('#konfirmGuanakan').modal('show');
    });
    window.addEventListener('hide-confrim', event =>{
        $('#konfirmGuanakan').modal('hide');
    });
    window.addEventListener('show-confirm-reject', event =>{
        $('#konfirmReject').modal('show');
    });
    window.addEventListener('closeReject', event =>{
        $('#konfirmReject').modal('hide');
    });
    window.addEventListener('showDetail', event =>{
        $('#detail').modal('show');
    });
    window.addEventListener('show-edit', event =>{
        $('#edit').modal('show');
    });
    window.addEventListener('show-pilih', event =>{
        $('#pilih').modal('show');
    });
    window.addEventListener('closePilih', event =>{
        $('#pilih').modal('hide');
        });
    window.addEventListener('showEdit', event =>{
        $('#edit').modal('show');
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('save',(event) => {
            const data=event
            swal.fire({
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: true,
                timer: 5000,
                timerProgressBar: true,
            })
            })
    });

</script>
@endpush