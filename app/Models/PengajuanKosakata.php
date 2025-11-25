<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKosakata extends Model
{
    use HasFactory;

    protected $fillable = [
        'kata',
        'suku_kata',
        'asal_kamus',
        'kelas_kata',
        'arti',
        'contoh',
        'asal_pengaju',
        'email_pengaju',
        'alasan_pengajuan',
        'status', // tambahkan
    ];
}
