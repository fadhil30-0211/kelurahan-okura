<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate agar seeder aman dijalankan berulang kali tanpa duplikasi data
        Setting::updateOrCreate(
            ['id' => 1], // Target baris pertama
            [
                // Tab 1: Profil & Identitas
                'nama_instansi'   => 'Pemerintah Desa Sumber Makmur',
                'singkatan'       => 'PEMDES',
                'logo'            => null, // Bisa diisi path default jika ada, misal: 'settings/default-logo.png'
                'email'           => 'admin@desasumbermakmur.go.id',
                'telepon'         => '081234567890',
                'alamat'          => 'Jl. Raya Desa No. 01, Kecamatan Sukamaju',

                // Tab 2: Kependudukan
                'jumlah_penduduk' => 1250,

                // Tab 3: Peta & Lokasi
                'latitude'        => '-0.507068',
                'longitude'       => '101.447779',
                'link_map'        => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.468231234567!2d101.447779!3d-0.507068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMzAnMjUuNCJTIDEwMcKwMjYnNTI.0IkE!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            ]
        );
    }
}
