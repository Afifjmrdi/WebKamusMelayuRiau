<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoreksiKata extends Model
{
    use HasFactory;

    protected $table = 'koreksi_kata';

    protected $fillable = [
        'asal_kamus',
        'kata',
        'bagian_dikoreksi',
        'nilai_baru',
        'alasan',
        'nama_pengoreksi',
        'email_pengoreksi'
    ];
}
