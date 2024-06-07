<?php

namespace App\Livewire\DataMaster;

use App\Models\ModelPT;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DataPt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Rule('required', as: 'Nama')]
    public $name;
    #[Rule('required')]
    public $slug;

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


        $dataPT = ModelPT::where('name', 'ilike', '%' . $this->search . '%')
            ->orWhere('slug', 'ilike', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);


        if (count($this->mySelected) == $dataPT->count()) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->mySelected = ModelPT::where('name', 'ilike', '%' . $this->search . '%')
                ->orWhere('slug', 'ilike', '%' . $this->search . '%')
                ->whereBetween('id', [$this->firstId, $this->lastId])
                ->pluck('id');
        } else {
            $this->mySelected = [];
        }
    }

    public function hapusSelected()
    {
        ModelPT::whereIn('id', $this->mySelected)->delete();

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

    public function closeModel()
    {
        $this->reset('name', 'slug');
        $this->resetValidation();
    }

    public function actionTambah()
    {
        $this->validate();

        $ModelPT = new ModelPT();
        $ModelPT->saveData($this->name, $this->slug);


        $this->reset('name', 'slug');

        $this->dispatch('closeSave');
        $this->dispatch('save', [
            'title' => 'Data berhasil ditambah.',
            'icon' => 'success',
        ]);
    }

    public function ubah($id)
    {
        $ModelPT = ModelPT::find($id);
        $this->id = $ModelPT->id;
        $this->name = $ModelPT->name;
        $this->slug = $ModelPT->slug;
        $this->dispatch('showUbah');
    }

    public function actionUbah()
    {
        $this->validate();

        $ModelPT = new ModelPT();
        $ModelPT->updateData($this->id, $this->name, $this->slug);


        $this->reset('name', 'slug', 'id');

        $this->dispatch('closeUbah');
        $this->dispatch('save', [
            'title' => 'Data berhasil diubah.',
            'icon' => 'success',
        ]);
    }

    public function hapus($id)
    {
        $ModelPT = ModelPT::find($id);
        $this->id = $ModelPT->id;
        $this->name = $ModelPT->name;

        $this->dispatch('showHapus');
    }

    public function actionHapus()
    {

        $ModelPT = new ModelPT();
        $ModelPT->deleteData($this->id);

        $this->reset('name', 'id');


        $this->dispatch('closeHapus');
        $this->dispatch('save', [
            'title' => 'Data berhasil dihapus.',
            'icon' => 'success',
        ]);
    }

    #[Title('Data PT')]
    public function render()
    {
        $dataPT = ModelPT::where('name', 'ilike', '%' . $this->search . '%')
            ->orWhere('slug', 'ilike', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $data = $dataPT->count();
        if ($data > 0) {
            $this->firstId = $dataPT[$data - 1]->id;
            $this->lastId = $dataPT[0]->id;
        } else {
            $this->firstId = 0;
            $this->lastId = 0;
        }

        return view('livewire.data-master.data-pt', [
            'dataPT' => $dataPT
        ]);
    }
}
