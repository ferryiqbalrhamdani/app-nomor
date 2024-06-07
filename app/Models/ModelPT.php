<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPT extends Model
{
    use HasFactory;

    protected $table = 'tb_pt';
    protected $fillable = [
        'name',
        'slug',
    ];

    public function saveData($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->save();
    }

    public function updateData($id, $name, $slug)
    {
        $data = self::find($id);
        if ($data) {
            $data->name = $name;
            $data->slug = $slug;
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
