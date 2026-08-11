<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'foto', 'kategori', 'tanggal_kegiatan', 'user_id'];

    protected function casts(): array
    {
        return ['tanggal_kegiatan' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
