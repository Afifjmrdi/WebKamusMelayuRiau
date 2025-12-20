<?php

namespace App\Imports;

use App\Models\KamusIstilah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KamusIstilahImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['entri']) || !isset($row['makna_entri'])) {
            return null;
        }

        return new KamusIstilah([
            'kode_entri'     => $row['kode_entri'] ?? null,
            'bahasa_daerah'  => $row['bahasa_daerah'] ?? null,
            'sumber'         => $row['sumber'] ?? null,
            'entri'          => $row['entri'],
            'jenis'          => $row['jenis'] ?? null,
            'lafal'          => $row['lafal'] ?? null,
            'kelas_kata'     => $row['kelas_kata'] ?? null,
            'label_bahasa'   => $row['label_bahasa'] ?? null,
            'makna_entri'    => $row['makna_entri'],
        ]);
    }
}
