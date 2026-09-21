<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartisipasiWisata extends Model
{
    use HasFactory;

    protected $table = 'partisipasi_wisatas';

    protected $fillable = [
        'nama_pengaju',
        'nama_wisata',
        'lokasi',
        'deskripsi',
        'no_hp',
        'foto',
        'status',
        'kode_tiket',
    ];

    public static function generateKodeTiket()
    {
        do {
            $kode = 'WST-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('kode_tiket', $kode)->exists());

        return $kode;
    }
}
