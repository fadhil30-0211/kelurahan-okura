<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database secara eksplisit
    protected $table = 'profils';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama_kelurahan',
        'visi',
        'sub_visi',
        'misi',
        'deskripsi_sejarah',
        'kecamatan',
        'kota',
        'karakter_wilayah',
        'potensi',
        'latitude',
        'longitude',
        'geojson_file',
    ];

    // Konversi tipe data otomatis
    protected $casts = [
        'misi' => 'array', // Mengubah JSON dari database ke Array PHP secara otomatis
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
