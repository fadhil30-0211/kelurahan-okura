<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LayananSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tiket',
        'jenis_surat',
        'nama_pemohon',
        'nik',
        'no_hp',
        'keperluan',
        'berkas_persyaratan',
        'file_hasil',
        'status',
        'catatan_admin',
        'diproses_oleh',
    ];

    protected function casts(): array
    {
        return [
            'berkas_persyaratan' => 'array',
        ];
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public static function generateKodeTiket(): string
{
    $tanggal = now()->format('Ymd');
    // Prefix beda per jenis surat, sesuai prompt: SKT-, SKU-
    $prefixMap = [
        'Surat Keterangan Tidak Mampu (SKTM)' => 'SKT',
        'Surat Keterangan Usaha (SKU)' => 'SKU',
        'Surat Keterangan Domisili' => 'DOM',
        'Surat Pengantar Kelahiran' => 'LHR',
    ];

    return self::generateKodeDenganPrefix($prefixMap[func_get_args()[0] ?? ''] ?? 'SRT', $tanggal);
}

    protected static function generateKodeDenganPrefix(string $prefix, string $tanggal): string
    {
        $awalan = "{$prefix}-{$tanggal}-";

        $terakhir = self::where('kode_tiket', 'like', "{$awalan}%")
            ->orderByDesc('kode_tiket')
            ->first();

        $urutan = $terakhir
            ? ((int) substr($terakhir->kode_tiket, -3)) + 1
            : 1;

        return $awalan . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    public function scopeStatus($query, $status)
    {
        return $query->when($status, fn ($q) => $q->where('status', $status));
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'diajukan'  => 'bg-sky-50 text-sky-700',
            'diproses'  => 'bg-amber-50 text-amber-700',
            'disetujui' => 'bg-emerald-50 text-emerald-700',
            'ditolak'   => 'bg-red-50 text-red-700',
            'selesai'   => 'bg-slate-100 text-slate-700',
            default     => 'bg-slate-50 text-slate-700',
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
