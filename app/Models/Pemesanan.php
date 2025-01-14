<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'booking_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'booking_uuid',
        'jadwal_uuid',
        'member_uuid',
        'booking_date',
        'booking_status',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_uuid', 'jadwal_uuid')->with('reviews');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_uuid', 'member_uuid');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'booking_uuid', 'booking_uuid');
    }
}
