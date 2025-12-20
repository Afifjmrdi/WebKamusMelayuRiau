<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KamusIstilahTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
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

    public function array(): array
    {
        return [
            [
                'IST-001',
                'Melayu Riau',
                'Balai Bahasa Riau',
                'mengelala',
                'dasar',
                'mêngêlala',
                'v',
                'Ri',
                'mencari sesuatu setengah mati karena lupa menyimpan barang'
            ]
        ];
    }
}
