<?php

namespace App\Helpers;

use App\Models\Kamus;

class KamusHelper
{
    /**
     * Ambil daftar asal kamus unik
     */
    public static function getDaftarAsalKamus(): array
    {
        return Kamus::select('asal_kamus')
            ->distinct()
            ->pluck('asal_kamus')
            ->toArray();
    }
}
