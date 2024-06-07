<?php

namespace App\Livewire\DataMaster;

use App\Models\ModelPT;
use App\Models\ModelRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DataUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id;
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search;

    public $mySelected = [];
    public $selectAll = false;
    public $firstId = NULL;
    public $lastId = NULL;

    public $username;
    public $password;
    public $last_name;
    public $status;

    #[Rule('required')]
    public $first_name;
    #[Rule('required', as: 'jenis kelamin')]
    public $jk = 'l';
    #[Rule('required', as: 'role user')]
    public $role_id;
    #[Rule('required', as: 'pt')]
    public $pt_id;

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetSelected()
    {
        $this->mySelected = [];
        $this->selectAll = false;
    }

    public function resetPassword($id)
    {
        $User = User::find($id);
        $User->is_password = 0;
        $User->password = Hash::make('user123');
        $User->save();
        $this->dispatch('save', [
            'title' => 'Password Berhasil di ubah.',
            'icon' => 'success',
        ]);
    }

    public function updatedMySelected()
    {
        // dd($value);


        $roles = User::where('first_name', 'ilike', '%' . $this->search . '%')
            ->orWhere('last_name', 'ilike', '%' . $this->search . '%')
            ->orWhere('username', 'ilike', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);


        if (count($this->mySelected) == $roles->count()) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->mySelected = User::where('first_name', 'ilike', '%' . $this->search . '%')
                ->orWhere('last_name', 'ilike', '%' . $this->search . '%')
                ->orWhere('username', 'ilike', '%' . $this->search . '%')
                ->whereBetween('id', [$this->firstId, $this->lastId])
                ->pluck('id');
        } else {
            $this->mySelected = [];
        }
    }

    public function hapusSelected()
    {
        User::whereIn('id', $this->mySelected)->delete();

        $this->mySelected = [];
        $this->selectAll = false;

        $this->dispatch('closeHapusSelected');
        $this->dispatch('save', [
            'title' => 'Data Berhasil di hapus.',
            'icon' => 'success',
        ]);
    }

    public function sortBy($sortField)
    {
        if ($this->sortField === $sortField) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $sortField;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function actionTambah()
    {
        $this->validate();


        $User = new User();
        $username = $User->generateUniqueUsername($this->first_name);
        $User->createUser($username, $this->first_name, $this->last_name, $this->jk, $this->role_id, $this->pt_id);


        $this->reset();

        $this->dispatch('closeSave');
        $this->dispatch('save', [
            'title' => 'Data berhasil ditambah.',
            'icon' => 'success',
        ]);
    }

    public function ubah($id)
    {
        $User = User::find($id);
        $this->id = $User->id;
        $this->first_name = $User->first_name;
        $this->last_name = $User->last_name;
        $this->jk = $User->jk;
        $this->role_id = $User->role_id;
        $this->pt_id = $User->pt_id;
        $this->status = $User->status;

        $this->dispatch('showUbah');
    }

    public function actionUbah()
    {
        $this->validate();

        $User = new User();
        $User->updateUser(
            $this->id,
            $this->first_name,
            $this->last_name,
            $this->jk,
            $this->role_id,
            $this->pt_id,
            $this->status,
        );


        $this->reset();

        $this->dispatch('closeUbah');
        $this->dispatch('save', [
            'title' => 'Data berhasil diubah.',
            'icon' => 'success',
        ]);
    }

    public function hapus($id)
    {
        $User = User::find($id);
        $this->id = $User->id;
        $this->first_name = $User->first_name;

        $this->dispatch('showHapus');
    }

    public function actionHapus()
    {

        $User = new User();
        $User->deleteData($this->id);

        $this->reset();

        $this->dispatch('closeHapus');
        $this->dispatch('save', [
            'title' => 'Data berhasil dihapus.',
            'icon' => 'success',
        ]);
    }

    public function detail($id)
    {
        $User = User::find($id);
        $this->id = $User->id;
        $this->first_name = $User->first_name;
        $this->last_name = $User->last_name;
        $this->username = $User->username;
        $this->jk = $User->jk;
        $this->role_id = $User->role->name;
        $this->pt_id = $User->pt->name;
        $this->status = $User->status;
        $this->dispatch('showDetail');
    }

    public function closeModel()
    {
        $this->reset();
        $this->resetValidation();
    }
    #[Title('Data Users')]
    public function render()
    {
        $users = User::where('first_name', 'ilike', '%' . $this->search . '%')
            ->orWhere('last_name', 'ilike', '%' . $this->search . '%')
            ->orWhere('username', 'ilike', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $data = $users->count();
        if ($data > 0) {
            $this->firstId = $users[$data - 1]->id;
            $this->lastId = $users[0]->id;
        } else {
            $this->firstId = 0;
            $this->lastId = 0;
        }
        return view('livewire.data-master.data-users', [
            'users' => $users,
            'roles' => ModelRole::all(),
            'pt' => ModelPT::orderBy('name', 'asc')->get(),
        ]);
    }
}
