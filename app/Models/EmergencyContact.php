<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = ['label', 'nomor_telepon', 'ikon', 'urutan', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('urutan'); }
}
