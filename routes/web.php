<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\KamusController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\KataController;
use App\Http\Controllers\KoreksiController;
use App\Http\Controllers\AjukanKosakataController;
use App\Http\Middleware\AdminAuth;
use App\Models\Admin;
use App\Models\Visitor;
use Carbon\Carbon;

// Home page
Route::get('/', function () {
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

    return view('home');
});

// Route publik lain sama logikanya
Route::get('/tentang', function () {
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

    return view('tentang');
});


# =========================
#  HALAMAN UMUM
# =========================
Route::get('/', [KamusController::class, 'index'])->name('home');
// (opsional) ambil detail kamus by id (dipakai openKata untuk tampilkan detail)
Route::post('/track-search', [KamusController::class, 'trackSearch'])->name('track.search');
Route::get('/kamus/{id}', [KamusController::class, 'detailJson'])->name('kamus.detail.json');
Route::get('/search', [KamusController::class, 'search'])->name('search');
Route::get('/tentang', fn() => view('tentang'))->name('tentang');


# =========================
#  AJUKAN KOSAKATA (USER)
# =========================
Route::get('/ajukan', [AjukanKosakataController::class, 'index'])->name('ajukan.index');
Route::post('/ajukan', [AjukanKosakataController::class, 'store'])->name('ajukan.store');


# =========================
#  KOREKSI KATA (USER)
# =========================
Route::get('/koreksi', [KoreksiController::class, 'index'])->name('koreksi.index');
Route::post('/koreksi', [KoreksiController::class, 'store'])->name('koreksi.store');
Route::get('/koreksi/search', [KoreksiController::class, 'search'])->name('koreksi.search');
Route::get('/koreksi/detail/{asal_kamus}/{kata}', [KoreksiController::class, 'detail'])->name('koreksi.detail');
Route::delete('/admin/koreksi/{id}', [KoreksiController::class, 'destroy'])->name('admin.koreksi.destroy');
Route::middleware([AdminAuth::class])->prefix('admin')->group(function () {

    // Koreksi Kata
    Route::post('/koreksi/{id}/approve', [KoreksiController::class, 'approve'])
        ->name('admin.koreksi.approve');

    Route::delete('/koreksi/{id}/hapus', [KoreksiController::class, 'deletePermanent'])
        ->name('admin.koreksi.delete');
});

# =========================
#  LOGIN & AUTH ADMIN (TIDAK ADA MIDDLEWARE)
# =========================
Route::prefix('admin')->group(function () {
    // Login / Logout
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Forgot password (BISA DIAKSES TANPA LOGIN)
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('admin.forgot');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetCode'])->name('admin.forgot.post');

    Route::get('/verify-otp', [AdminAuthController::class, 'showVerifyOtp'])->name('admin.verify.otp');
    Route::post('/verify-otp', [AdminAuthController::class, 'verifyOtp'])->name('admin.verify.otp.post');

    Route::get('/reset-password', [AdminAuthController::class, 'showResetPassword'])->name('admin.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.reset.post');
});

# =========================
#  ADMIN PENDING (TIDAK BOLEH ADA MIDDLEWARE!)
# =========================

Route::post('/admin/pending', [AdminManagementController::class, 'store'])
    ->name('pending.store');

# Approve admin (link dari email)
Route::get('/admin/approve/{token}', [AdminManagementController::class, 'approveAdmin'])
    ->name('admin.approve');


Route::post('/admin/add', [AdminAuthController::class, 'addAdmin'])
    ->middleware(AdminAuth::class)
    ->name('admin.addAdmin');


# =========================
#  AREA ADMIN (HARUS LOGIN)
# =========================
Route::middleware([AdminAuth::class])->prefix('admin')->group(function () {

    # Dashboard & Profil
    // Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');

    # Pelayanan
    Route::get('/pelayanan/pengajuan', [DashboardController::class, 'pengajuan'])->name('admin.pelayanan.pengajuan');
    Route::get('/pelayanan/koreksikata', [KoreksiController::class, 'adminIndex'])->name('admin.pelayanan.koreksikata');
    Route::post('/pelayanan/koreksikata', [DashboardController::class, 'storeKoreksi'])->name('admin.pelayanan.koreksikata.store');

    # Pengajuan Kosakata
    Route::get('/pengajuan', [AjukanKosakataController::class, 'adminIndex'])->name('admin.pengajuan');
    Route::post('/pengajuan/{id}/approve', [AjukanKosakataController::class, 'approve']);
    Route::delete('/pengajuan/{id}', [AjukanKosakataController::class, 'destroy']);
    Route::delete('/pengajuan/{id}/hapus', [AjukanKosakataController::class, 'hapus'])->name('admin.pengajuan.hapus');
    Route::get('/pengajuan/chart', [AjukanKosakataController::class, 'getChartData'])->name('admin.pengajuan.chart');
    Route::get('/chart-data/{year}', [AjukanKosakataController::class, 'getChartByYear'])->name('admin.chart-data');

    # Kamus (CRUD)
    Route::post('/admin/kamus/bulk-destroy', [KamusController::class, 'bulkDestroy'])->name('admin.kamus.bulkDestroy');
    Route::get('/kamus', [KamusController::class, 'adminKamus'])->name('admin.kamus');
    Route::get('/kamus/create', [KamusController::class, 'create'])->name('admin.create');
    Route::post('/admin/kamus/store', [KamusController::class, 'store'])->name('admin.kamus.store');
    Route::post('/kamus', [KamusController::class, 'store'])->name('admin.store');
    Route::get('/kamus/{id}/edit', [KamusController::class, 'edit'])->name('admin.edit');
    Route::put('/kamus/{id}', [KamusController::class, 'update'])->name('admin.update');
    Route::delete('/kamus/{id}', [KamusController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/kamus/import', [KamusController::class, 'import'])->name('admin.kamus.import');
});

# =========================
#  TOOLS: UBAH PASSWORD ADMIN VIA URL
# =========================
Route::get('/reset-admin-password', function () {
    $admin = Admin::where('username', 'admin')->first();
    if ($admin) {
        $admin->password = Hash::make('password_baru');
        $admin->save();
        return "Password berhasil diubah!";
    }
    return "Admin tidak ditemukan.";
});
