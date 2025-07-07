<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Adi Saputra',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'alamat' => 'Kantor Desa',
                'no_telepon' => '08123456789',
                'jenis_kelamin' => 'Laki-laki',
            ]
        );
    }
}

