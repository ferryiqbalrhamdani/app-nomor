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
                        <x-table.td>{{ $tgl_surat }}</x-table.td>
                        <x-table.td>{{ $pic }}</x-table.td>
                        <x-table.td>
                            @if ($file)
                            <x-button.index wire:click='downloadFile({{$id}})' class="btn-sm">
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
                    @if ($file_upload)
                    <span class="text-success mb-3">
                        file berhasil di upload
                    </span>
                    @endif
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

<x-modal id="konfirmGuanakan" title="Konfirmasi" action="pakai">
    <div class="row">
        <div class="col text-center">
            <p>Apakah anda yakin ingin menggunakan nomor surat <b>{{$nomor_surat}}</b> pada
                tanggal
                <b>{{ \Carbon\Carbon::now()->isoFormat('DD, MMMM YYYY')}}</b>?
            </p>
            <div class="row row-sm mg-t-20">
                <div class="col-lg">
                    <x-form type="text" name="keterangan">
                        Keterangan
                    </x-form>

                </div><!-- col -->
            </div><!-- row -->

        </div>
    </div>
</x-modal>


<x-modal.hapus id="konfirmReject" action="actionReject" name="Reject">
    <div class="row">
        <div class="col text-center">
            <p>Apakah anda yakin tidak ingin menggunakan nomor surat <b>{{$nomor_surat_action}}</b> pada
                tanggal
                <b>{{ \Carbon\Carbon::parse($tgl_surat)->isoFormat('DD, MMMM YYYY')}}</b>?
            </p>
            <div class="row row-sm mg-t-20">
                <div class="col-lg">
                    <x-form type="text" name="keterangan">
                        Tuliskan keterangan surat
                    </x-form>

                </div><!-- col -->
            </div><!-- row -->

        </div>
    </div>
</x-modal.hapus>

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
            @if(!empty($nomorSurat->arsipNoSurat))
            <div class="table-responsive">
                <x-table class="table table-bordered table-hover" style="white-space: nowrap">
                    <x-table.thead>
                        <tr>
                            <x-table.th>Nomor Surat</x-table.th>
                            <x-table.th>Tanggal Surat</x-table.th>
                            <x-table.th>PIC</x-table.th>
                            <x-table.th>File</x-table.th>
                            <x-table.th>Keterangan Nomor Surat</x-table.th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                        @foreach($nomorSurat->arsipNoSurat as $data)
                        <tr>
                            <x-table.td>{{ $data->nomor_surat }}</x-table.td>
                            <x-table.td>
                                {{ \Carbon\Carbon::parse($data->tgl_surat)->isoFormat('DD, MMMM YYYY') }}
                            </x-table.td>
                            <x-table.td>{{ $data->pic }}</x-table.td>
                            <x-table.td class="text-center">
                                @if ($data->file)
                                <button class="btn btn-az-primary">file</button>
                                @else
                                -
                                @endif
                            </x-table.td>
                            <x-table.td>{{ $data->keterangan_arsip }}</x-table.td>
                        </tr>

                        @endforeach
                    </x-table.tbody>
                    <x-table.thead>
                        <tr>
                            <x-table.th colspan="5" class="text-center">Keterangan Reject</x-table.th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                        @foreach($nomorSurat->arsipNoSurat as $data)
                        <tr>
                            <x-table.td colspan="5" class="text-center">
                                {{$data->keterangan}}
                            </x-table.td>
                        </tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>
            </div>
            @endif

            <br>
        </div>
    </div>
</x-modal.detail>

@push('hari-ini')
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
    window.addEventListener('show-detail', event =>{
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