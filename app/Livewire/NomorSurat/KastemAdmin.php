<?php

namespace App\Livewire\NomorSurat;

use App\Models\ModelArsipNoSurat;
use App\Models\ModelNoSurat;
use App\Models\ModelPT;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class KastemAdmin extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField = 'nomor_surat';
    public $sortDirection = 'asc';

    public $id_action;
    public $id, $nomor_surat;
    public $nomorSurat, $status;


    #[Rule('required')]
    public $pt = 'HSB';

    #[Rule('required')]
    public $pic;

    #[Url()]
    public $pt_slug = '';

    public $activeTab = '';

    #[Url()]
    public $search = '';

    #[Rule('required')]
    public $keterangan;

    #[Rule('required|before:today')]
    public $tanggal;


    public $url, $nomor_surat_action, $tgl_surat, $file, $keterangan_arsip;

    #[Url()]
    public $jenisNomorSurat;

    public $daftarNoSurat = [];

    public $dataArsip;

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

    public function nomorSuratHariIni()
    {
        $this->validate([
            'pt' => 'required',
            'pic' => 'required',
            'keterangan' => 'required',
        ]);

        $this->dispatch('show-confrim');
    }

    public function updatedJenisNomorSurat()
    {
        $this->reset('pt', 'pic', 'keterangan', 'nomor_surat');
        $this->resetValidation();
    }

    public function actionNomorSuratHariIni()
    {
        ModelNoSurat::actionNomorSuratHariIniAdmin($this->id_action, $this->pic, $this->nomor_surat, $this->keterangan);

        $this->reset();
        $this->dispatch('hide-confrim');
        $this->dispatch('save', [
            'title' => 'Nomor surat berhasil di digunakan',
            'icon' => 'success',
        ]);
    }

    public function cari()
    {
        // Validasi input
        $this->validate([
            'tanggal' => 'required|date',
            'pt' => 'required',
            'pic' => 'required',
        ]);

        try {

            // Cari nomor surat
            $data = ModelNoSurat::cariNomorSurat($this->pt, $this->tanggal);

            // Set properti kelas
            $this->id_action = $data['id'];
            $this->nomor_surat_action = $data['no_surat'];
            $this->status = $data['status'];

            // Buat array daftarNoSurat
            $this->daftarNoSurat = [
                'nomor_surat' => $data['no_surat'],
                'status' => $data['status'],
                'tgl_surat' => $this->tanggal,
            ];

            $this->dispatch('save', [
                'title' => 'Nomor surat yang ditemukan',
                'icon' => 'success',
            ]);

            // Return daftarNoSurat
            return $this->daftarNoSurat;
        } catch (\Exception $e) {
            dd($e);
            $this->id_action = '';
            $this->nomor_surat_action = '';
            $this->status = '';
            $this->daftarNoSurat = [];
            // Tangani kesalahan lainnya
            return $this->dispatch('save', [
                'title' => 'Tidak ada nomor surat yang ditemukan',
                'icon' => 'error',
            ]);
        }
    }

    public function pilih($id)
    {
        $this->id = $id;
        $data = ModelNoSurat::find($id);


        $this->id_action = $data->id;
        $this->nomor_surat_action = $data->nomor_surat;
        $this->pic = $data->id_user;
        $this->status = $data->status;
        $this->file = $data->file;
        $this->keterangan = $data->keterangan;

        $this->dispatch('show-pilih');
    }

    public function pakai()
    {
        $this->validate(
            [
                'tanggal' => 'required',
                'pic' => 'required',
                'keterangan' => 'required',
            ]
        );

        try {

            $data = ModelNoSurat::find($this->id);
            $pic = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $tgl_surat = $data->tgl_surat;
            $file = $data->file;
            $pt_slug = $data->pt_slug;
            $status = $data->status;
            $nomor_surat = $this->nomor_surat_action;



            ModelNoSurat::updateNoSuratAdmin($this->id, $nomor_surat, $this->tanggal, $this->keterangan, $this->status, $pt_slug, $this->pic);

            if ($this->status == 2) {
                ModelArsipNoSurat::rejectAndArchive(
                    $this->id,
                    $pic,
                    $tgl_surat,
                    $this->keterangan,
                    $file,
                    $nomor_surat,
                    $this->keterangan_arsip,
                );
            }

            $this->reset('pt_slug', 'id', 'nomor_surat_action', 'pic', 'status', 'file', 'keterangan', 'daftarNoSurat', 'tanggal', 'pt');


            $this->dispatch('closePilih');
            $this->dispatch('save', [
                'title' => 'Perubahan berhasil disimpan',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('closePilih');
            $this->dispatch('save', [
                'title' => 'Nomor surat sudah ada',
                'icon' => 'error',
            ]);
        }
    }

    public function closeModel()
    {
        $this->reset('pt', 'pic', 'keterangan', 'nomor_surat');
        $this->resetValidation();
    }

    public function detail($id)
    {

        $data = ModelNoSurat::find($id);

        $this->id = $id;
        $this->nomorSurat = $data;
        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = $data->tgl_surat;
        $this->pic = $data->user->first_name;
        $this->status = $data->status;
        $this->keterangan = $data->keterangan;
        $this->file = $data->file;
        $this->dataArsip = $data->arsipNoSurat()->count();

        $this->dispatch('showDetail');
    }

    public function editData($id)
    {
        $data = ModelNoSurat::find($id);

        $this->id = $data->id;
        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = $data->tgl_surat;
        $this->pic = $data->user->first_name;
        $this->status = $data->status;
        $this->keterangan = $data->keterangan;
        $this->file = $data->file;

        $this->dispatch('showEdit');
    }

    public function downloadFile($id)
    {
        // Temukan data file berdasarkan ID
        $data = ModelNoSurat::find($id);

        dd($data);

        $nomor_surat = $data->nomor_surat;
        $parts_nomor = explode('/', $nomor_surat);

        // Path yang disimpan di database harus sesuai dengan struktur penyimpanan
        $filePath = $data->file; // Misalnya: 'files/UrkIrdTRwAvqTPtgUYrV9JYxXAl3g7V3Wo7Fb75K.pdf'
        $fileName = $parts_nomor[0] . '-' . $data->pt_slug . '-' . Carbon::parse($data->tgl_surat)->isoFormat('D MMMM YYYY');
        $parts = explode('.', $filePath);
        $extension = end($parts);

        // Jangan tambahkan 'public/' lagi jika path sudah benar di database
        if (Storage::exists($filePath)) {
            return Storage::download($filePath, $fileName . '.' . $extension);
        } else {
            return $this->dispatch('save', [
                'title' => 'File tidak ditemukan.',
                'icon' => 'error',
            ]);
        }
    }


    #[Title('Nomor Surat | Kastem Admin')]
    public function render()
    {
        $data = ModelNoSurat::where('pt_slug', 'like', '%' . $this->pt . '%')
            ->where('tahun', Carbon::now()->year)
            ->where('status', 0)
            ->orderBy('id', 'asc')
            ->first();

        if ($data) {
            $this->id_action =  $data->id;
        }

        if ($data) {
            $parts = explode("/", $data->nomor_surat);

            // Konversi format bulan
            $bulan = Carbon::now()->format('n');

            // Konversi bulan menjadi Romawi
            $bulanRomawi = ModelNoSurat::convertToRoman($bulan);

            // Rekonstruksi nomor surat
            $nomor_surat = $parts[0] . '/' . $parts[1] . '/' . $bulanRomawi . '/' . $parts[3];
            $this->nomor_surat = $nomor_surat;
        } else {
            $this->nomor_surat = 'Tidak ada nomor surat';
        }

        if ($this->activeTab == NULL) {
            $activeTab = '%' . $this->activeTab . '%';
        } else {
            $activeTab = $this->activeTab;
        }
        return view('livewire.nomor-surat.kastem-admin', [
            'users' => User::orderBy('first_name', 'asc')->get(),
            'dataPT' => ModelPT::where('slug', '!=', '-')->orderBy('slug', 'asc')->get(),
            'noSurat' => ModelNoSurat::where('pt_slug', 'like', '%' . $this->pt_slug . '%')
                ->where('status', 'like', $activeTab)
                ->where('nomor_surat', 'ilike', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ]);
    }

    public function updated()
    {
        $this->resetPage();
    }
}
