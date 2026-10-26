<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

// Import Controllers
use App\Http\Controllers\KamusController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\KoreksiController;
use App\Http\Controllers\AjukanKosakataController;
use App\Http\Controllers\KamusIstilahController;
use App\Http\Controllers\KamusIstilahAdminController;

// Import Middleware & Models
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\RecordVisitor;
use App\Models\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

# ===============================
#   HALAMAN UMUM (DENGAN VISITOR)
# ===============================
Route::middleware([RecordVisitor::class])->group(function () {

    // Splash & Landing
    Route::get('/', function () {
        return view('splash');
    })->name('splash');

    Route::get('/home', [KamusController::class, 'index'])->name('home');
    Route::get('/tentang', fn() => view('tentang'))->name('tentang');

    // Kamus Utama (Search & Detail)
    Route::post('/track-search', [KamusController::class, 'trackSearch'])->name('track.search');
    Route::get('/kamus/{id}', [KamusController::class, 'detailJson'])->name('kamus.detail.json');
    Route::get('/search', [KamusController::class, 'search'])->name('search');
    Route::get('/kosakata-menarik', [KamusController::class, 'kosakataMenarik']);

    // Kamus Istilah (Route yang tadinya Error 500)
    Route::get('/kamus-istilah', [KamusIstilahController::class, 'index'])->name('kamus.istilah');
    Route::get('/search-istilah', [KamusIstilahController::class, 'search']);

    // Form Ajukan & Koreksi (User Side)
    Route::get('/ajukan', [AjukanKosakataController::class, 'index'])->name('ajukan.index');
    Route::post('/ajukan', [AjukanKosakataController::class, 'store'])->name('ajukan.store');

    Route::get('/koreksi', [KoreksiController::class, 'index'])->name('koreksi.index');
    Route::post('/koreksi', [KoreksiController::class, 'store'])->name('koreksi.store');
    Route::get('/koreksi/search', [KoreksiController::class, 'search'])->name('koreksi.search');
    Route::get('/koreksi/detail/{asal_kamus}/{kata}', [KoreksiController::class, 'detail'])->name('koreksi.detail');
});

# ===============================
#   ADMIN AUTHENTICATION (GUEST)
# ===============================
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Password Reset
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('admin.forgot');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetCode'])->name('admin.forgot.post');
    Route::get('/verify-otp', [AdminAuthController::class, 'showVerifyOtp'])->name('admin.verify.otp');
    Route::post('/verify-otp', [AdminAuthController::class, 'verifyOtp'])->name('admin.verify.otp.post');
    Route::get('/reset-password', [AdminAuthController::class, 'showResetPassword'])->name('admin.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('admin.reset.post');
});

# ===============================
#   ADMIN REGISTRATION & APPROVAL
# ===============================
Route::post('/admin/pending', [AdminManagementController::class, 'store'])->name('pending.store');
Route::get('/admin/approve/{token}', [AdminManagementController::class, 'approvePage'])->name('admin.approve');
Route::post('/admin/approve/{token}', [AdminManagementController::class, 'approveProcess'])->name('admin.approve.post');
Route::post('/admin/reject/{token}', [AdminManagementController::class, 'rejectProcess'])->name('admin.reject.post');

# ===============================
#   ADMIN LOGGED IN AREA (CRUD)
# ===============================
Route::middleware([AdminAuth::class])->prefix('admin')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');

    # Manajemen Kamus Istilah
    Route::prefix('kamus-istilah')->group(function () {
        Route::get('/', [KamusIstilahAdminController::class, 'index'])->name('admin.kamus-istilah.dataistilah');
        Route::get('/template', [KamusIstilahAdminController::class, 'downloadTemplate'])->name('admin.kamus-istilah.template');
        Route::get('/{id}', [KamusIstilahAdminController::class, 'show'])->name('admin.kamus-istilah.show');
        Route::post('/store', [KamusIstilahAdminController::class, 'store'])->name('admin.kamus-istilah.store');
        Route::post('/import', [KamusIstilahAdminController::class, 'import'])->name('admin.kamus-istilah.import');
        Route::post('/bulk-delete', [KamusIstilahAdminController::class, 'bulkDelete'])->name('admin.kamus-istilah.bulk-delete');
        Route::put('/{id}', [KamusIstilahAdminController::class, 'update'])->name('admin.kamus-istilah.update');
        Route::delete('/{id}', [KamusIstilahAdminController::class, 'destroy'])->name('admin.kamus-istilah.destroy');
    });

    # Manajemen Kamus Umum
    Route::prefix('kamus')->group(function () {
        Route::get('/', [KamusController::class, 'adminKamus'])->name('admin.kamus');
        Route::get('/create', [KamusController::class, 'create'])->name('admin.create');
        Route::get('/template-import', [KamusController::class, 'downloadTemplateImport'])->name('admin.kamus.template');
        Route::get('/{id}/edit', [KamusController::class, 'edit'])->name('admin.edit');
        Route::post('/store', [KamusController::class, 'store'])->name('admin.kamus.store');
        Route::post('/import', [KamusController::class, 'import'])->name('admin.kamus.import');
        Route::post('/import/preview', [KamusController::class, 'previewImport'])->name('admin.kamus.import.preview');
        Route::post('/bulk-destroy', [KamusController::class, 'bulkDestroy'])->name('admin.kamus.bulkDestroy');
        Route::put('/{id}', [KamusController::class, 'update'])->name('admin.update');
        Route::delete('/{id}', [KamusController::class, 'destroy'])->name('admin.destroy');
    });

    # Pelayanan (Koreksi & Pengajuan)
    Route::get('/pelayanan/pengajuan', [DashboardController::class, 'pengajuan'])->name('admin.pelayanan.pengajuan');
    Route::get('/pelayanan/koreksikata', [KoreksiController::class, 'adminIndex'])->name('admin.pelayanan.koreksikata');
    Route::post('/pelayanan/koreksikata/store', [DashboardController::class, 'storeKoreksi'])->name('admin.pelayanan.koreksikata.store');

    Route::prefix('pengajuan')->group(function () {
        Route::get('/', [AjukanKosakataController::class, 'adminIndex'])->name('admin.pengajuan');
        Route::get('/chart', [AjukanKosakataController::class, 'getChartData'])->name('admin.pengajuan.chart');
        Route::post('/{id}/approve', [AjukanKosakataController::class, 'approve']);
        Route::delete('/{id}/hapus', [AjukanKosakataController::class, 'hapus'])->name('admin.pengajuan.hapus');
    });

    Route::prefix('koreksi')->group(function () {
        Route::post('/{id}/approve', [KoreksiController::class, 'approve'])->name('admin.koreksi.approve');
        Route::post('/{id}/reject', [KoreksiController::class, 'reject'])->name('admin.koreksi.reject');
        Route::delete('/{id}/hapus', [KoreksiController::class, 'deletePermanent'])->name('admin.koreksi.delete');
    });
});

# ===============================
#   UTILITIES
# ===============================
Route::get('/reset-admin-password', function () {
    $admin = Admin::where('username', 'admin')->first();
    if ($admin) {
        $admin->password = Hash::make('password_baru');
        $admin->save();
        return "Password berhasil diubah!";
    }
    return "Admin tidak ditemukan.";
});
