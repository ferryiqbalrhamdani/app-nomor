<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ModelNoSurat extends Model
{
    use HasFactory;
    protected $table = 'tb_no_surat';

    public static function updateNoSurat($idAction, $nomorSurat, $tanggal, $keterangan, $status, $slug)
    {
        $user_id = Auth::user()->id;
        // dd($status);
        if ($status == 2) {
            return static::where('id', $idAction)->update([
                'nomor_surat' => $nomorSurat,
                'id_user' => $user_id,
                'tgl' => Carbon::parse($tanggal)->format('d'),
                'bulan' => Carbon::parse($tanggal)->format('n'),
                'tgl_surat' => Carbon::parse($tanggal),
                'keterangan' => $keterangan,
                'status' => 1,
            ]);
        } else {
            return static::create([
                'nomor_surat' => $nomorSurat,
                'id_user' => $user_id,
                'pt_slug' => $slug,
                'tgl_surat' => Carbon::parse($tanggal),
                'tgl' => Carbon::parse($tanggal)->format('d'),
                'bulan' => Carbon::parse($tanggal)->format('n'),
                'tahun' => Carbon::parse($tanggal)->format('Y'),
                'keterangan' => $keterangan,
                'status' => $status,
            ]);
        }
    }
    public static function updateNoSuratAdmin($idAction, $nomorSurat, $tanggal, $keterangan, $status, $slug, $user_id)
    {

        $parts = explode("/", $nomorSurat);
        $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
        $no_surat = $parts[0] . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];



        return static::where('id', $idAction)->update([
            'nomor_surat' => $no_surat,
            'id_user' => $user_id,
            'tgl' => Carbon::parse($tanggal)->format('d'),
            'bulan' => Carbon::parse($tanggal)->format('n'),
            'tgl_surat' => Carbon::parse($tanggal),
            'keterangan' => $keterangan,
            'status' => 1,
        ]);
    }

    // public static function cariNomorSurat($pt_slug, $tanggal)
    // {
    //     $data = self::where('pt_slug', $pt_slug)
    //         ->whereDate('tgl_surat',  $tanggal)
    //         ->whereYear('tgl_surat', Carbon::now()->year)
    //         ->where('status', 2)
    //         ->orderBy('id', 'desc')
    //         ->first();
    //     // dd($data);

    //     if ($data) {
    //         if ($data->status == 3) {
    //             $parts = explode("/", $data->nomor_surat);
    //             $length = strlen($parts[0]);

    //             $lastLetter = 'A';
    //             if ($length == 3) {
    //                 $nomor = $parts[0];
    //                 $letter = $lastLetter;
    //             } elseif ($length == 4) {
    //                 $lastLetter = substr($parts[0], 3, 1);
    //                 $nomor = substr($parts[0], 0, 3);
    //                 $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
    //             }

    //             $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
    //             $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];
    //             $status = 3;
    //             $id = $data->id;
    //         } else {
    //             $parts = explode("/", $data->nomor_surat);

    //             $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
    //             $no_surat = $parts[0] . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];
    //             $status = $data->status;
    //             $id = $data->id;
    //         }
    //     }

    //     if (!$data) {
    //         $data = self::where('pt_slug', $pt_slug)
    //             ->whereDate('tgl_surat', '<=', $tanggal)
    //             ->orderBy('nomor_surat', 'desc')
    //             ->first();




    //         $parts = explode("/", $data->nomor_surat);
    //         $length = strlen($parts[0]);

    //         $lastLetter = 'A';
    //         if ($length == 3) {
    //             $nomor = $parts[0];
    //             $letter = $lastLetter;
    //         } elseif ($length == 4) {
    //             $lastLetter = substr($parts[0], 3, 1);
    //             $nomor = substr($parts[0], 0, 3);
    //             $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
    //         }

    //         $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
    //         $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];
    //         $status = 3;
    //         $id = $data->id;
    //     }

    //     if (!$data) {
    //         return null;
    //     }

    //     return [
    //         'no_surat' => $no_surat,
    //         'status' => $status,
    //         'id' => $id,
    //     ];
    // }
    public static function cariNomorSurat($pt_slug, $tanggal)
    {

        // Ambil data sebelumnya
        $dataSama1 = self::where('pt_slug', $pt_slug)
            ->whereDate('tgl_surat',  $tanggal)
            ->whereYear('tgl_surat', Carbon::now()->year)
            ->where('status', 1)
            ->orderBy('nomor_surat', 'desc')
            ->first();

        $dataSama2 = self::where('pt_slug', $pt_slug)
            ->whereDate('tgl_surat',  $tanggal)
            ->whereYear('tgl_surat', Carbon::now()->year)
            ->where('status', 2)
            ->orderBy('nomor_surat', 'asc')
            ->first();

        $dataSama3 = self::where('pt_slug', $pt_slug)
            ->whereDate('tgl_surat',  $tanggal)
            ->whereYear('tgl_surat', Carbon::now()->year)
            ->where('status', 3)
            ->orderBy('nomor_surat', 'desc')
            ->first();

        $dataSebelumnya = self::where('pt_slug', $pt_slug)
            ->whereDate('tgl_surat', '<', $tanggal)
            ->whereYear('tgl_surat', Carbon::now()->year)
            ->orderBy('tgl_surat', 'desc')
            ->get();

        $dataSetelahnya = self::where('pt_slug', $pt_slug)
            ->whereDate('tgl_surat', '>', $tanggal)
            ->whereYear('tgl_surat', Carbon::now()->year)
            ->orderBy('tgl_surat', 'asc')
            ->get();

        $dataSebelum = $dataSebelumnya->first();
        $dataSetelah = $dataSetelahnya->first();


        if ($dataSama2) {
            return [
                'no_surat' => $dataSama2->nomor_surat,
                'status' => $dataSama2->status,
                'id' => $dataSama2->id,
            ];
        }

        if ($dataSama3) {
            $parts = explode("/", $dataSama3->nomor_surat);
            $length = strlen($parts[0]);
            $length = strlen($parts[0]);

            $lastLetter = 'A';
            if ($length == 3) {
                $nomor = $parts[0];
                $letter = $lastLetter;
            } elseif ($length == 4) {
                $lastLetter = substr($parts[0], 3, 1);
                $nomor = substr($parts[0], 0, 3);
                $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
            }

            $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
            $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];

            return [
                'no_surat' => $no_surat,
                'status' => 3,
                'id' => $dataSama3->id,
            ];
        }

        if ($dataSama1) {
            $parts = explode("/", $dataSama1->nomor_surat);
            $length = strlen($parts[0]);
            $length = strlen($parts[0]);

            $lastLetter = 'A';
            if ($length == 3) {
                $nomor = $parts[0];
                $letter = $lastLetter;
            } elseif ($length == 4) {
                $lastLetter = substr($parts[0], 3, 1);
                $nomor = substr($parts[0], 0, 3);
                $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
            }

            $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
            $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];

            return [
                'no_surat' => $no_surat,
                'status' => 3,
                'id' => $dataSama1->id,
            ];
        }

        if ($dataSebelum->status == 2) {
            return [
                'no_surat' => $dataSama2->nomor_surat,
                'status' => $dataSama2->status,
                'id' => $dataSama2->id,
            ];
        }

        if ($dataSebelum->status == 3) {
            $parts = explode("/", $dataSebelum->nomor_surat);
            $length = strlen($parts[0]);
            $length = strlen($parts[0]);

            $lastLetter = 'A';
            if ($length == 3) {
                $nomor = $parts[0];
                $letter = $lastLetter;
            } elseif ($length == 4) {
                $lastLetter = substr($parts[0], 3, 1);
                $nomor = substr($parts[0], 0, 3);
                $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
            }

            $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
            $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];

            return [
                'no_surat' => $no_surat,
                'status' => 3,
                'id' => $dataSebelum->id,
            ];
        }

        if ($dataSebelum->status === 1) {
            $parts = explode("/", $dataSebelum->nomor_surat);
            $length = strlen($parts[0]);
            $length = strlen($parts[0]);

            $lastLetter = 'A';
            if ($length == 3) {
                $nomor = $parts[0];
                $letter = $lastLetter;
            } elseif ($length == 4) {
                $lastLetter = substr($parts[0], 3, 1);
                $nomor = substr($parts[0], 0, 3);
                $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
            }

            $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
            $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];

            return [
                'no_surat' => $no_surat,
                'status' => 3,
                'id' => $dataSebelum->id,
            ];
        }

        if ($dataSetelah->status == 2) {
            return [
                'no_surat' => $dataSama3->nomor_surat,
                'status' => $dataSama3->status,
                'id' => $dataSama3->id,
            ];
        }

        if ($dataSetelah->status == 3) {
            $parts = explode("/", $dataSetelah->nomor_surat);
            $length = strlen($parts[0]);
            $lastLetter = 'A';
            if ($length == 3) {
                $nomor = $parts[0];
                $letter = $lastLetter;
            } elseif ($length == 4) {
                $lastLetter = substr($parts[0], 3, 1);
                $nomor = substr($parts[0], 0, 3);
                $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
            }

            $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
            $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];

            return [
                'no_surat' => $no_surat,
                'status' => 3,
                'id' => $dataSetelah->id,
            ];
        }
        if ($dataSetelah->status == 1) {
            $parts = explode("/", $dataSetelah->nomor_surat);
            $length = strlen($parts[0]);
            $lastLetter = 'A';
            if ($length == 3) {
                $nomor = $parts[0];
                $letter = $lastLetter;
            } elseif ($length == 4) {
                $lastLetter = substr($parts[0], 3, 1);
                $nomor = substr($parts[0], 0, 3);
                $letter = ($lastLetter == 'A') ? 'B' : chr(ord($lastLetter) + 1);
            }

            $bulan = self::convertToRoman(intval(Carbon::parse($tanggal)->format('n')));
            $no_surat = $nomor . $letter  . '/' . $parts[1] . '/' . $bulan . '/' . $parts[3];

            return [
                'no_surat' => $no_surat,
                'status' => 3,
                'id' => $dataSetelah->id,
            ];
        }

        return null;
    }
    public static function generateAndUpdateNomorSurat($id, $nomor_surat, $keterangan)
    {

        // Update data nomor surat
        self::where('id', $id)->update([
            'nomor_surat' => $nomor_surat,
            'id_user' => Auth::user()->id,
            'tgl' => Carbon::now()->format('d'),
            'bulan' => Carbon::now()->format('n'),
            'tgl_surat' => Carbon::now(),
            'keterangan' => $keterangan,
            'status' => 1,
        ]);
    }
    public static function actionNomorSuratHariIniAdmin($id, $pic, $nomor_surat, $keterangan)
    {

        // Update data nomor surat
        self::where('id', $id)->update([
            'nomor_surat' => $nomor_surat,
            'id_user' => $pic,
            'tgl' => Carbon::now()->format('d'),
            'bulan' => Carbon::now()->format('n'),
            'tgl_surat' => Carbon::now(),
            'keterangan' => $keterangan,
            'status' => 1,
        ]);
    }

    public static function generateNomorSuratAdmin($id, $tgl_surat, $pic, $keterangan)
    {

        $data = self::where('id', $id)->first();

        if ($data) {
        }

        $parts = explode("/", $data->nomor_surat);

        // Konversi format bulan
        $bulan = Carbon::parse($tgl_surat)->format('n');

        // Konversi bulan menjadi Romawi
        $bulanRomawi = self::convertToRoman($bulan);

        // Rekonstruksi nomor surat
        $nomor_surat = $parts[0] . '/' . $parts[1] . '/' . $bulanRomawi . '/' . $parts[3];


        // Update data nomor surat
        self::where('id', $id)->update([
            'nomor_surat' => $nomor_surat,
            'id_user' => $pic,
            'tgl' => Carbon::parse($tgl_surat)->format('d'),
            'bulan' => Carbon::parse($tgl_surat)->format('n'),
            'tgl_surat' => Carbon::parse($tgl_surat),
            'keterangan' => $keterangan,
            'status' => 1,
        ]);
    }
    public static function momorSuratAdmin($nomor_surat, $tgl_surat, $pic, $keterangan)
    {

        $data = self::where('nomor_surat', $nomor_surat)->first();
        $id = $data->id;

        dd($data);

        $parts = explode("/", $data->nomor_surat);

        // Konversi format bulan
        $bulan = Carbon::parse($tgl_surat)->format('n');

        // Konversi bulan menjadi Romawi
        $bulanRomawi = self::convertToRoman($bulan);

        // Rekonstruksi nomor surat
        $nomor_surat = $parts[0] . '/' . $parts[1] . '/' . $bulanRomawi . '/' . $parts[3];


        // Update data nomor surat
        self::where('id', $id)->update([
            'nomor_surat' => $nomor_surat,
            'id_user' => $pic,
            'tgl' => Carbon::parse($tgl_surat)->format('d'),
            'bulan' => Carbon::parse($tgl_surat)->format('n'),
            'tgl_surat' => Carbon::parse($tgl_surat),
            'keterangan' => $keterangan,
            'status' => 1,
        ]);
    }

    public static function generateAndNomorSuratAdmin($id, $tanggal, $id_user)
    {
        $data = self::where('id', $id)->first();

        // Pastikan $data tidak null sebelum dipecah
        if ($data) {
            $parts = explode("/", $data->nomor_surat);

            // Konversi format bulan
            $bulan = Carbon::parse($tanggal)->format('n');

            // Konversi bulan menjadi Romawi
            $bulanRomawi = self::convertToRoman($bulan);

            // Rekonstruksi nomor surat
            $nomor_surat = $parts[0] . '/' . $parts[1] . '/' . $bulanRomawi . '/' . $parts[3];

            // Update data nomor surat
            self::where('id', $id)->update([
                'nomor_surat' => $nomor_surat,
                'id_user' => $id_user,
                'tgl' => Carbon::parse($tanggal)->format('d'),
                'bulan' => $bulan,
                'tgl_surat' => $tanggal,
                'status' => 1,
            ]);
        } else {
            dd("Data nomor surat tidak ditemukan");
        }
    }


    protected static function convertToRoman($num)
    {
        $romanNumeralMap = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $romanNumeralMap[$num];
    }

    public function updateStatus($id, $status, $keterangan)
    {
        $model = static::findOrFail($id);
        $model->status = $status;
        $model->keterangan = $keterangan;
        $model->save();
    }

    protected $fillable = [
        'nomor_surat',
        'pt_slug',
        'tgl',
        'bulan', 'tahun',
        'id_user',
        'tgl_surat',
        'status',
        'keterangan',
        'file',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function arsipNoSurat()
    {
        return $this->hasMany(ModelArsipNoSurat::class, 'id_surat');
    }
}
