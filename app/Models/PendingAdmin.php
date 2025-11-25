<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingAdmin extends Model
{
    protected $table = 'pending_admins';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'token'
    ];
}

