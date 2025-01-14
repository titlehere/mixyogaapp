<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'penjadwal'; // Nama tabel
    protected $primaryKey = 'jadwal_uuid'; // Primary key
    public $incrementing = false; // UUID digunakan sebagai primary key
    public $timestamps = false; // Nonaktifkan timestamps

    protected $fillable = [
        'jadwal_uuid',
        'kelas_uuid',
        'trainer_uuid',
        'jadwal_tgl',
        'jadwal_wkt', // Mengganti waktu mulai dan selesai menjadi satu kolom
        'jadwal_status', // Tambahkan kolom ini
    ];

    // Relasi ke tabel `kelas_yoga`
    public function kelas()
    {
        return $this->belongsTo(KelasYoga::class, 'kelas_uuid', 'kelas_uuid');
    }    

    // Relasi ke tabel `trainer`
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_uuid', 'trainer_uuid');
    }
    public function pembayarans()
    {
        return $this->hasManyThrough(
            Pembayaran::class,
            Pemesanan::class,
            'jadwal_uuid', // Foreign key di tabel `pemesanan`
            'booking_uuid', // Foreign key di tabel `pembayaran`
            'jadwal_uuid', // Local key di tabel `jadwal`
            'booking_uuid'  // Local key di tabel `pemesanan`
        );
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'jadwal_uuid', 'jadwal_uuid');
    }

public function reviews()
    {
        return $this->hasMany(Review::class, 'jadwal_uuid', 'jadwal_uuid');
    }

    public function getPemesananCountAttribute()
    {
        return $this->pemesanan()->count(); // Menghitung jumlah pemesanan pada jadwal
    }
    
}