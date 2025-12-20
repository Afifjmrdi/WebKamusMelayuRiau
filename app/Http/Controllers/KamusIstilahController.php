<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KamusIstilah;
use Illuminate\Support\Str;

class KamusIstilahController extends Controller
{
    public function index()
    {
        $istilah = KamusIstilah::orderBy('entri')->get();

        return view('kamusistilah', compact('istilah'));
    }

    public function search(Request $request)
    {
        $q = trim($request->q ?? '');

        if ($q === '') {
            return response()->json([]);
        }

        $results = KamusIstilah::where('entri', 'LIKE', "%{$q}%")
            ->orWhere('makna_entri', 'LIKE', "%{$q}%")
            ->orderByRaw("CASE WHEN entri LIKE ? THEN 0 ELSE 1 END", ["{$q}%"])
            ->limit(50)
            ->get();

        return response()->json(
            $results->map(function ($item) {
                return [
                    // data utama (search)
                    'entri'        => $item->entri,
                    'lafal'        => $item->lafal,
                    'kelas_kata'   => $item->kelas_kata,
                    'makna_entri'  => $item->makna_entri,

                    // 🔽 data untuk MODAL INFO (5 kolom)
                    'kode_entri'    => $item->kode_entri,
                    'bahasa_daerah' => $item->bahasa_daerah,
                    'sumber'        => $item->sumber,
                    'jenis'         => $item->jenis,
                    'label_bahasa'  => $item->label_bahasa,
                ];
            })
        );
    }
}
