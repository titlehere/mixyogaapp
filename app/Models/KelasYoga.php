<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasYoga extends Model
{
    protected $table = 'kelas_yoga';
    protected $primaryKey = 'kelas_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = [
        'kelas_uuid',
        'studio_uuid',
        'kelas_name',
        'kelas_desk',
        'kelas_kapasitas',
        'kelas_harga',
        'kelas_thumbnail',
    ];    

    // Relasi ke studio yoga
    public function studio()
    {
        return $this->belongsTo(StudioYoga::class, 'studio_uuid', 'studio_uuid');
    } 

        public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kelas_uuid', 'kelas_uuid')->orderBy('jadwal_tgl', 'desc');
    }

    // KelasYoga.php
        public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Jadwal::class,
            'kelas_uuid', // Foreign key di tabel `jadwals`
            'jadwal_uuid', // Foreign key di tabel `reviews`
            'kelas_uuid', // Local key di tabel `kelas_yoga`
            'jadwal_uuid' // Local key di tabel `jadwals`
        );
    }
    public function pendapatanPerKelas()
    {
        return $this->jadwals()->withSum('pembayarans as total_pendapatan', 'payment_nominal')
            ->get();
    }

}