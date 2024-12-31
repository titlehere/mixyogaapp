<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran'; // Nama tabel
    protected $primaryKey = 'payment_uuid'; // Primary key
    public $incrementing = false; // Primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe data primary key
    public $timestamps = false; // Menonaktifkan timestamps default (created_at, updated_at)

    // Kolom yang dapat diisi
    protected $fillable = [
        'payment_uuid', 
        'booking_uuid', 
        'studio_uuid', 
        'payment_method', 
        'payment_nominal', 
        'payment_date', // Tambahkan kolom payment_date
        'payment_status'
    ];

    // Relasi ke tabel Pemesanan
    public function booking()
    {
        return $this->belongsTo(Pemesanan::class, 'booking_uuid', 'booking_uuid');
    }

    // Relasi ke tabel StudioYoga
    public function studio()
    {
        return $this->belongsTo(StudioYoga::class, 'studio_uuid', 'studio_uuid');
    }
    
    /**
     * Menghasilkan data laporan berdasarkan periode dan studio_uuid
     *
     * @param string $studioUuid
     * @return \Illuminate\Support\Collection
     */
    public static function laporanPeriode($studioUuid)
    {
        return self::selectRaw("
            DATE_FORMAT(payment_date, '%M %Y') as periode,
            COUNT(payment_uuid) as jumlah_transaksi,
            SUM(payment_nominal) as total_pendapatan,
            COUNT(CASE WHEN payment_status = 'Failed' THEN 1 END) as jumlah_pembatalan,
            SUM(CASE WHEN payment_status = 'Failed' THEN payment_nominal ELSE 0 END) as pendapatan_hilang
        ")
        ->where('studio_uuid', $studioUuid)
        ->groupByRaw("DATE_FORMAT(payment_date, '%M %Y')")
        ->orderByRaw("MIN(payment_date) ASC")
        ->get();
    }
}