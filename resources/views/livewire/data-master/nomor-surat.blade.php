<div>
    @include('modal.data-master.data-nomor-surat-modal')
    <x-slot name="header">
        Data Nomor Surat
        <x-slot name="breadcrumb">
            <x-breadcrumb>
                Data Master
            </x-breadcrumb>
            <x-breadcrumb>
                Data Nomor Surat
            </x-breadcrumb>
        </x-slot>
    </x-slot>
    <x-content>
        <div class="mb-3">
            <x-button.index modal="true" dataToggle='modal' dataTarget='tambahData'>
                Tambah Data
            </x-button.index>
            <x-button.index modal="true" dataToggle='modal' dataTarget='tambahTahun'>
                Tambah Tahun
            </x-button.index>
        </div>
        <div class="accordion" id="accordionExample">
            @foreach ($tahun as $t)
            <div class="card shadow">
                <div class="card-header" id="heading{{$t->nama_tahun}}">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{$t->nama_tahun}}" aria-expanded="false"
                            aria-controls="collapse{{$t->nama_tahun}}">
                            Data Tahun {{$t->nama_tahun}}
                        </button>
                    </h2>
                </div>

                <div id="collapse{{$t->nama_tahun}}" class="collapse @if($t->nama_tahun == $nama_tahun) show @endif"
                    aria-labelledby="heading{{$t->nama_tahun}}" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($dataPT as $dp)
                            <div class="col">
                                <div class="card shadow">
                                    <div class="card-header ">
                                        <h6>{{$dp->slug}} </h6>
                                        @if ($dataNosurat->where('pt_slug', $dp->slug)->where('tahun',
                                        $t->nama_tahun)->count() > 0)
                                        <button class="btn btn-success btn-rounded btn-icon ">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @else
                                        <button class="btn btn-danger btn-rounded btn-icon ">
                                            <i class="fas fa-times"></i>
                                        </button>

                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </x-content>
</div>