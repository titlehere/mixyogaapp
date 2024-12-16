<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'member';

    protected $primaryKey = 'member_uuid';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    // Tambahkan 'profile_photo' ke dalam fillable
    protected $fillable = [
        'member_uuid',
        'member_name',
        'member_email',
        'member_pass',
        'member_phone',
        'member_status',
        'profile_photo',
    ];

    protected $hidden = [
        'member_pass',
    ];

    public function getAuthPassword()
    {
        return $this->member_pass;
    }
}