<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelArsipNoSurat extends Model
{
    use HasFactory;

    protected $table = 'tb_arsip_no_surat'; // Sesuaikan dengan nama tabel di database jika diperlukan

    protected $fillable = [
        'id_surat',
        'nomor_surat',
        'pic',
        'tgl_surat',
        'keterangan_arsip',
        'keterangan',
        'file',
    ];

    // Relasi dengan model lain jika diperlukan
    public function noSurat()
    {
        return $this->belongsTo(ModelNoSurat::class, 'id_surat');
    }

    // Metode statis untuk mengupdate status pada ModelNoSurat dan membuat entri baru pada ModelArsipNoSurat
    public static function rejectAndArchive($id, $pic, $tgl_surat, $keterangan, $file, $nomor_surat, $keterangan_arsip)
    {

        // Membuat entri baru pada ModelArsipNoSurat
        self::create([
            'id_surat' => $id,
            'nomor_surat' => $nomor_surat,
            'pic' => $pic,
            'tgl_surat' => $tgl_surat,
            'keterangan' => $keterangan,
            'keterangan_arsip' => $keterangan_arsip,
            'file' => $file,
            // Anda dapat menambahkan atribut lain sesuai kebutuhan
        ]);
        // Update status pada ModelNoSurat
        ModelNoSurat::where('id', $id)->update([
            'file' => NULL,
            'status' => 2,
        ]);
    }
}
