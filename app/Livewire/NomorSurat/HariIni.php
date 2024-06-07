<?php

namespace App\Livewire\NomorSurat;

use App\Models\ModelArsipNoSurat;
use App\Models\ModelNoSurat;
use App\Models\ModelPT;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class HariIni extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public $id_action;
    public $id, $nomor_surat;
    public $nomorSurat, $status;


    #[Url()]
    public $pt = 'HSB';
    #[Url()]
    public $pt_slug = '';

    public $activeTab = '';

    #[Url()]
    public $search = '';

    #[Rule('required')]
    public $keterangan;


    public $url, $nomor_surat_action, $tgl_surat, $pic, $file, $file_upload, $keterangan_arsip;





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

    public function gunakan($id)
    {
        $this->id_action = $id;

        $this->dispatch('show-confirm-gunakan');
    }

    public function pakai()
    {
        $this->validate();

        $data = ModelNoSurat::where('id', $this->id_action)->first();

        if ($data->status == 0 || $data->status == 2) {

            ModelNoSurat::generateAndUpdateNomorSurat($this->id_action, $this->nomor_surat, $this->keterangan);

            $this->id_action = '';
            $this->activeTab = Auth::user()->id;
            $this->keterangan = '';


            $this->dispatch('closePakai');
            $this->dispatch('save', [
                'title' => 'Nomor surat berhasil di pakai',
                'icon' => 'success',
            ]);
        } else {
            $this->dispatch('save', [
                'title' => 'Nomor surat sudah digunakan',
                'icon' => 'error',
            ]);
        }
    }

    public function reject($id)
    {
        $this->id = $id;
        $data = ModelNoSurat::find($this->id);
        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = $data->tgl_surat;
        $this->pic = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $this->file = $data->file;
        $this->keterangan_arsip = $data->keterangan;



        $this->dispatch('show-confirm-reject');
    }

    public function actionReject()
    {
        $this->validate();


        // Panggil metode statis untuk mengupdate status pada ModelNoSurat dan membuat entri baru pada 

        ModelArsipNoSurat::rejectAndArchive(
            $this->id,
            $this->pic,
            $this->tgl_surat,
            $this->keterangan,
            $this->file,
            $this->nomor_surat_action,
            $this->keterangan_arsip,
        );

        $this->reset('id', 'pic', 'tgl_surat', 'keterangan', 'file', 'nomor_surat_action', 'keterangan_arsip');

        $this->dispatch('closeReject');

        $this->dispatch('save', [
            'title' => 'Nomor surat berhasila di reject',
            'icon' => 'success',
        ]);
    }

    public function detail($id)
    {

        $this->id_action = $id;
        $data = ModelNoSurat::find($this->id_action);

        $this->id = $data->id;
        $this->nomorSurat = $data;
        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = $data->tgl_surat;
        $this->pic = $data->user->first_name;
        $this->status = $data->status;
        $this->file = $data->file;
        $this->keterangan_arsip = $data->keterangan_arsip;
        $this->keterangan = $data->keterangan;

        // dd($data->arsipNoSurat);

        $this->dispatch('show-detail');
    }


    public function closeDetail()
    {
        $this->id_action = '';

        $this->nomorSurat = '';
        $this->nomor_surat_action = '';
        $this->tgl_surat = '';
        $this->pic = '';
        $this->status = '';
        $this->keterangan = '';
    }

    public function edit($id)
    {

        $data = ModelNoSurat::find($id);
        $this->id = $data->id;
        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = Carbon::parse($data->tgl_surat)->format('d-m-Y'); // $data->tgl_surat;
        $this->keterangan = $data->keterangan;
        $this->pic = $data->user->first_name;
        $this->status = $data->status;
        $this->file = $data->file;





        $this->dispatch('show-edit');
    }

    public function editNomorSurat()
    {
        $this->validate([
            'keterangan' => 'required',
        ]);

        if ($this->file_upload != NULL) {
            if ($this->file != NULL) {
                Storage::delete($this->file);
            }
            $this->file_upload = $this->file_upload->store('public/files');
        } else {
            $this->file_upload = $this->file;
        }

        ModelNoSurat::where('id', $this->id)->update([
            'keterangan' => $this->keterangan,
            'file' => $this->file_upload,
        ]);

        $this->reset('id_action', 'file', 'file_upload', 'nomor_surat', 'tgl_surat', 'pic', 'status', 'keterangan');


        $this->dispatch('closeEdit');

        $this->dispatch('save', [
            'title' => 'Nomor surat berhasil diubah',
            'icon' => 'success',
        ]);
    }
    public function downloadFile($id)
    {
        // Temukan data file berdasarkan ID
        $data = ModelNoSurat::find($id);

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

    public function closeModel()
    {
        $this->reset('id_action', 'file', 'file_upload', 'nomor_surat', 'tgl_surat', 'pic', 'status', 'keterangan');
        $this->resetValidation();
    }

    #[Title('Nomor Surat | Hari Ini')]
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

        return view('livewire.nomor-surat.hari-ini', [
            'dataPT' => ModelPT::orderBy('slug', 'asc')->get(),
            'noSurat' => ModelNoSurat::where('pt_slug', 'like', '%' . $this->pt_slug . '%')
                ->whereYear('tgl_surat', Carbon::now()->year)
                ->where('status', '>', 0)
                ->where('nomor_surat', 'like', '%' . $this->search . '%')
                ->where('id_user', 'like', $activeTab)
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }

    public function updated()
    {
        $this->resetPage();
    }
}
