<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['galleryable_id', 'galleryable_type', 'path', 'caption', 'urutan'];

    public function galleryable()
    {
        return $this->morphTo();
    }
}
