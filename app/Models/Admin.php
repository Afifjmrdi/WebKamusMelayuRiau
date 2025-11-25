<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'is_superadmin',
        'reset_token',
        'reset_expires_at',
    ];


    protected $hidden = [
        'password',
    ];
}
