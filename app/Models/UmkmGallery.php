<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmGallery extends Model
{
    protected $fillable = ['umkm_id', 'path'];

    public function umkm()
    {
        return $table->belongsTo(Umkm::class);
    }
}
