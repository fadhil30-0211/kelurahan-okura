<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $fillable = ['judul', 'subjudul', 'gambar', 'tombol_teks', 'tombol_link', 'urutan', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('urutan'); }
}
