<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'payment_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'payment_uuid',
        'booking_uuid',
        'studio_uuid',
        'payment_method',
        'payment_nominal',
        'payment_date',
        'payment_status',
        'payment_bukti', 
    ];

    public function booking()
    {
        return $this->belongsTo(Pemesanan::class, 'booking_uuid', 'booking_uuid');
    }

    public function studio()
    {
        return $this->belongsTo(StudioYoga::class, 'studio_uuid', 'studio_uuid');
    }

    /**
     * Mengambil data laporan berdasarkan periode pembayaran
     */
    public static function laporanPeriode($studioUuid, $startDate = null, $endDate = null)
    {
        $query = self::where('studio_uuid', $studioUuid);

        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        return $query->selectRaw('
            COUNT(*) as total_transaksi,
            SUM(payment_nominal) as total_pendapatan,
            MIN(payment_date) as tanggal_pertama,
            MAX(payment_date) as tanggal_terakhir
        ')->first();
    }
}