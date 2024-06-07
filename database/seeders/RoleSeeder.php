<?php

namespace Database\Seeders;

use App\Models\ModelRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelRole::create([
            'name' => 'Super Admin'
        ]);
    }
}
