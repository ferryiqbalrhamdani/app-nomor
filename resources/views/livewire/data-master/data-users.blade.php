<div>
    @include('modal.data-master.data-users-modal')
    <x-slot name="header">
        Data Users
        <x-slot name="breadcrumb">
            <x-breadcrumb>
                Data Master
            </x-breadcrumb>
            <x-breadcrumb>
                Data Users
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
            <x-table>
                <x-table.thead>
                    <tr class="table-primary">
                        <x-table.th>
                            Username
                            <span wire:click="sortBy('username')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'username' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'username' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Nama
                            <span wire:click="sortBy('first_name')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'first_name' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'first_name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Jenis Kelamin
                            <span wire:click="sortBy('jk')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'jk' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'jk' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th>
                            Role
                            <span wire:click="sortBy('role_id')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'role_id' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'role_id' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                        <x-table.th>
                            Password
                            <span wire:click="sortBy('is_password')" style="cursor: pointer; font-size: 10px">
                                <i
                                    class="fa fa-arrow-up {{$sortField === 'is_password' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                <i
                                    class="fa fa-arrow-down {{$sortField === 'is_password' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                            </span>
                        </x-table.th>
                        <x-table.th class="text-center">Action</x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @if ($users->count() == 0)
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data.</td>
                    </tr>
                    @else
                    @foreach ($users as $u)
                    <tr>
                        <x-table.td>{{$u->username}}</x-table.td>
                        <x-table.td>{{$u->first_name.' '.$u->last_name}}</x-table.td>
                        <x-table.td>
                            @if ($u->jk == 'l')
                            Laki-laki
                            @else
                            Perempuan
                            @endif
                        </x-table.td>
                        <x-table.td>
                            {{$u->role->name}}
                        </x-table.td>
                        <x-table.td>{{$u->created_at->format('d M Y')}}</x-table.td>
                        <x-table.td class="text-center">
                            @if ($u->is_password == true)
                            <x-button.index wire:click='resetPassword({{$u->id}})' as="link"
                                class="btn-info btn-sm w-100">
                                <i class="fas fa-undo"></i>
                            </x-button.index>
                            @else
                            -
                            @endif
                        </x-table.td>
                        <x-table.td class="text-center">
                            <x-button.index wire:click='detail({{$u->id}})' class="btn-sm">
                                Detail
                            </x-button.index>
                            <x-button.index wire:click='ubah({{$u->id}})' class="btn-success btn-sm">
                                Ubah
                            </x-button.index>
                            <x-button.index wire:click='hapus({{$u->id}})' class="btn-danger btn-sm">
                                Hapus
                            </x-button.index>
                        </x-table.td>
                    </tr>
                    @endforeach
                    @endif
                </x-table.tbody>
            </x-table>

            {{$users->links()}}
        </div>
        <!-- Table End -->
    </x-content>
</div>