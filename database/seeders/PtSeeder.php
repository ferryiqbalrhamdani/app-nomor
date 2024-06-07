<?php

namespace Database\Seeders;

use App\Models\ModelPT;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelPT::create([
            'name' => 'PT. Mitra Harapan Abadi',
            'slug' => 'MHA',
        ]);
    }
}
