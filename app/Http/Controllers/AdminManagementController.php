<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\PendingAdmin;
use App\Services\GmailService;

class AdminManagementController extends Controller
{
    /**
     * SIMPAN ADMIN BARU (PENDING)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:admins,username',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
        ]);

        $token = Str::random(60);

        $pending = PendingAdmin::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'token'    => $token,
        ]);

        // kirim email ke superadmin
        $superadminEmail = Admin::where('is_superadmin', 1)->value('email');

        if ($superadminEmail) {
            $approveUrl = route('admin.approve', $token);

            app(GmailService::class)->send(
                $superadminEmail,
                'Persetujuan Admin Baru',
                view('emails.approval_admin', [
                    'name'       => $pending->name,
                    'approveUrl' => $approveUrl,
                ])->render()
            );
        }

        return back()->with('success', 'Admin berhasil didaftarkan dan menunggu persetujuan superadmin.');
    }

    /**
     * HALAMAN APPROVAL (SUPERADMIN)
     */
    public function approvePage($token)
    {
        $pending = PendingAdmin::where('token', $token)->first();

        if (!$pending) {
            return redirect()->route('admin.login')
                ->with('error', 'Token persetujuan tidak valid atau sudah digunakan.');
        }

        return view('approval_admin', compact('pending'));
    }

    /**
     * SETUJUI ADMIN
     */
    public function approveProcess($token)
    {
        $pending = PendingAdmin::where('token', $token)->first();

        if (!$pending) {
            return redirect()->route('admin.login')
                ->with('error', 'Token persetujuan tidak valid.');
        }

        // pindahkan ke tabel admins
        Admin::create([
            'name'          => $pending->name,
            'username'      => $pending->username,
            'email'         => $pending->email,
            'password'      => $pending->password,
            'is_superadmin' => 0,
        ]);

        // kirim email ke pengaju (DITERIMA)
        app(GmailService::class)->send(
            $pending->email,
            'Akun Admin Anda Disetujui',
            view('emails.admin_approved', [
                'name'     => $pending->name,
                'loginUrl' => route('admin.login'),
            ])->render()
        );

        $pending->delete();

        return redirect()->route('admin.login')
            ->with('success', 'Admin berhasil disetujui dan email notifikasi terkirim.');
    }

    /**
     * TOLAK ADMIN
     */
    public function rejectProcess($token)
    {
        $pending = PendingAdmin::where('token', $token)->first();

        if (!$pending) {
            return redirect()->route('admin.login')
                ->with('error', 'Token penolakan tidak valid.');
        }

        // kirim email ke pengaju (DITOLAK)
        app(GmailService::class)->send(
            $pending->email,
            'Permohonan Admin Ditolak',
            view('emails.admin_rejected', [
                'name' => $pending->name,
            ])->render()
        );

        $pending->delete();

        return redirect()->route('admin.login')
            ->with('success', 'Permohonan admin telah ditolak dan email notifikasi terkirim.');
    }
}
