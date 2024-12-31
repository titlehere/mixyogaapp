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

    public function classes()
    {
        return $this->hasMany(KelasYoga::class, 'studio_uuid', 'studio_uuid');
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'studio_uuid', 'studio_uuid');
    }    

    public function savedByMembers()
    {
        return $this->belongsToMany(Member::class, 'saved_studios', 'studio_uuid', 'member_uuid');
    }
}