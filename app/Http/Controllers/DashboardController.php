<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamus;
use App\Models\Admin;
use App\Models\KoreksiKata;
use App\Models\PengajuanKosakata;
use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil admin yang login
        $admin = Admin::find($request->session()->get('admin_id'));

        // Total seluruh kosakata/pengajuan/koreksi
        $totalKosakata = Kamus::count();
        $totalPengajuan = PengajuanKosakata::count();
        $totalKoreksi = KoreksiKata::count();

        // Total buku kamus unik
        $totalBuku = Kamus::select('asal_kamus')->distinct()->count();

        // Jumlah kosakata per kamus
        $kamusCounts = Kamus::select('asal_kamus')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('asal_kamus')
            ->orderBy('asal_kamus')
            ->get();

        // Siapkan data untuk donut chart
        $chartNames  = $kamusCounts->pluck('asal_kamus')->toArray();
        $chartCounts = $kamusCounts->pluck('total')->toArray();

        // Data kosakata terbaru (5 data paling baru)
        $recentKata = Kamus::latest()->take(5)->get();

        // Data chart bulanan (jumlah kosakata masuk per bulan)
        $monthlyData = $this->getMonthlyDataAll();
        $barChartData = $this->getMonthlyDataPerKamus();

        // ======= Hitung visitor =======
        $ip = request()->ip();
        $today = Carbon::today();

        // Cek apakah IP ini sudah tercatat hari ini
        $exists = Visitor::where('ip_address', $ip)
            ->whereDate('visited_at', $today)
            ->exists();

        if (!$exists) {
            Visitor::create([
                'ip_address' => $ip,
                'visited_at' => now(),
            ]);
        }

        // Ambil total pengunjung
        $totalVisitors = Visitor::count();

        // ======= RETURN VIEW =======
        return view('admin.dashboard', compact(
            'admin',
            'totalKoreksi',
            'totalPengajuan',
            'totalKosakata',
            'totalBuku',
            'kamusCounts',
            'chartNames',
            'chartCounts',
            'recentKata',
            'monthlyData',
            'totalVisitors',
            'barChartData'
        ));
    }

/**
 * Mengambil data kosakata yang masuk per bulan untuk semua kamus
 */
    private function getMonthlyDataAll()
    {
        $data = Kamus::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $final = array_fill(1, 12, 0);

        foreach ($data as $bulan => $total) {
            $final[$bulan] = $total;
        }

        return array_values($final);
    }

    private function getMonthlyDataPerKamus()
    {
        $data = Kamus::selectRaw('asal_kamus, MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('asal_kamus', 'bulan')
            ->orderBy('asal_kamus')
            ->get();

        $result = [];

        foreach ($data as $row) {
            if (!isset($result[$row->asal_kamus])) {
                // isi default 12 bulan semua 0
                $result[$row->asal_kamus] = array_fill(1, 12, 0);
            }
            $result[$row->asal_kamus][$row->bulan] = $row->total;
        }

        return $result;
    }


    // ===============================
    // HALAMAN KAMUS (untuk fitur admin)
    // ===============================

    public function kamus(Request $request)
    {
        $query = DB::table('kamus');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kata', 'like', '%' . $request->search . '%')
                    ->orWhere('arti', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('asal_kamus')) {
            $query->where('asal_kamus', $request->asal_kamus);
        }

        $perPage = $request->get('per_page', 10);
        $dataKamus = $query->paginate($perPage);

        $asalKamusList = DB::table('kamus')
            ->select('asal_kamus')
            ->distinct()
            ->pluck('asal_kamus');

        return view('admin.kamus', compact('dataKamus', 'asalKamusList'));
    }

    // ===============================
    // DATA KOREKSI KATA
    // ===============================

    public function koreksikata()
    {
        $kamusList = DB::table('kamus')
            ->select('asal_kamus')
            ->distinct()
            ->orderBy('asal_kamus')
            ->pluck('asal_kamus');

        $koreksis = DB::table('koreksi_kata')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.pelayanan.koreksikata', compact('kamusList', 'koreksis'));
    }

    // ===============================
    // DATA PENGAJUAN KOSAKATA
    // ===============================

    public function pengajuan(Request $request)
    {
        $query = \App\Models\PengajuanKosakata::query();

        if ($request->filled('search')) {
            $query->where('kata', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('asal_kamus')) {
            $query->where('asal_kamus', $request->asal_kamus);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        $daftarAsalKamus = Kamus::select('asal_kamus')
            ->distinct()
            ->pluck('asal_kamus')
            ->toArray();

        return view('admin.pelayanan.pengajuan', compact('data', 'daftarAsalKamus'));
    }
}
