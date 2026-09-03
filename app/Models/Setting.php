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
        // Jam Pelayanan Tambahan
        'jam_kerja_senin_kamis',
        'jam_kerja_jumat',
        'jam_kerja_sabtu_minggu',
        // Media Sosial Tambahan
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'tiktok_url',
    ];
}
