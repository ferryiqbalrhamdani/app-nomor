<div>
    @include('modal.data-master.data-pt-modal')
    <x-slot name="header">
        Data PT
        <x-slot name="breadcrumb">
            <x-breadcrumb>
                Data Master
            </x-breadcrumb>
            <x-breadcrumb>
                Data PT
            </x-breadcrumb>
        </x-slot>
    </x-slot>
    <x-content>
        <div class="p-3">
            <x-button.index modal="true" dataToggle='modal' dataTarget='tambahData'>
                Tambah Data
            </x-button.index>
        </div>
        <!-- Table Start -->
        <div class="bg-light rounded p-3">
            <x-heading.table />
            @if($mySelected != NULL)
            <div class="mb-3">
                <x-button.index class="btn-danger" modal="true" dataToggle='modal' dataTarget='hapusSelected'>
                    Hapus {{count($mySelected)}} data
                </x-button.index>
            </div>
            @endif
            <x-table>
                <x-table.thead>
                    <tr class="table-primary">
                        <x-table.th class="text-center">
                            @if($firstId != NULL && !empty($dataPT) && isset($dataPT[0]))
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                wire:model.live='selectAll'>
                            <input type="text" hidden wire:model.live='firstId' value="{{$dataPT[0]->id}}">
                            @endif
                        </x-table.th>
                        <x-table.th>
                            Nama
                            <span wire:click="sortBy('name')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'name' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Slug
                            <span wire:click="sortBy('slug')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'slug' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'slug' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Tanggal dibuat
                            <span wire:click="sortBy('created_at')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th class="text-center">Action</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @if ($dataPT->count() == 0)
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data.</td>
                    </tr>
                    @else
                    @foreach ($dataPT as $dp)
                    <tr>
                        <x-table.td class="text-center">
                            <input class="form-check-input" type="checkbox" value="{{$dp->id}}"
                                wire:model.live='mySelected'>
                        </x-table.td>
                        <x-table.td>{{$dp->name}}</x-table.td>
                        <x-table.td>{{$dp->slug}}</x-table.td>
                        <x-table.td>{{$dp->created_at->format('d M Y')}}</x-table.td>
                        <x-table.td class="text-center">
                            <x-button.index wire:click='ubah({{$dp->id}})' class="btn-success btn-sm">
                                Ubah
                            </x-button.index>
                            <x-button.index wire:click='hapus({{$dp->id}})' class="btn-danger btn-sm">
                                Hapus
                            </x-button.index>
                        </x-table.td>
                    </tr>
                    @endforeach
                    @endif
                </x-table.tbody>
            </x-table>

            {{$dataPT->links()}}
        </div>
        <!-- Table End -->
    </x-content>
</div>