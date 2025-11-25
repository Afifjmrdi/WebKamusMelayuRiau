<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKosakata;
use App\Models\Kamus;
use App\Models\AdminHistory;
use Illuminate\Http\Request;

class AjukanKosakataController extends Controller
{
    // Halaman pengajuan user
    public function index()
    {
        $daftarAsalKamus = Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus')->toArray();
        return view('ajukan', compact('daftarAsalKamus'));
    }

    // Simpan pengajuan baru (user)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asal_kamus' => 'required|string|max:255',
            'kata' => 'required|string|max:255',
            'suku_kata' => 'required|string|max:255',
            'arti' => 'required|string',
            'kelas_kata' => 'required|string',
            'contoh' => 'nullable|string',
            'asal_pengaju' => 'required|string|max:255',
            'email_pengaju' => 'nullable|email|max:255',
            'alasan_pengajuan' => 'required|string',
        ]);

        $validated['status'] = 'menunggu';

        PengajuanKosakata::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan kosakata berhasil dikirim!'
        ]);
    }

    // Halaman admin pengajuan kosakata
    public function adminIndex(Request $request)
    {
        $query = PengajuanKosakata::query();

        if ($request->filled('search')) {
            $query->where('kata', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('asal_kamus')) {
            $query->where('asal_kamus', $request->asal_kamus);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $daftarAsalKamus = \App\Models\Kamus::select('asal_kamus')->distinct()->pluck('asal_kamus')->toArray();

        // Pakai paginate biar pagination muncul
        $data = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pelayanan.pengajuan', compact('data', 'daftarAsalKamus'));
    }

    // Approve pengajuan
    public function approve($id)
    {
        $pengajuan = PengajuanKosakata::findOrFail($id);

        // Tambahkan ke tabel kamus
        Kamus::create([
            'kata' => $pengajuan->kata,
            'suku_kata' => $pengajuan->suku_kata,
            'kelas_kata' => $pengajuan->kelas_kata,
            'arti' => $pengajuan->arti,
            'contoh' => $pengajuan->contoh,
            'asal_kamus' => $pengajuan->asal_kamus,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update status pengajuan
        $pengajuan->update(['status' => 'diterima']);

        return response()->json(['message' => 'Pengajuan berhasil diterima dan ditambahkan ke kamus!']);
    }

    public function getChartByYear($year)
    {
        $monthlyData = \App\Models\PengajuanKosakata::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $totalYearly = \App\Models\PengajuanKosakata::whereYear('created_at', $year)->count();

        // hitung persentase dari target 10.000
        $target = 10000;
        $percentage = $target > 0 ? round(($totalYearly / $target) * 100, 2) : 0;

        // daftar tahun yang ada
        $years = \App\Models\PengajuanKosakata::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // tambahkan tahun sekarang jika belum ada
        $currentYear = now()->year;
        if (!in_array($currentYear, $years)) {
            array_unshift($years, $currentYear);
        }

        return response()->json([
            'monthlyData' => $monthlyData,
            'totalYearly' => $totalYearly,
            'percentage' => $percentage,
            'years' => $years,
        ]);
    }

    // Reject pengajuan
    public function destroy($id)
    {
        $pengajuan = PengajuanKosakata::findOrFail($id);
        $pengajuan->update(['status' => 'ditolak']);

        return response()->json(['message' => 'Pengajuan berhasil ditolak!']);
    }

    public function hapus($id)
    {
        $item = PengajuanKosakata::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
