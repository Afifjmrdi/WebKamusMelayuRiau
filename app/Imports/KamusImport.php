<?php

namespace App\Imports;

use App\Models\Kamus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KamusImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Kamus([
            'kata'        => $row['kata'],
            'kelas_kata'  => $row['kelas_kata'],
            'arti'        => $row['arti'],
            'contoh'      => $row['contoh'],
            'asal_kamus'  => $row['asal_kamus'],
            'suku_kata'   => $row['suku_kata'],
        ]);
    }
}
