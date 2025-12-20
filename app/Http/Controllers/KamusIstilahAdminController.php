<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KamusIstilah;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KamusIstilahTemplateExport;
use App\Imports\KamusIstilahImport;
use Illuminate\Http\Request;

class KamusIstilahAdminController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // 🔥 ambil dari query

        $query = KamusIstilah::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('entri', 'like', "%{$search}%")
                    ->orWhere('makna_entri', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas_kata')) {
            $query->where('kelas_kata', $request->kelas_kata);
        }

        $data = $query
            ->orderBy('entri')
            ->paginate($perPage)   // ✅ PAKAI VARIABLE
            ->withQueryString();

        $kelasKataList = KamusIstilah::query()
            ->select('kelas_kata')
            ->whereNotNull('kelas_kata')
            ->distinct()
            ->orderBy('kelas_kata')
            ->pluck('kelas_kata');

        return view('admin.dataistilah', compact('data', 'kelasKataList'));
    }


    public function show($id)
    {
        return response()->json(
            KamusIstilah::findOrFail($id)
        );
    }

    public function bulkDelete(Request $request)
    {
        KamusIstilah::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $item = KamusIstilah::findOrFail($id);

        $item->update($request->only([
            'entri',
            'lafal',
            'kelas_kata',
            'makna_entri',
            'kode_entri',
            'bahasa_daerah',
            'sumber',
            'jenis',
            'label_bahasa'
        ]));

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function destroy($id)
    {
        KamusIstilah::findOrFail($id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'entri' => 'required|string',
            'makna_entri' => 'required|string',
        ]);

        KamusIstilah::create($request->only([
            'kode_entri',
            'bahasa_daerah',
            'sumber',
            'entri',
            'jenis',
            'lafal',
            'kelas_kata',
            'label_bahasa',
            'makna_entri',
        ]));

        return redirect()
            ->back()
            ->with('success', 'Istilah berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new KamusIstilahImport, $request->file('file'));

        return redirect()
            ->back()
            ->with('success', 'Import Excel berhasil');
    }

    public function downloadTemplate()
{
    return Excel::download(
        new KamusIstilahTemplateExport,
        'template_kamus_istilah.xlsx'
    );
}
}
