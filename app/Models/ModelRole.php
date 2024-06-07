<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelRole extends Model
{
    use HasFactory;

    protected $table = 'tb_role';
    protected $fillable = ['name'];

    public function saveData($name)
    {
        self::create([
            'name' => $name
        ]);
    }

    public function updateData($id, $name)
    {
        $data = self::find($id);
        if ($data) {
            $data->name = $name;
            $data->save();
            return true; // Berhasil mengupdate
        }
        return false; // Gagal, data tidak ditemukan
    }

    public function deleteData($id)
    {
        $data = self::find($id);
        if ($data) {
            $data->delete();
            return true; // Berhasil menghapus
        }
        return false; // Gagal, data tidak ditemukan
    }
}
