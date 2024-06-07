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

<x-modal id="edit" title="Ubah Nomor Surat" action="editNomorSurat">
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
                            <x-button.index wire:click='downloadFile({{$id}})' class="btn-sm" data-toggle="tooltip"
                                data-placement="top" title="download file">
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
            </x-table>


            <div class="row">
                <div class="col-12">
                    <x-form type="file" name="file_upload">
                        Unggah File PDF
                    </x-form>
                    <div wire:loading.delay wire:target="file_upload">
                        Proccess uploading file...
                    </div>
                </div>
                <div class="col-12">
                    <x-form type="text" name="keterangan">
                        keterangan
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</x-modal>

@push('kastem-modal')
<script>
    window.addEventListener('show-confirm-gunakan', event =>{
        $('#konfirmGuanakan').modal('show');
    });
    window.addEventListener('closePakai', event =>{
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
    window.addEventListener('closeEdit', event =>{
        $('#edit').modal('hide');
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