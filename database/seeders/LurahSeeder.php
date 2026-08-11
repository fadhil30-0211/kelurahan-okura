<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LurahSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Lurah Tebing Tinggi Okura',
            'email'    => 'lurah@okura.id',
            'password' => Hash::make('password123'),
            'role'     => 'lurah',
        ]);
    }
}
