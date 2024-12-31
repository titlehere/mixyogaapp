<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $primaryKey = 'review_uuid';

    public $incrementing = false;
    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'review_uuid',
        'jadwal_uuid',
        'booking_uuid',
        'member_uuid',
        'review_rating',
        'review_komen',
        'review_date',
    ];

    // Relasi ke Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_uuid', 'member_uuid');
    }

    // Relasi ke Jadwal (contoh jika diperlukan)
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_uuid', 'jadwal_uuid');
    }
    
    public function studio()
    {
        return $this->belongsTo(StudioYoga::class, 'studio_uuid', 'studio_uuid');
    }

}