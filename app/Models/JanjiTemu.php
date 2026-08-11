<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JanjiTemu extends Model
{
    protected $fillable = ['kode_tiket', 'nama_pemohon', 'no_hp', 'keperluan', 'tanggal_diinginkan', 'waktu_diinginkan', 'status', 'catatan_admin'];
    protected function casts(): array { return ['tanggal_diinginkan' => 'date']; }

    public static function generateKodeTiket(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix = "JTM-{$tanggal}-";
        $terakhir = self::where('kode_tiket', 'like', "{$prefix}%")->orderByDesc('kode_tiket')->first();
        $urutan = $terakhir ? ((int) substr($terakhir->kode_tiket, -3)) + 1 : 1;
        return $prefix . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-sky-50 text-sky-700',
            'disetujui' => 'bg-emerald-50 text-emerald-700',
            'ditolak' => 'bg-red-50 text-red-700',
            'selesai' => 'bg-slate-100 text-slate-700',
            default => 'bg-slate-50 text-slate-700',
        };
    }
}
