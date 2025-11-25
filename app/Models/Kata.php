<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kata extends Model
{
    // Gunakan tabel 'kamus' karena data ada di situ
    protected $table = 'kamus';

    // Kolom yang boleh diisi (disesuaikan dengan struktur tabel)
    protected $fillable = [
        'kata',
        'kelas_kata',
        'arti',
        'contoh',
        'asal_kamus',
        'suku_kata',
        'contoh',
    ];
}
