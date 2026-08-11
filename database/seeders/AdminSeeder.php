<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@okura.id'], // Parameter 1: Kriteria pencarian (Unique Key)
            [                              // Parameter 2: Data yang dibuat atau diperbarui
                'name'     => 'Admin Kelurahan',
                'password' => Hash::make('password123'),
                'role'     => 'super_admin',
            ]
        );
    }
}
