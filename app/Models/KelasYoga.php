<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasYoga extends Model
{
    protected $table = 'kelas_yoga';
    protected $primaryKey = 'kelas_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kelas_uuid', 
        'studio_uuid', 
        'kelas_name', 
        'kelas_desk', 
        'kelas_kapasitas', 
        'kelas_harga'];

    // Relasi ke studio yoga
    public function studio()
    {
        return $this->belongsTo(StudioYoga::class, 'studio_uuid', 'studio_uuid');
    }
}