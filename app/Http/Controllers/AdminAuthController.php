<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Kamus;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Services\GmailService;

class AdminAuthController extends Controller
{
    /* ===============================
     * LOGIN
     * =============================== */
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_id'            => $admin->id,
                'admin_name'          => $admin->name,
                'admin_username'      => $admin->username,
                'admin_is_superadmin' => $admin->is_superadmin,
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('admin.login')->with('success', 'Berhasil logout!');
    }

    /* ===============================
     * DASHBOARD
     * =============================== */
    public function dashboard(Request $request)
    {
        if (!$request->session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::findOrFail(session('admin_id'));

        $kuansingCount = Kamus::where('asal_kamus', 'Kamus Indonesia - Kuantan Singingi')->count();
        $siakCount     = Kamus::where('asal_kamus', 'Kamus Indonesia - Melayu Siak')->count();
        $rohilCount    = Kamus::where('asal_kamus', 'Kamus Indonesia - Rokan Hilir')->count();
        $inhilCount    = Kamus::where('asal_kamus', 'Kamus Indonesia - Indragiri Hulu')->count();

        $kosakataPerBulan = Kamus::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $bulanLabels = $kosakataPerBulan->keys()->map(
            fn($b) => date('M', mktime(0, 0, 0, $b, 1))
        );

        return view('admin.dashboard', [
            'admin'        => $admin,
            'kuansingCount' => $kuansingCount,
            'siakCount'    => $siakCount,
            'rohilCount'   => $rohilCount,
            'inhilCount'   => $inhilCount,
            'bulanLabels'  => $bulanLabels,
            'dataKosakata' => $kosakataPerBulan->values(),
        ]);
    }

    /* ===============================
     * FORGOT PASSWORD
     * =============================== */
    public function showForgotPassword()
    {
        return view('admin.forgot_password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        $code = random_int(100000, 999999);

        $admin->update([
            'reset_token'      => Hash::make($code),
            'reset_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // KIRIM OTP VIA GMAIL API (PAKAI VIEW YANG SUDAH ADA)
        (new GmailService())->send(
            $admin->email,
            'Kode Reset Password Admin',
            view('emails.admin.reset_code', [
                'admin' => $admin,
                'code'  => $code,
            ])->render()
        );

        session(['admin_reset_email' => $admin->email]);

        return redirect()->route('admin.verify.otp')
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showVerifyOtp()
    {
        if (!session()->has('admin_reset_email')) {
            return redirect()->route('admin.forgot')
                ->with('error', 'Silakan masukkan email terlebih dahulu.');
        }

        return view('admin.verify_otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ]);

        $admin = Admin::where('email', session('admin_reset_email'))->first();

        if (
            !$admin ||
            !$admin->reset_token ||
            !$admin->reset_expires_at
        ) {
            return redirect()->route('admin.forgot')
                ->with('error', 'Token tidak valid.');
        }

        if (Carbon::now()->gt($admin->reset_expires_at)) {
            return redirect()->route('admin.forgot')
                ->with('error', 'Kode telah kedaluwarsa.');
        }

        if (!Hash::check($request->code, $admin->reset_token)) {
            return back()->with('error', 'Kode tidak cocok.');
        }

        session(['admin_reset_verified' => true]);

        return redirect()->route('admin.reset')
            ->with('success', 'Kode valid. Silakan buat password baru.');
    }

    public function showResetPassword()
    {
        if (
            !session()->has('admin_reset_verified') ||
            !session()->has('admin_reset_email')
        ) {
            return redirect()->route('admin.forgot')
                ->with('error', 'Akses ditolak.');
        }

        return view('admin.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = Admin::where('email', session('admin_reset_email'))->first();
        if (!$admin) {
            return redirect()->route('admin.forgot')
                ->with('error', 'Akun tidak ditemukan.');
        }

        $admin->update([
            'password'         => Hash::make($request->password),
            'reset_token'      => null,
            'reset_expires_at' => null,
        ]);

        session()->forget([
            'admin_reset_email',
            'admin_reset_verified',
        ]);

        // EMAIL NOTIFIKASI PASSWORD BERHASIL DIUBAH
        (new GmailService())->send(
            $admin->email,
            'Password Admin Berhasil Diubah',
            view('emails.admin.changed', [
                'admin' => $admin,
            ])->render()
        );

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
