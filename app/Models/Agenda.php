<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['nama_acara', 'deskripsi', 'tanggal', 'waktu', 'lokasi', 'user_id'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString())->orderBy('tanggal');
    }
}
