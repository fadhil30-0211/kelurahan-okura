<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'alamat',
        'latitude',
        'longitude',
        'thumbnail',
        'galeri',
        'harga_tiket',
        'jam_operasional',
        'kontak',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'galeri' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'galleryable')->orderBy('urutan');
    }

    public static function generateKodeTiket(): string
{
    $tanggal = now()->format('Ymd');
    $prefix = "WIS-{$tanggal}-";
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
