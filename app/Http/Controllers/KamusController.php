<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Kamus;
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

        $daftarAsalKamus = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus')->toArray();

        return view('home', compact('kosakataHariIni', 'daftarAsalKamus'));
    }

    public function search(Request $request)
{
    $q = $request->input('q');
    $filterAsal = $request->input('asal_kamus'); // filter optional

    $query = Kamus::query();

    if ($q) {
        $query->where('kata', 'LIKE', "%{$q}%");
    }

        // hanya filter kalau ada isinya
        if ($filterAsal && $filterAsal !== "") {
            $query->where('asal_kamus', 'LIKE', "%{$filterAsal}%");
        }

        $results = $query->get();
    return response()->json($results);
}

    public function adminDashboard()
    {
        // Pastikan hanya admin yang login bisa akses
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        // Ambil data jumlah kamus berdasarkan asal_kamus
        $kuansingCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Kuantan Singingi')->count();
        $siakCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Melayu Siak')->count();
        $rohilCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Rokan Hilir')->count();
        $inhilCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Indragiri Hulu')->count();

        return view('admin.dashboard', compact(
            'kuansingCount',
            'siakCount',
            'rohilCount',
            'inhilCount'
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
        // pastikan admin login jika perlu
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $search = $request->input('search');
        $asal = $request->input('asal_kamus');
        $kelas = $request->input('kelas_kata'); // 🆕 ambil filter kelas_kata

        // sanitasi per_page
        $allowed = [10, 25, 50, 100];
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, $allowed)) {
            $perPage = 10;
        }

        $query = Kamus::query();

        // 🔍 Filter pencarian kata / arti
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kata', 'like', "%{$search}%")
                    ->orWhere('arti', 'like', "%{$search}%");
            });
        }

        // 📖 Filter asal kamus
        if ($asal) {
            $query->where('asal_kamus', $asal);
        }

        // 🆕 Filter kelas kata
        if ($kelas) {
            $query->where('kelas_kata', $kelas);
        }

        $dataKamus = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString(); // penting agar query params ikut di pagination

        // list unik asal_kamus & kelas_kata untuk dropdown
        $asalKamusList = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus');
        $kelasKataList = Kamus::select('kelas_kata')->distinct()->pluck('kelas_kata'); // 🆕

        return view('admin.kamus', compact('dataKamus', 'asalKamusList', 'kelasKataList'));
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
}
