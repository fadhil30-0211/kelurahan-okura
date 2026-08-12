<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tiket',
        'nama_pelapor',
        'nik',
        'no_hp',
        'email',
        'is_anonim',
        'kategori',
        'judul_aduan',
        'isi_aduan',
        'lampiran',
        'status',
        'tanggapan_admin',
        'ditangani_oleh',
        'tanggal_tanggapan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_tanggapan' => 'datetime',
        ];
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }

    public static function generateKodeTiket(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix = "ADU-{$tanggal}-";

        $terakhir = self::where('kode_tiket', 'like', "{$prefix}%")
            ->orderByDesc('kode_tiket')
            ->first();

        $urutan = $terakhir
            ? ((int) substr($terakhir->kode_tiket, -3)) + 1
            : 1;

        return $prefix . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    public function scopeStatus($query, $status)
    {
        return $query->when($status, fn ($q) => $q->where('status', $status));
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'diterima' => 'bg-sky-50 text-sky-700',
            'diproses' => 'bg-amber-50 text-amber-700',
            'selesai'  => 'bg-emerald-50 text-emerald-700',
            'ditolak'  => 'bg-red-50 text-red-700',
            default    => 'bg-slate-50 text-slate-700',
        };
    }

    public function nomorWhatsApp(): string
    {
        $nomor = preg_replace('/[^0-9]/', '', $this->no_hp);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        return $nomor;
    }
}
