<?php

namespace Database\Seeders;

use App\Models\Wisata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WisataSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Wisata Berkuda Okura', 'deskripsi' => 'Area berkuda dengan pemandangan alam khas Okura, cocok untuk keluarga dan wisata edukasi.', 'harga_tiket' => 'Rp 25.000/orang', 'jam_operasional' => '08.00 - 17.00 WIB'],
            ['nama' => 'Tepian Sungai Siak Okura', 'deskripsi' => 'Spot bersantai dan memancing di tepian Sungai Siak dengan suasana asri.', 'harga_tiket' => 'Gratis', 'jam_operasional' => '24 jam'],
            ['nama' => 'Kebun Buah Warga Okura', 'deskripsi' => 'Kebun buah musiman milik warga yang dibuka untuk wisata petik buah.', 'harga_tiket' => 'Rp 15.000/orang', 'jam_operasional' => '07.00 - 16.00 WIB'],
        ];

        foreach ($data as $item) {
            Wisata::create([
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']) . '-' . Str::random(5),
                'deskripsi' => $item['deskripsi'],
                'alamat' => 'Kelurahan Tebing Tinggi Okura, Rumbai Pesisir, Pekanbaru',
                'latitude' => 0.6183 + (rand(-50, 50) / 10000),
                'longitude' => 101.5854 + (rand(-50, 50) / 10000),
                'harga_tiket' => $item['harga_tiket'],
                'jam_operasional' => $item['jam_operasional'],
                'kontak' => '0812-3456-7890',
                'status' => 'aktif',
            ]);
        }
    }
}
