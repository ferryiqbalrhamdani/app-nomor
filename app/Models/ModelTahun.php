<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTahun extends Model
{
    use HasFactory;
    protected $table = 'tb_tahun';
    protected $guarded = ['id'];
    protected $fillable = [
        'nama_tahun'
    ];
}
