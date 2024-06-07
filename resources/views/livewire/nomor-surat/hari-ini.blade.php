<div>
    @include('modal.nomor-surat.hari-ini-modal')

    {{-- <x-slot name="header">
        Nomor Surat Hari Ini
        <x-slot name="breadcrumb">
            <x-breadcrumb>
                Nomor Surat
            </x-breadcrumb>
            <x-breadcrumb>
                Nomor Surat Hari Ini
            </x-breadcrumb>
        </x-slot>
    </x-slot> --}}



    <x-content>
        <div class="row justify-content-md-center mb-5">
            <div class="col-lg-6">
                <div class="card shadow ">
                    <form wire:submit.prevent='gunakan({{$id_action}})'>
                        <div class="card-header">
                            <h5 class="text-center">Nomor Surat Hari Ini</h5>

                        </div>
                        <div class="card-body  text-center">
                            <x-form.select name="pt" labelData="Pilih Data PT">
                                @foreach ($dataPT as $dp)
                                <option value="{{$dp->slug}}">{{$dp->name}}</option>
                                @endforeach
                            </x-form.select>
                            <hr>
                            <h3 wire:poll.keep-alive>{{$nomor_surat}}</h3>
                        </div>
                        <div class="card-footer">
                            <button @if($nomor_surat=='Tidak ada nomor surat' ) disabled @endif type="submit"
                                class="btn btn-primary btn-rounded btn-block w-100">Gunakan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class=" mg-b-5">
            <div class="mg-b-20">
                <div class="d-flex justify-content-center">
                    <div class="row mb-3 bg-primary rounded">
                        <div class="col">
                            <button class="btn btn-primary" wire:model="activeTab" @if($activeTab=='' ) disabled @endif
                                wire:click="$set('activeTab', '')">Semua Nomor Surat</button>
                            <button class="btn btn-primary" wire:model="activeTab" wire:model="activeTab"
                                @if($activeTab==Auth::user()->id) disabled @endif
                                wire:click="$set('activeTab', '{{Auth::user()->id}}')">Nomor
                                Surat Saya</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Start -->
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
                            <button class="btn btn-sm btn-primary" wire:click='detail({{$ns->id}})'
                                data-toggle="tooltip" data-placement="top" title="lihat detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($id_action == $ns->id)
                            <button class="btn btn-sm btn-success" wire:click='terpakaiAdmin({{$ns->id}})'
                                data-toggle="tooltip" data-placement="top" title="gunakan no surat">
                                <i class="fas fa-check-circle"></i>admin
                            </button>
                            @endif
                            @if(Auth::user()->id == $ns->user->id )
                            @if($ns->status == 1 || $ns->status == 3)
                            <button class="btn btn-sm btn-danger" wire:click='reject({{$ns->id}})' data-toggle="tooltip"
                                data-placement="top" title="no surat tidak digunakan">
                                <i class="fas fa-times-circle"></i>
                            </button>
                            <button class="btn btn-sm btn-success" wire:click='edit({{$ns->id}})' data-toggle="tooltip"
                                data-placement="top" title="edit data">
                                <i class="far fa-edit"></i>
                            </button>
                            @endif
                            @endif
                        </x-table.td>
                    </tr>
                    @endforeach
                    @endif
                </x-table.tbody>
            </x-table>

            {{$noSurat->links()}}
        </div>
        <!-- Table End -->
    </x-content>
</div>