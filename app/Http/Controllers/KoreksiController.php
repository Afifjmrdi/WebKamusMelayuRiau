<?php

namespace App\Http\Controllers;

use App\Models\Kamus;
use App\Models\KoreksiKata;
use App\Helpers\KamusHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoreksiController extends Controller
{
    /* =====================================================
     *  HALAMAN USER
     * ===================================================== */

    public function index()
    {
        $kamusList = DB::table('kamus')->select('asal_kamus')
            ->union(DB::table('kamus')->select('asal_kamus'))
            ->distinct()
            ->pluck('asal_kamus');

        return view('koreksi', compact('kamusList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asal_kamus'       => 'required|string',
            'kata'             => 'required|string',
            'bagian_dikoreksi' => 'required|string',
            'nilai_baru'       => 'required|string',
            'alasan'           => 'required|string',
            'nama_pengoreksi'  => 'required|string',
            'email_pengoreksi' => 'nullable|email',
        ]);

        $validated['status'] = 'pending';

        KoreksiKata::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Koreksi berhasil dikirim dan menunggu persetujuan admin.'
        ]);
    }

    public function search(Request $request)
    {
        $query = Kamus::query();

        if ($request->filled('asal_kamus')) {
            $query->where('asal_kamus', $request->asal_kamus);
        }

        if ($request->filled('q')) {
            $query->where('kata', 'like', '%' . $request->q . '%');
        }

        return response()->json(
            $query->limit(10)->pluck('kata')
        );
    }

    public function detail($asal_kamus, $kata)
    {
        return response()->json(
            Kamus::where('asal_kamus', $asal_kamus)
                ->where('kata', $kata)
                ->first()
        );
    }

    /* =====================================================
     *  HALAMAN ADMIN
     * ===================================================== */

    public function adminIndex(Request $request)
    {
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

        $koreksis = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pelayanan.koreksikata', compact(
            'koreksis',
            'daftarAsalKamus'
        ));
    }

    /* =====================================================
     *  AKSI ADMIN
     * ===================================================== */

    // ✅ TERIMA KOREKSI
    public function approve($id)
    {
        $koreksi = KoreksiKata::findOrFail($id);

        DB::table('kamus')
            ->where('asal_kamus', $koreksi->asal_kamus)
            ->where('kata', $koreksi->kata)
            ->update([
                $koreksi->bagian_dikoreksi => $koreksi->nilai_baru
            ]);

        $koreksi->status = 'diterima';
        $koreksi->save();

        return response()->json([
            'message' => 'Koreksi diterima dan data kamus berhasil diperbarui.'
        ]);
    }

    // ❌ TOLAK KOREKSI (BUKAN DELETE)
    public function reject($id)
    {
        $koreksi = KoreksiKata::findOrFail($id);
        $koreksi->status = 'ditolak';
        $koreksi->save();

        return response()->json([
            'message' => 'Koreksi berhasil ditolak.'
        ]);
    }

    // 🗑️ HAPUS PERMANEN
    public function deletePermanent($id)
    {
        $koreksi = KoreksiKata::findOrFail($id);
        $koreksi->delete();

        return response()->json([
            'message' => 'Data koreksi berhasil dihapus permanen.'
        ]);
    }
}
