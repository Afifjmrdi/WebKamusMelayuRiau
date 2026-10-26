<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamus;
use App\Models\Kata;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KamusImport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KamusController extends Controller
{
    public function index()
    {
        // Cache Kosakata hari ini (1 hari)
        $kosakataHariIni = Cache::remember('kosakata_menarik_' . date('Y-m-d'), 86400, function () {
            return \App\Models\Kata::inRandomOrder()->limit(30)->get();
        });

        // Cache Trending (5 menit)
        $trending = Cache::remember('trending_kata_10', 300, function () {
            return \App\Models\Kamus::orderBy('search_count', 'desc')->limit(10)->get();
        });

        $daftarAsalKamus = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus')->toArray();

        return view('home', compact('kosakataHariIni', 'daftarAsalKamus', 'trending'));
    }

    public function kosakataMenarik()
    {
        $kosakataHariIni = Cache::remember(
            'kosakata_menarik_' . date('Y-m-d'),
            86400,
            function () {
                return Kamus::inRandomOrder()->limit(16)->get();
            }
        );
        return view('kosakatamenarik', compact('kosakataHariIni'));
    }

    // ==========================================================
    // FUNGSI PENCARIAN (UPDATED: Pagination & Highlighting)
    // ==========================================================
    public function search(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $filterAsal = $request->input('asal_kamus', '');
        $mode = $request->input('mode', 'indo-ke-daerah');
        $page = (int) $request->input('page', 1);

        // Jika keyword kosong, kembalikan array kosong
        if ($q === '') {
            return response()->json(['data' => [], 'next_page_url' => null]);
        }

        $perPage = 10; // Load 10 data per scroll

        // Cache Key unik berdasarkan query + page
        $cacheKey = 'search:' . md5($q . '|' . $filterAsal . '|' . $mode . '|' . $page);

        // Cache 30 menit
        $paginator = Cache::remember($cacheKey, 1800, function () use ($q, $filterAsal, $mode, $perPage) {
            $query = Kamus::query()
                ->select('id', 'kata', 'suku_kata', 'kelas_kata', 'arti', 'contoh', 'asal_kamus');

            if ($mode === 'daerah-ke-indo') {
                // Pencarian Bahasa Daerah -> Indo (Cari di arti/contoh)
                $query->where(function ($sub) use ($q) {
                    $sub->where('arti', 'LIKE', $q . '%')
                        ->orWhere('arti', 'LIKE', '%' . $q . '%')
                        ->orWhere('contoh', 'LIKE', '%' . $q . '%');
                });

                if (!empty($filterAsal)) {
                    $query->where('asal_kamus', $filterAsal);
                }

                // Prioritaskan yang awalannya sama
                $query->orderByRaw("CASE WHEN arti LIKE ? THEN 0 WHEN arti LIKE ? THEN 1 ELSE 2 END", [$q . '%', '%' . $q . '%'])
                    ->orderBy('kata');
            } else {
                // Default: Indo -> Daerah
                $query->where(function ($sub) use ($q) {
                    $sub->where('kata', 'LIKE', $q . '%')
                        ->orWhere('kata', 'LIKE', '%' . $q . '%')
                        ->orWhere('arti', 'LIKE', '%' . $q . '%')
                        ->orWhere('contoh', 'LIKE', '%' . $q . '%');
                });

                if (!empty($filterAsal)) {
                    $query->where('asal_kamus', $filterAsal);
                }

                $query->orderByRaw("CASE WHEN kata LIKE ? THEN 0 WHEN kata LIKE ? THEN 1 ELSE 2 END", [$q . '%', '%' . $q . '%'])
                    ->orderBy('kata');
            }

            return $query->paginate($perPage);
        });

        // Proses Highlight Hasil (Tanpa merusak objek paginator asli)
        $escaped = preg_quote($q, '/');

        $paginator->getCollection()->transform(function ($item) use ($escaped, $q, $mode) {
            $kata = $item->kata ?? '';
            $arti = is_string($item->arti) ? $item->arti : (string) $item->arti;
            $contoh = $item->contoh ?? '';

            if ($mode === 'daerah-ke-indo') {
                return [
                    'id' => $item->id,
                    'kata' => $item->kata,
                    'kata_highlight' => preg_replace("/($escaped)/i", '<mark>$1</mark>', e($item->kata)),
                    'suku_kata' => $item->suku_kata,
                    'kelas_kata' => $item->kelas_kata,
                    'arti' => $arti,
                    'arti_highlight' => preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($arti, 150))),
                    'contoh' => $contoh,
                    'contoh_highlight' => preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($contoh, 120))),
                    'asal_kamus' => $item->asal_kamus,
                ];
            }

            // Default Highlight
            return [
                'id' => $item->id,
                'kata' => $kata,
                'kata_highlight' => preg_replace("/($escaped)/i", '<mark>$1</mark>', e($kata)),
                'suku_kata' => $item->suku_kata,
                'kelas_kata' => $item->kelas_kata,
                'arti' => $arti,
                'arti_highlight' => preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($arti, 150))),
                'contoh' => $contoh,
                'contoh_highlight' => preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($contoh, 120))),
                'asal_kamus' => $item->asal_kamus,
            ];
        });

        return response()->json($paginator);
    }

    public function detailJson($id)
    {
        $item = Kamus::select('id', 'kata', 'suku_kata', 'kelas_kata', 'arti', 'contoh', 'asal_kamus')->find($id);

        if (!$item) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($item);
    }

    // ==========================================================
    // FITUR ADMIN (CRUD & EXCEL)
    // ==========================================================

    public function adminDashboard()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');

        // Count dummy jika variabel belum ada di view, sesuaikan dengan logic count anda
        $kuansingCount = Kamus::where('asal_kamus', 'like', '%Kuantan%')->count();
        $siakCount = Kamus::where('asal_kamus', 'like', '%Siak%')->count();
        $rohilCount = Kamus::where('asal_kamus', 'like', '%Rokan%')->count();
        $inhilCount = Kamus::where('asal_kamus', 'like', '%Indragiri%')->count();

        return view('admin.dashboard', compact(
            'kuansingCount',
            'siakCount',
            'rohilCount',
            'inhilCount',
            'asalKamusList'
        ));
    }

    public function adminKamus(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $search = $request->input('search');
        $asal = $request->input('asal_kamus');
        $kelas = $request->input('kelas_kata');

        $allowed = [10, 25, 50, 100];
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, $allowed)) {
            $perPage = 10;
        }

        $query = Kamus::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kata', 'like', "%{$search}%")
                    ->orWhere('arti', 'like', "%{$search}%");
            });
        }

        if ($asal) {
            $query->where('asal_kamus', $asal);
        }

        if ($kelas) {
            $query->where('kelas_kata', $kelas);
        }

        $dataKamus = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $daftarAsalKamus = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');
        $asalKamusList = $daftarAsalKamus; // Alias

        $kelasKataList = [
            'n',
            'v',
            'adj',
            'adv',
            'pron',
            'num',
            'prep',
            'konj',
            'interj',
            'part'
        ];

        return view('admin.kamus', compact(
            'dataKamus',
            'daftarAsalKamus',
            'kelasKataList',
            'asalKamusList'
        ));
    }

    public function create()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');
        return view('admin.create', compact('asalKamusList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kata' => 'required|string|max:255',
            'kelas_kata' => 'required|string|max:255',
            'arti' => 'required|string',
            'asal_kamus' => 'required|string|max:255',
            'suku_kata' => 'nullable|string|max:255',
            'contoh' => 'nullable|string',
        ]);

        $kamus = Kamus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data kamus berhasil ditambahkan!',
            'data' => $kamus
        ]);
    }

    public function edit($id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $kamus = Kamus::findOrFail($id);
        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');

        return view('admin.edit', compact('kamus', 'asalKamusList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kata' => 'required|string|max:255',
            'kelas_kata' => 'required|string|max:255',
            'arti' => 'required|string',
            'contoh' => 'nullable|string',
            'asal_kamus' => 'required|string',
            'suku_kata' => 'nullable|string',
        ]);

        $kamus = Kamus::findOrFail($id);
        $kamus->update($request->all());

        return redirect()->route('admin.kamus')->with('success', 'Data kamus berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kamus = Kamus::findOrFail($id);
        $kamus->delete();
        return redirect()->route('admin.kamus')->with('success', 'Data kamus berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        if (!session('admin_id')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
        }

        try {
            Kamus::whereIn('id', $ids)->delete();
            return response()->json([
                'success' => true,
                'message' => count($ids) . ' data kosakata berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new KamusImport, $request->file('file'));
            return back()->with('success', 'Data kosakata berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $rows = Excel::toArray(new KamusImport, $file)[0];
        $import = new KamusImport;
        Excel::import($import, $file);

        return view('admin.datakamus.import-preview', [
            'rows'     => $rows,
            'failures' => $import->failures()
        ]);
    }

    public function downloadTemplateImport()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import Kamus');

        $headers = ['kata', 'kelas_kata', 'arti', 'contoh', 'asal_kamus', 'suku_kata'];
        $sheet->fromArray($headers, null, 'A1');

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '217346']],
        ]);

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->fromArray([
            'mengelala',
            'v',
            'mencari sesuatu...',
            'Ia mengelala...',
            'Kamus Indonesia - Melayu Siak',
            'me.nge.la.la'
        ], null, 'A2');

        $sheet->freezePane('A2');
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=template_import_kamus.xlsx",
        ]);
    }
}
