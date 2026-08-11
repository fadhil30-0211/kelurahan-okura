<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SurveiKepuasan extends Model
{
    protected $table = 'survei_kepuasan';
    protected $fillable = ['nama', 'rating', 'saran', 'layanan_terkait'];
}
