<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tiket',
        'nama_usaha',
        'nama_pemilik',
        'kategori',
        'deskripsi',
        'alamat',
        'latitude',
        'longitude',
        'no_hp',
        'foto',
        'nama_pengaju',
        'no_hp_pengaju',
        'sumber',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->when($kategori, fn ($q) => $q->where('kategori', $kategori));
    }

    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'galleryable')->orderBy('urutan');
    }

    public static function generateKodeTiket(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix = "UMK-{$tanggal}-";
        $terakhir = self::where('kode_tiket', 'like', "{$prefix}%")->orderByDesc('kode_tiket')->first();
        $urutan = $terakhir ? ((int) substr($terakhir->kode_tiket, -3)) + 1 : 1;
        return $prefix . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700',
            'aktif' => 'bg-emerald-50 text-emerald-700',
            'nonaktif' => 'bg-slate-100 text-slate-500',
            default => 'bg-slate-50 text-slate-700',
        };
    }

    public function scopePending($query) { return $query->where('status', 'pending'); }
}
