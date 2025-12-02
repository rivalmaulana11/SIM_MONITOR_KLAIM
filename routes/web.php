<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CasemixController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\EklaimBpjsController;

// ============================================
// Redirect root ke login
// ============================================
Route::get('/', function () {
    return redirect()->route('login.page');
});

// ============================================
// Authentication Routes (Login/Logout)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login.page');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ============================================
// SUPER ADMIN ROUTES
// ============================================
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    });

// ============================================
// CASEMIX ROUTES
// ============================================
// Route::middleware(['auth', 'role:casemix'])
//     ->prefix('casemix')
//     ->group(function () {

//         Route::get('/dashboard', function () {
//             return view('casemix.dashboard');
//         })->name('casemix.dashboard');

//     });


Route::middleware(['auth', 'role:casemix'])
    ->prefix('casemix')
    ->name('casemix.')
    ->group(function () {

        // INDEX - Route utama
        Route::get('/', [EklaimBpjsController::class, 'index'])
            ->name('index');

        // INDEX - Alias untuk /index (TAMBAHKAN INI)
        Route::get('/index', [EklaimBpjsController::class, 'index']);

        // UPLOAD
        Route::get('/upload', [EklaimBpjsController::class, 'upload'])
            ->name('upload');

        Route::post('/upload', [EklaimBpjsController::class, 'store'])
            ->name('store');

        // DELETE ALL
        Route::delete('/delete-all', [EklaimBpjsController::class, 'deleteAll'])
            ->name('deleteAll');

        // DELETE PER ID
        Route::delete('/{id}', [EklaimBpjsController::class, 'destroy'])
            ->name('destroy');
    });
// ============================================
// KEUANGAN ROUTES
Route::middleware(['auth'])->group(function () {
    // Dashboard Keuangan
    Route::get('/keuangan/dashboard', [KeuanganController::class, 'dashboard'])
        ->name('keuangan.dashboard');
    
    // FB5: Surat Pengajuan Klaim (3 surat otomatis dari upload Casemix)
    Route::get('/keuangan/surat-pengajuan', [KeuanganController::class, 'suratPengajuan'])
        ->name('keuangan.surat-pengajuan');
    
    // FB6: Surat Penerimaan Klaim (2 surat otomatis dari feedback BPJS)
    Route::get('/keuangan/surat-penerimaan', [KeuanganController::class, 'suratPenerimaan'])
        ->name('keuangan.surat-penerimaan');
    
    // FB7: Verifikasi & Arsip Surat
    Route::get('/keuangan/verifikasi-arsip', [KeuanganController::class, 'verifikasiArsip'])
        ->name('keuangan.verifikasi-arsip');
    
    // FB9: Filter Laporan
    Route::get('/keuangan/filter-laporan', [KeuanganController::class, 'filterLaporan'])
        ->name('keuangan.filter-laporan');
});




// Routes untuk Casemix (harus login dan role casemix)
// Route::middleware(['auth'])->prefix('casemix')->name('casemix.')->group(function () {
    
//     // Dashboard Casemix
//     Route::get('/dashboard', [CasemixController::class, 'dashboard'])->name('dashboard');
    
//     // Upload File E-KLAIM
//     Route::post('/upload/eklaim', [CasemixController::class, 'uploadEklaim'])->name('upload.eklaim');
    
//     // Upload File Feedback BPJS
//     Route::post('/upload/feedback', [CasemixController::class, 'uploadFeedback'])->name('upload.feedback');
    
//     // Detail Klaim
//     Route::get('/klaim/{id}', [CasemixController::class, 'detail'])->name('klaim.detail');
    
//     // Kategorikan Klaim (Single)
//     Route::put('/klaim/{id}/kategorikan', [CasemixController::class, 'kategorikan'])->name('klaim.kategorikan');
    
//     // Kategorikan Klaim (Bulk/Multiple)
//     Route::post('/klaim/kategorikan-bulk', [CasemixController::class, 'kategorikanBulk'])->name('klaim.kategorikan-bulk');
    
// });