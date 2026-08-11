<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'H. Ahmad Fauzi, S.STP', 'jabatan' => 'Lurah', 'urutan' => 1],
            ['nama' => 'Rina Wulandari, S.Sos', 'jabatan' => 'Sekretaris Lurah', 'urutan' => 2],
            ['nama' => 'Budi Santoso, S.E', 'jabatan' => 'Kasi Pemerintahan', 'urutan' => 3],
            ['nama' => 'Sri Wahyuni, A.Md', 'jabatan' => 'Kasi Kesejahteraan Sosial', 'urutan' => 4],
        ];

        foreach ($data as $item) {
            Pegawai::create([
                'nama' => $item['nama'],
                'jabatan' => $item['jabatan'],
                'urutan' => $item['urutan'],
                'is_active' => true,
            ]);
        }
    }
}
