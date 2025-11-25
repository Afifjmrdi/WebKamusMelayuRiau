<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamus extends Model
{
    use HasFactory;

    protected $table = 'kamus';

    protected $fillable = [
        'kata',
        'kelas_kata',
        'arti',
        'contoh',
        'asal_kamus',
        'suku_kata',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;
}
