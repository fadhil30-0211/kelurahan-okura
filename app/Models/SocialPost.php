<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $fillable = ['platform', 'url', 'caption', 'is_active', 'urutan'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('urutan'); }
}
