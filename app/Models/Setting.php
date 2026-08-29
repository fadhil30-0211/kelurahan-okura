<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_website',
        'nama_website_footer',
        'nama_instansi',
        'singkatan',
        'logo',
        'email',
        'telepon',
        'whatsapp',
        'pesan_wa',
        'alamat',
        'deskripsi_footer',
        'jumlah_penduduk',
        'latitude',
        'longitude',
        'link_map',
    ];
}
