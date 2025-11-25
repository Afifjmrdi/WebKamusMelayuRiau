<?php

namespace App\Http\Controllers;

use App\Models\Kamus;
use App\Helpers\KamusHelper;
use App\Models\KoreksiKata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoreksiController extends Controller
{
    // =============================
    // 📄 HALAMAN USER
    // =============================
    public function index()
    {
        // gabungkan asal_kamus dari kamus & koreksi_kata
        $kamusList = DB::table('kamus')->select('asal_kamus')
            ->union(
                DB::table('koreksi_kata')->select('asal_kamus')
            )
            ->distinct()
            ->pluck('asal_kamus');

        return view('koreksi', compact('kamusList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asal_kamus' => 'required|string',
            'kata' => 'required|string',
            'bagian_dikoreksi' => 'required|string',
            'nilai_baru' => 'required|string',
            'alasan' => 'required|string',
            'nama_pengoreksi' => 'required|string',
            'email_pengoreksi' => 'nullable|email',
        ]);

        // tambah status default
        $validated['status'] = 'Pending';

        KoreksiKata::create($validated);

        return response()->json(['success' => true, 'message' => 'Koreksi berhasil dikirim, menunggu persetujuan admin.']);
    }

    public function search(Request $request)
    {
        $asal_kamus = $request->query('asal_kamus');
        $q = $request->query('q');

        $query = Kamus::query();
        if ($asal_kamus) {
            $query->where('asal_kamus', $asal_kamus);
        }
        if ($q) {
            $query->where('kata', 'like', "%{$q}%");
        }

        $kataList = $query->limit(10)->pluck('kata');

        return response()->json($kataList);
    }

    public function detail($asal_kamus, $kata)
    {
        $kataDetail = Kamus::where('asal_kamus', $asal_kamus)
            ->where('kata', $kata)
            ->first();

        return response()->json($kataDetail);
    }

    // =============================
    // 📄 HALAMAN ADMIN
    // =============================
    public function adminIndex(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $daftarAsalKamus = KamusHelper::getDaftarAsalKamus();

        $query = KoreksiKata::query();

        if ($request->filled('search')) {
            $query->where('kata', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('asal_kamus')) {
            $query->where('asal_kamus', $request->asal_kamus);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $koreksis = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pelayanan.koreksikata', compact('koreksis', 'daftarAsalKamus'));
    }

    // ✅ Terima pengajuan
    public function approve($id)
    {
        $koreksi = KoreksiKata::findOrFail($id);

        // Update ke tabel kamus
        DB::table('kamus')
            ->where('asal_kamus', $koreksi->asal_kamus)
            ->where('kata', $koreksi->kata)
            ->update([$koreksi->bagian_dikoreksi => $koreksi->nilai_baru]);

        // Tandai diterima
        $koreksi->status = 'diterima';
        $koreksi->save();

        return response()->json(['message' => 'Koreksi diterima dan data kamus diperbarui!']);
    }

    // ❌ Tolak / hapus
    public function destroy($id)
    {
        $koreksi = KoreksiKata::find($id);
        
        if ($koreksi) {
            $koreksi->status = 'ditolak';
            $koreksi->save(); // jangan dihapus, cuma update status
            return response()->json(['message' => 'Data pengajuan ditandai sebagai ditolak.']);
        }

        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    }

    public function deletePermanent($id)
    {
        $koreksi = KoreksiKata::find($id);
        if ($koreksi) {
            $koreksi->delete();
            return response()->json(['message' => 'Data koreksi berhasil dihapus permanen.']);
        }
        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    }
}
