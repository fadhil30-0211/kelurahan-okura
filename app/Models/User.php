<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function beritas()
    {
        return $this->hasMany(Berita::class);
    }

    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class);
    }

        public function isLurah(): bool
    {
        return $this->role === 'lurah';
    }

    public function isStaf(): bool
    {
        return $this->role === 'staf';
    }

    /**
     * Lurah dan Super Admin sama-sama punya akses "tingkat pimpinan"
     * (lihat statistik, approve, lihat SKM) — bedanya Super Admin juga
     * bisa kelola konten teknis (CRUD berita/wisata/dst) dan data pegawai.
     */
    public function canApprove(): bool
    {
        return in_array($this->role, ['super_admin', 'lurah']);
    }
}

