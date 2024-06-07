<?php

namespace App\Livewire\DataMaster;

use App\Models\ModelRole;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DataRole extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Rule('required', as: 'Nama')]
    public $name;

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

    public function updatedSearch()
    {
        $this->resetPage();
        $this->reset('mySelected', 'selectAll', 'firstId', 'lastId');
    }

    public function resetSelected()
    {
        $this->mySelected = [];
        $this->selectAll = false;
    }

    public function updatedMySelected()
    {
        // dd($value);


        $roles = ModelRole::where('name', 'ilike', '%' . $this->search . '%')
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
            $this->mySelected = ModelRole::where('name', 'ilike', '%' . $this->search . '%')
                ->whereBetween('id', [$this->firstId, $this->lastId])
                ->pluck('id');
        } else {
            $this->mySelected = [];
        }
    }

    public function hapusSelected()
    {
        ModelRole::whereIn('id', $this->mySelected)->delete();

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

        $modelRole = new ModelRole();
        $modelRole->saveData($this->name);


        $this->name = '';
        $this->dispatch('closeSave');
        $this->dispatch('save', [
            'title' => 'Data berhasil ditambah.',
            'icon' => 'success',
        ]);
    }

    public function ubah($id)
    {
        $modelRole = ModelRole::find($id);
        $this->id = $modelRole->id;
        $this->name = $modelRole->name;
        $this->dispatch('showUbah');
    }

    public function actionUbah()
    {
        $this->validate();

        $modelRole = new ModelRole();
        $modelRole->updateData($this->id, $this->name);


        $this->id = '';
        $this->name = '';
        $this->dispatch('closeUbah');
        $this->dispatch('save', [
            'title' => 'Data berhasil diubah.',
            'icon' => 'success',
        ]);
    }

    public function hapus($id)
    {
        $modelRole = ModelRole::find($id);
        $this->id = $modelRole->id;
        $this->name = $modelRole->name;

        $this->dispatch('showHapus');
    }

    public function actionHapus()
    {

        $modelRole = new ModelRole();
        $modelRole->deleteData($this->id);

        $this->id = '';
        $this->name = '';

        $this->dispatch('closeHapus');
        $this->dispatch('save', [
            'title' => 'Data berhasil dihapus.',
            'icon' => 'success',
        ]);
    }

    public function closeModel()
    {
        $this->reset('name');
        $this->resetValidation();
    }

    #[Title('Data Role')]
    public function render()
    {
        $roles = ModelRole::where('name', 'ilike', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $data = $roles->count();
        if ($data > 0) {
            $this->firstId = $roles[$data - 1]->id;
            $this->lastId = $roles[0]->id;
        } else {
            $this->firstId = 0;
            $this->lastId = 0;
        }

        return view('livewire.data-master.data-role', [
            'roles' => $roles,
        ]);
    }
}
