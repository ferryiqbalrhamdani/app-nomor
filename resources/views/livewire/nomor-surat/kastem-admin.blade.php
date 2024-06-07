<div>
    @include('modal.nomor-surat.kastem-admin-modal')
    <x-content>
        <div class="row mb-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <x-form.select name="jenisNomorSurat">
                            <option value="">Nomor Surat Hari Ini</option>
                            <option value="kastem">Kastem Nomor Surat</option>
                        </x-form.select>
                    </div>
                    @if ($jenisNomorSurat=='kastem')

                    <div class="card-body">
                        <form wire:submit.prevent='cari'>
                            @csrf
                            <div class="row">
                                <div class="col-lg-10 mb-3">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mg-b-20">
                                                <div class="input-group ">
                                                    <label class="input-group-text" for="tanggal">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </label>
                                                    <input id="tanggal" wire:model.live='tanggal' type="date"
                                                        class="form-control fc-datepicker @error('tanggal') is-invalid @enderror"
                                                        placeholder="MM/DD/YYYY">
                                                </div>

                                                @error('tanggal')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div><!-- wd-200 -->

                                        </div>
                                        <div class="col-lg-5">
                                            <div class="mg-b-20">
                                                <div class="input-group ">
                                                    <label class="input-group-text" for="pt">
                                                        <i class="fas fa-list-ul"></i>
                                                    </label>
                                                    <select id="pt" wire:model.live='pt'
                                                        class="form-select form-control-sm @error('pt') is-invalid @enderror">
                                                        @foreach ($dataPT as $dp)
                                                        <option value="{{$dp->slug}}">{{$dp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('pt')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div><!-- wd-200 -->
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mg-b-20">
                                                <div class="input-group ">
                                                    <label class="input-group-text" for="pic">
                                                        <i class="fas fa-user"></i>
                                                    </label>
                                                    <select id="pic" wire:model.live='pic'
                                                        class="form-select form-control-sm @error('pic') is-invalid @enderror">
                                                        <option value="">Semua PIC...</option>
                                                        @foreach ($users as $u)
                                                        <option value="{{$u->id}}">{{$u->first_name.' '.$u->last_name}}
                                                        </option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('pic')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div><!-- wd-200 -->
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-2 mb-3">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i>
                                        Cari</button>
                                </div>
                                @if (count($daftarNoSurat) > 0 )

                                <div class="col-12">
                                    <x-form.floating name="keterangan" type="text">
                                        Keterangan Nomor Surat
                                    </x-form.floating>
                                </div>

                                @endif
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-12 mt-3">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nomor Surat</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($daftarNoSurat) == 0 )
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada nomor surat.</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>{{ $daftarNoSurat['nomor_surat'] }}</td>
                                            <td>
                                                {{\Carbon\Carbon::parse($daftarNoSurat['tgl_surat'])->isoFormat('D
                                                MMMM YYYY')}}

                                            </td>
                                            <td>
                                                @if($daftarNoSurat['status'] == 3)
                                                <x-button.index class=" btn-sm btn-secondary">backdate
                                                </x-button.index>
                                                @elseif($daftarNoSurat['status'] == 2)
                                                <x-button.index class=" btn-sm btn-danger">tidak terpakai
                                                </x-button.index>
                                                @endif
                                            </td>
                                        </tr>


                                        @endif


                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form wire:submit.prevent='pakai()'>
                            @csrf
                            <button type="submit" @if($daftarNoSurat==NULL) disabled @endif
                                class="btn btn-primary w-100">Pakai
                                Nomor Surat</button>
                        </form>
                    </div>

                    @else

                    <form wire:submit.prevent='nomorSuratHariIni'>
                        @csrf
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group ">
                                        <label class="input-group-text" for="pic">
                                            <i class="fas fa-user"></i>
                                        </label>
                                        <select id="pic" wire:model.live='pic'
                                            class="form-select form-control-sm @error('pic') is-invalid @enderror">
                                            <option value="">Pilih PIC ...</option>
                                            @foreach ($users as $u)
                                            <option value="{{$u->id}}">{{$u->first_name.' '.$u->last_name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pic')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="input-group ">
                                        <label class="input-group-text" for="pt">
                                            <i class="fas fa-list-ul"></i>
                                        </label>
                                        <select id="pt" wire:model.live='pt'
                                            class="form-select form-control-sm @error('pt') is-invalid @enderror">
                                            @foreach ($dataPT as $dp)
                                            <option value="{{$dp->slug}}">{{$dp->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pt')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <x-form.floating name="keterangan" type="text">
                                        Keterangan Nomor Surat
                                    </x-form.floating>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-3">
                                    <x-table class="text-center">
                                        <x-table.thead>
                                            <tr class="table-primary ">
                                                <x-table.th scope="col">Nomor Surat</x-table.th>
                                            </tr>
                                        </x-table.thead>
                                        <x-table.tbody>
                                            @if ($nomor_surat == NULL )
                                            <tr>
                                                <x-table.td colspan="3" class="text-center">Tidak ada nomor surat.
                                                </x-table.td>
                                            </tr>
                                            @else
                                            <tr>
                                                <x-table.td>{{ $nomor_surat}}</x-table.td>

                                            </tr>
                                            @endif
                                        </x-table.tbody>
                                    </x-table>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button @if($nomor_surat=='Tidak ada nomor surat' ) disabled @endif type="submit"
                                class="btn btn-primary btn-rounded btn-block w-100">Gunakan</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class=" mb-4">
            <div class="mg-b-20">
                <div class="d-flex justify-content-center">
                    <div class="row bg-primary rounded">
                        <div class="col">
                            <button class="btn btn-primary" wire:model="activeTab" @if($activeTab=='' ) disabled @endif
                                wire:click="$set('activeTab', '')">Semua Nomor Surat</button>
                            <button class="btn btn-primary" wire:model="activeTab" @if($activeTab==1) disabled @endif
                                wire:click="$set('activeTab', '1')">
                                Terpakai
                            </button>
                            <button class="btn btn-primary" wire:model="activeTab" @if($activeTab==2) disabled @endif
                                wire:click="$set('activeTab', '2')">
                                Tidak Terpakai
                            </button>
                            <button class="btn btn-primary" wire:model="activeTab" @if($activeTab==3) disabled @endif
                                wire:click="$set('activeTab', '3')">
                                Backdate
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-light rounded p-3">
            <x-heading.table-pt>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">
                        <i class="fas fa-list-ul"></i>
                    </label>
                    <select wire:model.live='pt_slug'
                        class="form-select form-control-sm @error('pt_slug') is-invalid @enderror">
                        <option value="">Semua PT...</option>
                        @foreach ($dataPT as $dp)
                        <option value="{{$dp->slug}}">{{$dp->name}}</option>

                        @endforeach
                    </select>
                </div>

            </x-heading.table-pt>

            <x-table>
                <x-table.thead>
                    <tr class="table-primary">
                        <x-table.th>
                            Nomor Surat
                            <span wire:click="sortBy('nomor_surat')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'nomor_surat' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'nomor_surat' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            PT
                            <span wire:click="sortBy('pt_slug')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'pt_slug' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'pt_slug' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            PIC
                            <span wire:click="sortBy('id_user')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'id_user' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'id_user' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Tanggal Surat
                            <span wire:click="sortBy('tgl_surat')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'tgl_surat' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'tgl_surat' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            File
                            <span wire:click="sortBy('file')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'file' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'file' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Status
                            <span wire:click="sortBy('status')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'status' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'status' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th class="text-center">Action</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @if (count($noSurat) == 0)
                    <tr>
                        <td colspan="7" class="text-center">tidak ada data</td>
                    </tr>
                    @else
                    @foreach ($noSurat as $ns)
                    <tr>
                        <x-table.td>{{$ns->nomor_surat}}</x-table.td>
                        <x-table.td>{{$ns->pt_slug}}</x-table.td>
                        <x-table.td class="text-center">
                            <x-button.index class="btn-secondary btn-sm w-100">
                                {{$ns->user->first_name ?? '-'}}
                            </x-button.index>
                        </x-table.td>
                        <x-table.td>
                            @if($ns->tgl_surat)
                            {{\Carbon\Carbon::parse($ns->tgl_surat)->isoFormat('D MMMM YYYY')}}
                            @else
                            -
                            @endif
                        </x-table.td>
                        <x-table.td>
                            @if($ns->status != 0)
                            @if($ns->file == NULL)
                            -
                            @else
                            <x-button.index wire:click='downloadFile({{$ns->id}})' class="btn-sm" data-toggle="tooltip"
                                data-placement="top" title="download file">
                                <i class="far fa-file-pdf"></i>
                            </x-button.index>
                            @endif
                            @endif
                        </x-table.td>
                        <x-table.td class="text-center">
                            @if ($ns->status == 0)
                            <x-button.index class="btn-sm rounded-pill btn-warning">tersedia</x-button.index>
                            @elseif($ns->status == 1)
                            <x-button.index class="btn-sm rounded-pill btn-success">terpakai</x-button.index>
                            @elseif($ns->status == 2)
                            <x-button.index class="btn-sm rounded-pill btn-danger">tidak terpakai</x-button.index>
                            @elseif($ns->status == 3)
                            <x-button.index class="btn-sm rounded-pill btn-secondary">backdate</x-button.index>
                            @endif
                        </x-table.td>
                        <x-table.td class="text-center">
                            @if($ns->status > 0)
                            <button class="btn btn-sm btn-primary" wire:click='detail({{$ns->id}})'
                                data-toggle="tooltip" data-placement="top" title="lihat detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @endif
                            @if($ns->status == 0 || $ns->status == 2)
                            <button class="btn btn-sm btn-success" wire:click='pilih({{$ns->id}})' data-toggle="tooltip"
                                data-placement="top" title="pilih data">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif

                            @if($ns->status == 1)
                            <button class="btn btn-sm btn-danger" wire:click='reject({{$ns->id}})' data-toggle="tooltip"
                                data-placement="top" title="no surat tidak digunakan">
                                <i class="fas fa-times-circle"></i>
                            </button>
                            @endif
                            @if($ns->status > 0)
                            <button class="btn btn-sm btn-success" wire:click='editData({{$ns->id}})'
                                data-toggle="tooltip" data-placement="top" title="edit data">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endif
                        </x-table.td>
                    </tr>
                    @endforeach
                    @endif
                </x-table.tbody>
            </x-table>

            {{$noSurat->links()}}
        </div>
    </x-content>



</div>