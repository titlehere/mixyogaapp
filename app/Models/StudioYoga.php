<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudioYoga extends Model
{
    use HasFactory;

    protected $table = 'studio_yoga';

    protected $primaryKey = 'studio_uuid';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'studio_uuid',
        'owner_uuid',
        'studio_name',
        'studio_desk',
        'studio_lokasi',
        'studio_logo',
    ];

    public function owner()
    {
        return $this->belongsTo(OwnerStudio::class, 'owner_uuid', 'owner_uuid');
    }
}