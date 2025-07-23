<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    // Tidak perlu LogsActivity kecuali ingin melog juga perubahan user

    protected $fillable = [
        'name','email','password',
        'two_factor_enabled',
        'two_factor_chat_id',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'password','remember_token','two_factor_code',
    ];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'two_factor_enabled'    => 'boolean',
        'two_factor_expires_at' => 'datetime',
    ];
}
