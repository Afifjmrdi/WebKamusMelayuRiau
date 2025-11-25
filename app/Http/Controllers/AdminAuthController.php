<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kamus;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\AdminResetCodeMail;


class AdminAuthController extends Controller
{
    // 🩵 Tampilkan halaman login admin
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            // simpan semua session di sini
            session([
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_username' => $admin->username,
                'admin_is_superadmin' => $admin->is_superadmin  // ← PENTING
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }



    public function addAdmin(Request $request)
    {
        // hanya superadmin yang boleh
        $admin = Admin::find(session('admin_id'));
        if (!$admin || $admin->is_superadmin != 1) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'username' => 'required|unique:admins,username',
            'password' => 'required|min:6'
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_superadmin' => 0, // admin biasa
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan!');
    }


    // Logout
    public function logout(Request $request)
    {
        $request->session()->forget('admin_id'); // hapus session
        return redirect()->route('admin.login')->with('success', 'Berhasil logout!');
    }

    // 🩵 Dashboard admin
    public function dashboard(Request $request)
    {
        if (!$request->session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::find($request->session()->get('admin_id'));

        // Hitung jumlah kosakata per kamus
        $kuansingCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Kuantan Singingi')->count();
        $siakCount     = Kamus::where('asal_kamus', 'Kamus Indonesia - Melayu Siak')->count();
        $rohilCount    = Kamus::where('asal_kamus', 'Kamus Indonesia - Rokan Hilir')->count();
        $inhilCount    = Kamus::where('asal_kamus', 'Kamus Indonesia - Indragiri Hulu')->count();

        // Data untuk line chart (group by bulan)
        $kosakataPerBulan = Kamus::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $bulanLabels = $kosakataPerBulan->keys()->map(function ($b) {
            return date("M", mktime(0, 0, 0, $b, 1));
        });

        $dataKosakata = $kosakataPerBulan->values();

        return view('admin.dashboard', compact(
            'admin',
            'kuansingCount',
            'siakCount',
            'rohilCount',
            'inhilCount',
            'bulanLabels',
            'dataKosakata'
        ));
    }

    public function profile(Request $request)
    {
        if (!$request->session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::find($request->session()->get('admin_id'));
        return view('admin.profile', compact('admin'));
    }

    // 1) tampilkan form forgot (masukkan email)
    public function showForgotPassword()
    {
        return view('admin.forgot_password');
    }

    // 2) kirim kode (OTP) ke email admin jika ada
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        // buat kode 6 digit
        $code = rand(100000, 999999);

        // simpan token (hash) dan expiry (mis. 15 menit)
        $admin->reset_token = Hash::make($code);
        $admin->reset_expires_at = Carbon::now()->addMinutes(15);
        $admin->save();

        // kirim email (Mailable)
        Mail::to($admin->email)->send(new AdminResetCodeMail($admin, $code));

        // simpan email di session sementara untuk step verify
        session(['admin_reset_email' => $admin->email]);

        return redirect()->route('admin.verify.otp')->with('success', 'Kode OTP telah dikirim ke email anda.');
    }

    // 3) tampilkan form verify otp
    public function showVerifyOtp()
    {
        // pastikan ada email di session, kalau enggak arahkan ke forgot
        if (!session()->has('admin_reset_email')) {
            return redirect()->route('admin.forgot')->with('error', 'Silakan masukkan email terlebih dahulu.');
        }
        return view('admin.verify_otp');
    }

    // 4) verifikasi kode otp
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ]);

        $email = session('admin_reset_email');
        $admin = Admin::where('email', $email)->first();

        if (!$admin || !$admin->reset_token || !$admin->reset_expires_at) {
            return redirect()->route('admin.forgot')->with('error', 'Token tidak ditemukan. Coba ulangi proses.');
        }

        // cek expiry
        if (Carbon::now()->gt($admin->reset_expires_at)) {
            return redirect()->route('admin.forgot')->with('error', 'Kode telah kedaluwarsa. Silakan minta kode baru.');
        }

        // cocokkan code (hash)
        if (!Hash::check($request->code, $admin->reset_token)) {
            return back()->with('error', 'Kode tidak cocok.');
        }

        // tandai verifikasi berhasil: set session flag
        session(['admin_reset_verified' => true]);

        return redirect()->route('admin.reset')->with('success', 'Kode valid. Silakan buat password baru.');
    }

    // 5) tampilkan form reset password
    public function showResetPassword()
    {
        if (!session()->has('admin_reset_verified') || !session()->has('admin_reset_email')) {
            return redirect()->route('admin.forgot')->with('error', 'Akses ditolak. Silakan ulangi proses lupa password.');
        }
        return view('admin.reset_password');
    }

    // 6) proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $email = session('admin_reset_email');
        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return redirect()->route('admin.forgot')->with('error', 'Akun tidak ditemukan.');
        }

        $admin->password = Hash::make($request->password);
        // bersihkan token & expiry
        $admin->reset_token = null;
        $admin->reset_expires_at = null;
        $admin->save();

        // hapus session reset
        session()->forget(['admin_reset_email', 'admin_reset_verified']);

        // kirim notifikasi email perubahan password
        Mail::to($admin->email)->send(new \App\Mail\AdminPasswordChangedMail($admin));

        return redirect()->route('admin.login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
