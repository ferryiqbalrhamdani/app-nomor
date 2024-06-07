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

class Kastem extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField = 'nomor_surat';
    public $sortDirection = 'asc';

    public $id_action;
    public $id, $nomor_surat;

    #[Url()]
    public $pt_slug = '';

    #[Url()]
    public $activeTab = '';

    #[Rule('required')]
    #[Rule('before:today', message: "Tidak boleh sama atau melebihi dengan tanggal hari ini")]
    public $tanggal;
    #[Rule('required', as: "PT")]
    public $slug;

    public $daftarNoSurat = [];
    public $nomorSurat = [];

    public $dataArsip;




    #[Url()]
    public $search = '';

    public $generate = '';

    #[Rule('required')]
    public $keterangan;

    public $nomor_surat_action, $tgl_surat, $status, $pic, $file, $file_upload;

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

    public function cari()
    {
        // Validasi input
        $this->validate([
            'tanggal' => 'required|before:today',
            'slug' => 'required',
        ]);
        try {

            // Cari nomor surat
            $data = ModelNoSurat::cariNomorSurat($this->slug, $this->tanggal);

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

            // Return daftarNoSurat
            return $this->daftarNoSurat;
        } catch (\Exception $e) {
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

    public function pakai()
    {
        $this->dispatch('show-confirm-pakai');
    }

    public function actionPakai()
    {
        $this->validate();

        try {

            $data = ModelNoSurat::find($this->id_action);
            $pic = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $tgl_surat = $data->tgl_surat;
            $file = $data->file;
            $nomor_surat = $this->nomor_surat_action;
            $keterangan = $data->keterangan;

            ModelNoSurat::updateNoSurat($this->id_action, $nomor_surat, $this->tanggal, $this->keterangan, $this->status, $this->slug);

            if ($this->status == 2) {
                ModelArsipNoSurat::rejectAndArchive($this->id_action, $pic, $tgl_surat, $this->keterangan, $file, $nomor_surat, $keterangan);
            }

            $this->id_action = '';
            $this->nomor_surat_action = '';
            $this->activeTab = 1;
            $this->keterangan = '';
            $this->tanggal = '';
            $this->slug = '';
            $this->daftarNoSurat = [];

            $this->sortField = 'updated_at';
            $this->sortDirection = 'desc';


            $this->dispatch('closePakai');
            $this->dispatch('save', [
                'title' => 'Nomor surat berhasil di pakai',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('closePakai');
            $this->dispatch('save', [
                'title' => 'Nomor surat sudah ada',
                'icon' => 'error',
            ]);
        }
    }

    public function reject($id)
    {

        $this->id_action = $id;
        $data = ModelNoSurat::find($this->id_action);

        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = Carbon::parse($data->tgl_surat)->isoFormat('D MMMM Y');

        $this->dispatch('show-confirm-reject');
    }

    public function actionReject()
    {
        $this->validateOnly('keterangan');
        // dd('ok');

        $data = ModelNoSurat::find($this->id_action);
        $pic = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $tgl_surat = $data->tgl_surat;
        $file = $data->file;
        $keterangan = $data->keterangan;
        $nomor_surat = $this->nomor_surat_action;

        ModelNoSurat::where('id', $this->id_action)->update(['status' => 3]);

        ModelArsipNoSurat::rejectAndArchive($this->id_action, $pic, $tgl_surat, $this->keterangan, $file, $nomor_surat, $keterangan);

        $this->id_action = '';
        $this->nomor_surat_action = '';
        $this->tgl_surat = '';
        $this->keterangan = '';

        $this->dispatch('closeReject');
        $this->dispatch('save', [
            'title' => 'Perubahan berhasil disimpan',
            'icon' => 'success',
        ]);
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

    public function edit($id)
    {
        $data = ModelNoSurat::find($id);

        $this->id = $data->id;
        $this->nomor_surat_action = $data->nomor_surat;
        $this->tgl_surat = $data->tgl_surat;
        $this->pic = $data->user->first_name;
        $this->status = $data->status;
        $this->keterangan = $data->keterangan;
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

    public function closeModel()
    {
        $this->id_action = '';

        $this->nomorSurat = '';
        $this->nomor_surat_action = '';
        $this->tgl_surat = '';
        $this->pic = '';
        $this->status = '';
        $this->keterangan = '';
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

    #[Title('Nomor Surat | Kastem')]
    public function render()
    {
        if ($this->generate == NULL) {
            $generate = '%' . $this->generate . '%';
        } else {
            $generate = $this->generate;
        }
        return view('livewire.nomor-surat.kastem', [
            'dataPT' => ModelPT::where('slug', '!=', '-')->orderBy('slug', 'asc')->get(),
            'noSurat' => ModelNoSurat::where('pt_slug', 'like', '%' . $this->pt_slug . '%')
                ->where('id_user', 'like', $generate)
                ->whereYear('tgl_surat', Carbon::now()->year)
                ->where('status', '>', 0)
                ->where('status', 'like', '%' . $this->activeTab . '%')
                ->where('nomor_surat', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ]);
    }
}
