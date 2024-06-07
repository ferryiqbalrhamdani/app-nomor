<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $first_name = 'ferry';
        User::create([
            'username' => User::generateUniqueUsername($first_name),
            'first_name' => $first_name,
            'last_name' => 'iqbal rhamdani',
            'password' => Hash::make('user123'), // Default password
            'jk' => 'l',
            'is_password' => false,
            'role_id' => 1,
            'pt_id' => 1,
            'status' => true,
        ]);
    }
}
