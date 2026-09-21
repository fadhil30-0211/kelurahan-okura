<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartisipasiUmkm extends Model
{
    use HasFactory;

    protected $table = 'partisipasi_umkms';

    protected $fillable = [
        'nama_pemilik',
        'nama_umkm',
        'kategori',
        'deskripsi',
        'no_hp',
        'alamat',
        'foto',
        'status',
        'kode_tiket',
    ];

    /**
     * Set otomatis kode_tiket saat data baru dibuat
     */
    protected static function booted(): void
    {
        static::creating(function ($item) {
            if (empty($item->kode_tiket)) {
                $item->kode_tiket = self::generateKodeTiket();
            }
        });
    }

    /**
     * Helper untuk generate kode tiket unik
     */
    public static function generateKodeTiket()
    {
        do {
            $kode = 'UMKM-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('kode_tiket', $kode)->exists());

        return $kode;
    }
}
