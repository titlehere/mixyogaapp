<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'penjadwal'; // Nama tabel di database
    protected $primaryKey = 'jadwal_uuid'; // Primary key
    public $incrementing = false; // Non-incremental UUID

    protected $fillable = [
        'jadwal_uuid',
        'kelas_uuid',
        'trainer_uuid',
        'jadwal_tgl',
        'jadwal_wkt',
    ];

    // Relasi ke tabel kelas_yoga
    public function kelas()
    {
        return $this->belongsTo(KelasYoga::class, 'kelas_uuid', 'kelas_uuid');
    }

    // Relasi ke tabel trainer
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_uuid', 'trainer_uuid');
    }
}
