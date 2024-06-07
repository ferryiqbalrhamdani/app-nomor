<?php

namespace App\Livewire\DataMaster;

use App\Models\ModelNoSurat;
use App\Models\ModelPT;
use App\Models\ModelTahun;
use Carbon\Carbon;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class NomorSurat extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    #[Url()]
    public $sortField = 'created_at';
    #[Url()]
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    #[Rule('required')]
    public $nama_tahun;
    #[Rule('required')]
    public $namaPt;

    #[Url()]
    public $url;



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

    public function saveTahun()
    {
        $data = ModelTahun::where('nama_tahun', $this->nama_tahun)->first();
        if ($data) {
            $this->dispatch('save', [
                'title' => 'Tahun Sudah Ada.',
                'icon' => 'error',
            ]);
        } else {
            $data = new ModelTahun();
            $data->nama_tahun = $this->nama_tahun;
            $data->save();

            $this->dispatch('closeSaveTahun');
            $this->dispatch('save', [
                'title' => 'Berhasil ditambahkan.',
                'icon' => 'success',
            ]);
        }
    }

    #[Title('Data Nomor Surat')]
    public function save()
    {
        $data = ModelNoSurat::where('pt_slug', $this->namaPt)
            ->where('tahun', Carbon::now()->format('Y'))
            ->first();
        if ($data) {
            $this->dispatch('save', [
                'title' => 'Data Sudah Ada.',
                'icon' => 'error',
            ]);
        } else {
            for ($i = 1; $i <= 999; $i++) {
                $code = str_pad($i, 3, '0', STR_PAD_LEFT); // Membuat nomor dengan 3 digit, diisi dengan 0 di depan jika kurang dari 3 digit
                $data = "{$code}/" . $this->namaPt . "/0/" . Carbon::now()->format('Y'); // Menggabungkan nomor dengan string lainnya

                ModelNoSurat::create([
                    'nomor_surat' => $data,
                    'pt_slug' => $this->namaPt,
                    'tahun' => Carbon::now()->format('Y'),
                ]);
            }

            $this->dispatch('closeSave');
            $this->dispatch('save', [
                'title' => 'Berhasil ditambahkan.',
                'icon' => 'success',
            ]);
        }
    }

    public function closeModel()
    {
        $this->reset();
        $this->resetValidation();
    }

    #[Title('Data No Surat')]
    public function render()
    {
        $this->nama_tahun = Carbon::now()->year;


        return view('livewire.data-master.nomor-surat', [
            'noSurat' => ModelNoSurat::where('tahun', Carbon::now()->year)
                ->where('nomor_surat', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'dataPT' => ModelPT::orderBy('slug', 'asc')->get(),
            'tahun' => ModelTahun::orderBy('id', 'desc')->get(),
            'dataNosurat' => ModelNoSurat::all(),
        ]);
    }
}
