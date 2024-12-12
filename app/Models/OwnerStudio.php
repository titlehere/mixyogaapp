<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwnerStudio extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'owner_studio';

    protected $primaryKey = 'owner_uuid';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'owner_uuid',
        'owner_name',
        'owner_email',
        'owner_pass',
        'owner_phone',
        'owner_status',
    ];

    protected $hidden = [
        'owner_pass',
    ];

    public function getAuthPassword()
    {
        return $this->owner_pass;
    }
}