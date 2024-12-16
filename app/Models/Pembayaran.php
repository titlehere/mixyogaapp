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
}