<?php

namespace Database\Seeders;

use App\Models\Umkm;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_usaha' => 'Keripik Singkong Bu Siti', 'nama_pemilik' => 'Siti Aminah', 'kategori' => 'kuliner'],
            ['nama_usaha' => 'Anyaman Rotan Pak Jamal', 'nama_pemilik' => 'Jamaludin', 'kategori' => 'kerajinan'],
            ['nama_usaha' => 'Bengkel Motor Okura Jaya', 'nama_pemilik' => 'Rudi Hartono', 'kategori' => 'jasa'],
            ['nama_usaha' => 'Sayur Hidroponik Okura', 'nama_pemilik' => 'Dedi Kurniawan', 'kategori' => 'pertanian'],
        ];

        foreach ($data as $item) {
            Umkm::create([
                'nama_usaha' => $item['nama_usaha'],
                'nama_pemilik' => $item['nama_pemilik'],
                'kategori' => $item['kategori'],
                'deskripsi' => 'Usaha milik warga Kelurahan Tebing Tinggi Okura yang telah berjalan beberapa tahun dan menjadi bagian dari ekonomi lokal.',
                'alamat' => 'Kelurahan Tebing Tinggi Okura, Rumbai Pesisir, Pekanbaru',
                'latitude' => 0.6183 + (rand(-50, 50) / 10000),
                'longitude' => 101.5854 + (rand(-50, 50) / 10000),
                'no_hp' => '0812-345-' . rand(1000, 9999),
                'status' => 'aktif',
            ]);
        }
    }
}
