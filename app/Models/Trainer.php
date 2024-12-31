<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'trainer';
    protected $primaryKey = 'trainer_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = [
        'trainer_uuid', 'trainer_name', 'trainer_desk', 'trainer_umur',
        'trainer_sertif', 'trainer_link_fb', 'trainer_link_ig', 'trainer_link_tw', 'studio_uuid', 'trainer_foto',
    ];

    // Relasi ke studio yoga
    public function studio()
    {
        return $this->belongsTo(StudioYoga::class, 'studio_uuid', 'studio_uuid');
    }
}