<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $fillable = ['tahun', 'kategori', 'jumlah', 'keterangan', 'user_id'];

    protected function casts(): array
    {
        return ['jumlah' => 'decimal:2'];
    }

    public function scopeTahun($query, $tahun)
    {
        return $query->when($tahun, fn ($q) => $q->where('tahun', $tahun));
    }
}
