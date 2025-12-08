<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamus;
use Illuminate\Support\Str;
use App\Models\Kata;
use App\Models\Visitor;
use Carbon\Carbon;
use App\Imports\KamusImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class KamusController extends Controller
{
    public function index()
    {

        $ip = request()->ip();
        $today = Carbon::today();

        $exists = Visitor::where('ip_address', $ip)
            ->whereDate('visited_at', $today)
            ->exists();

        if (!$exists) {
            Visitor::create([
                'ip_address' => $ip,
                'visited_at' => now(),
            ]);
        }

        // Kosakata hari ini
        $kosakataHariIni = Cache::remember('kosakata_menarik_' . date('Y-m-d'), 86400, function () {
            return \App\Models\Kata::inRandomOrder()->limit(16)->get();
        });

        $trending = Cache::remember('trending_kata_10', 300, function () {
            return \App\Models\Kamus::orderBy('search_count', 'desc')->limit(10)->get();
        });

        $daftarAsalKamus = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus')->toArray();

        return view('home', compact('kosakataHariIni', 'daftarAsalKamus', 'trending'));
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $filterAsal = $request->input('asal_kamus', '');
        $mode = $request->input('mode', 'indo-ke-daerah'); // baru: mode pencarian

        // jika kosong, return kosong (frontend tidak akan menampilkan)
        if ($q === '') {
            return response()->json([]);
        }

        // limit hasil agar tidak membebani
        $limit = 100;

        // cache key (sertakan mode agar cache tidak tercampur)
        $cacheKey = 'search:' . md5($q . '|' . $filterAsal . '|' . $mode);

        $results = Cache::remember($cacheKey, 30, function () use ($q, $filterAsal, $limit, $mode) {
            $query = Kamus::query()
                ->select('id', 'kata', 'suku_kata', 'kelas_kata', 'arti', 'contoh', 'asal_kamus');

            if ($mode === 'daerah-ke-indo') {
                // cari di kolom arti / contoh — user memasukkan kata daerah
                $query->where(function ($sub) use ($q) {
                    $sub->where('arti', 'LIKE', $q . '%')
                        ->orWhere('arti', 'LIKE', '%' . $q . '%')
                        ->orWhere('contoh', 'LIKE', '%' . $q . '%');
                });

                if (!empty($filterAsal)) {
                    $query->where('asal_kamus', $filterAsal);
                }

                // ordering: prefer where arti startswith q
                $query->orderByRaw("
                CASE
                    WHEN arti LIKE ? THEN 0
                    WHEN arti LIKE ? THEN 1
                    ELSE 2
                END", [$q . '%', '%' . $q . '%'])
                    ->orderBy('kata');
            } else {
                // default: indo -> daerah (sekarang behavior lama)
                $query->where(function ($sub) use ($q) {
                    $sub->where('kata', 'LIKE', $q . '%')
                        ->orWhere('kata', 'LIKE', '%' . $q . '%')
                        ->orWhere('arti', 'LIKE', '%' . $q . '%')
                        ->orWhere('contoh', 'LIKE', '%' . $q . '%');
                });

                if (!empty($filterAsal)) {
                    $query->where('asal_kamus', $filterAsal);
                }

                $query->orderByRaw("
                CASE
                    WHEN kata LIKE ? THEN 0
                    WHEN kata LIKE ? THEN 1
                    ELSE 2
                END", [$q . '%', '%' . $q . '%'])
                    ->orderBy('kata');
            }

            return $query->limit($limit)->get();
        });

        // highlight hasil (safe-ish, kita return HTML snippets; frontend akan gunakan innerHTML)
        $escaped = preg_quote($q, '/');

        $results = $results->map(function ($item) use ($escaped, $q, $mode) {
            $kata = $item->kata ?? '';
            $arti = is_string($item->arti) ? $item->arti : (string) $item->arti;
            $contoh = $item->contoh ?? '';

            if ($mode === 'daerah-ke-indo') {
                // display: user searched a *term in arti* (bahasa daerah)
                // For frontend compatibility, we set:
                // - kata => the searched term (so it shows as the left column)
                // - kata_highlight => highlighted searched term
                // - arti => the Indonesian lemma (item->kata)
                // - arti_highlight => Indonesian lemma (no highlight or could highlight matching portion)
                $kata_display = $q;
                $kata_highlight = preg_replace("/($escaped)/i", '<mark>$1</mark>', e($kata_display));
                $arti_highlight = e(Str::limit($kata, 150)); // item->kata used as 'arti' now
                $contoh_highlight = preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($contoh, 120)));

                return [
                    'id' => $item->id,
                    // tampilkan kata yang dicari di sisi kiri (bahasa daerah)
                    'kata' => $kata_display,
                    'kata_highlight' => $kata_highlight,
                    'suku_kata' => $item->suku_kata,
                    // kelas_kata tetap dari item (tipe kata)
                    'kelas_kata' => $item->kelas_kata,
                    // arti => tunjukkan lemma Indonesianya
                    'arti' => $kata,
                    'arti_highlight' => $arti_highlight,
                    'contoh' => $item->contoh,
                    'contoh_highlight' => $contoh_highlight,
                    'asal_kamus' => $item->asal_kamus,
                    // tambahan: original_kata untuk keperluan debugging/display lain
                    'original_kata' => $item->kata,
                ];
            }

            // default (indo -> daerah) : behavior lama
            $kata_highlight = preg_replace("/($escaped)/i", '<mark>$1</mark>', e($kata));
            $arti_highlight = preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($arti, 150)));
            $contoh_highlight = preg_replace("/($escaped)/i", '<mark>$1</mark>', e(Str::limit($contoh, 120)));

            return [
                'id' => $item->id,
                'kata' => $kata,
                'kata_highlight' => $kata_highlight,
                'suku_kata' => $item->suku_kata,
                'kelas_kata' => $item->kelas_kata,
                'arti' => $arti,
                'arti_highlight' => $arti_highlight,
                'contoh' => $contoh,
                'contoh_highlight' => $contoh_highlight,
                'asal_kamus' => $item->asal_kamus,
            ];
        });

        return response()->json($results);
    }


    public function trackSearch(Request $request)
    {
        $id = (int) $request->input('id', 0);
        if ($id <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid id'], 400);
        }

        try {
            // race-safe increment
            Kamus::where('id', $id)->increment('search_count');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('trackSearch error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    /** (optional) return JSON detail untuk id tertentu */
    public function detailJson($id)
    {
        $item = Kamus::select('id', 'kata', 'suku_kata', 'kelas_kata', 'arti', 'contoh', 'asal_kamus')->find($id);

        if (!$item) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($item);
    }

    public function adminDashboard()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        // // Hitung berdasarkan nama kamus (kalau masih diperlukan)
        // $kuansingCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Kuantan Singingi')->count();
        // $siakCount     = Kamus::where('asal_kamus', 'Kamus Indonesia - Melayu Siak')->count();
        // $rohilCount    = Kamus::where('asal_kamus', 'Kamus Indonesia - Rokan Hilir')->count();
        // $inhilCount    = Kamus::where('asal_kamus', 'Kamus Indonesia - Indragiri Hulu')->count();

        // ✅ daftar kamus dinamis dari database
        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');

        return view('admin.dashboard', compact(
            'kuansingCount',
            'siakCount',
            'rohilCount',
            'inhilCount',
            'asalKamusList'
        ));
    }

    public function edit($id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $kamus = Kamus::findOrFail($id);
        $asalKamusList = [
            'Kamus Indonesia - Kuantan Singingi',
            'Kamus Indonesia - Melayu Siak',
            'Kamus Indonesia - Rokan Hilir',
            'Kamus Indonesia - Indragiri Hulu'
        ];

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
        $kelasKataList   = Kamus::select('kelas_kata')->distinct()->pluck('kelas_kata');

        // ✅ tambahan ini
        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');

        $kelasKataList = [
            'Nomina (Kata Benda)',
            'Verba (Kata Kerja)',
            'Adjektiva (Kata Sifat)',
            'Adverbia (Kata Keterangan)',
            'Pronomina (Kata Ganti)',
            'Numeralia (Kata Bilangan)',
            'Preposisi (Kata Depan)',
            'Konjungsi (Kata Penghubung)',
            'Interjeksi (Kata Seru)',
            'Partikel'
        ];

        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');


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
}
