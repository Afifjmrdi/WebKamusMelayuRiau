<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PendingAdmin;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminApprovalMail;

class AdminManagementController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input + cek ke dua tabel sekaligus
        $request->validate([
            'name' => 'required|string|max:255',

            // username unique di 2 tabel
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:admins,username',
                'unique:pending_admins,username',
            ],

            // email unique di 2 tabel
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admins,email',
                'unique:pending_admins,email',
            ],

            'password' => 'required|min:6'
        ], [
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain ya.',
        ]);


        // Simpan ke pending_admins
        $pending = PendingAdmin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => bin2hex(random_bytes(32)),
        ]);

        // Ambil superadmin
        $superadmin = Admin::where('is_superadmin', 1)->first();

        if (!$superadmin) {
            return back()->with('error', 'Superadmin tidak ditemukan!');
        }

        // Kirim email approval
        Mail::to($superadmin->email)->send(new AdminApprovalMail($pending));

        return back()->with('success', 'Admin baru berhasil ditambahkan. Silakan lakukan persetujuan melalui email superadmin.');
    }

    public function approveAdmin($token)
    {
        $pending = PendingAdmin::where('token', $token)->first();

        if (!$pending) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Token tidak valid.');
        }

        Admin::create([
            'name' => $pending->name,
            'username' => $pending->username,
            'email' => $pending->email,
            'password' => $pending->password,
            'is_superadmin' => false,
        ]);

        $pending->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin berhasil disetujui dan telah aktif.');
    }
}
