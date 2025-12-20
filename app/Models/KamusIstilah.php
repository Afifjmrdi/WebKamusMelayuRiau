<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamusIstilah extends Model
{
    use HasFactory;

    protected $table = 'kamus_istilah';

    protected $fillable = [
        'kode_entri',
        'bahasa_daerah',
        'sumber',
        'entri',
        'jenis',
        'lafal',
        'kelas_kata',
        'label_bahasa',
        'makna_entri',
    ];
}
