<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Klien\ProfilController;
use App\Http\Controllers\Klien\PendaftaranController;
use App\Http\Controllers\Klien\TransaksiController;
use App\Http\Controllers\Klien\DokumenController;
use App\Http\Controllers\Klien\BahanController;
use App\Http\Controllers\Keuangan\KeuanganController;
use App\Http\Controllers\Konsultan\KonsultanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Konsultan\EvaluasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // GATEWAY DASHBOARD (Satu rute untuk semua Dashboard Role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ----------------------------------------------------------------------
    // ROLE: KLIEN
    // ----------------------------------------------------------------------
    Route::middleware('role:klien')->prefix('klien')->name('klien.')->group(function () {

        // --- LEVEL 0: Profil Perusahaan (Wajib diisi di awal) ---
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store');

        // Middleware profil.lengkap memastikan Lvl 0 selesai
        Route::middleware('profil.lengkap')->group(function () {

            // --- LEVEL 1: Pendaftaran (Otomatis cek pendaftaran aktif) ---
            Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
            Route::get('/pendaftaran/baru', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
            Route::post('/pendaftaran/baru', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

            // --- LEVEL 2 & 7: Transaksi (Invoice & Pembayaran) ---
            // Sesuaikan TransaksiController agar method storeBayar menangani upload bukti
            Route::get('/transaksi/invoice/{id}', [TransaksiController::class, 'invoice'])->name('transaksi.invoice');
            Route::post('/transaksi/bayar/{id}', [TransaksiController::class, 'storeBayar'])->name('transaksi.store');
            Route::get('/transaksi/invoice/{id}/download', [TransaksiController::class, 'downloadPdf'])->name('transaksi.download_pdf');

            // --- LEVEL 3: Dokumen (Hanya terbuka jika Level >= 2 / Sudah Bayar DP) ---
            Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
            Route::post('/dokumen/upload', [DokumenController::class, 'upload'])->name('dokumen.upload');
            Route::get('/dokumen/view/{path}', [DokumenController::class, 'viewFile'])->where('path', '.*')->name('dokumen.view');
            Route::delete('/dokumen/delete/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

            // --- LEVEL 4: Bahan Baku ---
            Route::get('/bahan', [BahanController::class, 'index'])->name('bahan.index');
            Route::post('/bahan', [BahanController::class, 'store'])->name('bahan.store');
            Route::delete('/bahan/{id}', [BahanController::class, 'destroy'])->name('bahan.destroy');

            // --- LEVEL 9: Penerbitan & Download ---
            Route::get('/sertifikat', [PendaftaranController::class, 'sertifikat'])->name('sertifikat.index');
        });
    });

    // ----------------------------------------------------------------------
    // ROLE: KEUANGAN (Verifikasi Pembayaran)
    // ----------------------------------------------------------------------
    Route::middleware('role:keuangan')->prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/dashboard', [KeuanganController::class, 'dashboard'])->name('dashboard');
        Route::get('/termin-1', [KeuanganController::class, 'termin1'])->name('termin1');
        Route::get('/termin-2', [KeuanganController::class, 'termin2'])->name('termin2');
        Route::post('/verifikasi/{id}', [KeuanganController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/tolak/{id}', [KeuanganController::class, 'tolak'])->name('tolak');
    });

    // ----------------------------------------------------------------------
    // ROLE: KONSULTAN
    // ----------------------------------------------------------------------
    Route::middleware(['auth', 'role:konsultan'])->prefix('konsultan')->name('konsultan.')->group(function () {

        // --- DASHBOARD ---
        Route::get('/dashboard', [KonsultanController::class, 'index'])->name('dashboard');

        // --- PENGECEKAN TEKNIS (EvaluasiController) ---
        Route::prefix('evaluasi')->name('evaluasi.')->group(function () {
            // Halaman List
            Route::get('/validasi-dokumen', [EvaluasiController::class, 'indexDokumen'])->name('dokumen');
            Route::get('/evaluasi-bahan', [EvaluasiController::class, 'indexBahan'])->name('bahan');

            // Pengerjaan Detail
            Route::get('/review/{id}', [EvaluasiController::class, 'showReview'])->name('show');
            Route::get('/view-file/{id}', [EvaluasiController::class, 'viewFile'])->name('view.file');

            // Aksi Validasi (PENTING: Ini yang membuka gerbang Level 5, 6 & 7)
            Route::post('/validasi-dokumen/{id}', [EvaluasiController::class, 'validasiDokumen'])->name('validasi.dokumen');
            Route::post('/validasi-bahan/{id}', [EvaluasiController::class, 'validasiBahan'])->name('validasi.bahan');
        });

        // --- AUDIT LAPANGAN (KonsultanController) ---
        Route::prefix('audit')->name('audit.')->group(function () {
            Route::get('/', [KonsultanController::class, 'listAudit'])->name('index');
            Route::get('/form/{id}', [KonsultanController::class, 'formAudit'])->name('form');
            Route::post('/upload/{id}', [KonsultanController::class, 'uploadLHA'])->name('upload');
        });
    });

    // ----------------------------------------------------------------------
    // ROLE: ADMIN
    // ----------------------------------------------------------------------
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

        // --- DASHBOARD ---
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // --- MANAJEMEN OPERASIONAL (Alur Sertifikasi) ---
        Route::prefix('operasional')->name('operasional.')->group(function () {

            // Level 3: Plotting
            Route::get('/plotting', [AdminController::class, 'indexPlotting'])->name('plotting');
            // FIXED: Menghapus 'operasional' dari URL karena sudah ada di prefix
            Route::post('/assign', [AdminController::class, 'assignKonsultan'])->name('assign');

            // Level 8: Sidang Fatwa
            Route::get('/sidang-fatwa', [AdminController::class, 'indexSidang'])->name('sidang.index');
            Route::post('/sidang-fatwa/{id}', [AdminController::class, 'uploadKetetapan'])->name('sidang.upload');
            Route::get('/view-lha/{id}', [AdminController::class, 'viewLha'])->name('sidang.view_lha');

            // Level 10: Penerbitan Sertifikat
            Route::get('/penerbitan', [AdminController::class, 'indexPenerbitan'])->name('sertifikat.index');
            Route::post('/penerbitan/{id}', [AdminController::class, 'uploadSertifikatFinal'])->name('sertifikat.upload');

            // FIXED: Menghapus 'admin/pendaftaran' dari URL karena sudah di dalam prefix admin & operasional
            Route::put('/tolak/{id}', [AdminController::class, 'tolakPendaftaran'])->name('pendaftaran.tolak');
            Route::put('/konfirmasi-pembayaran/{id}', [AdminController::class, 'konfirmasiPembayaran'])->name('konfirmasi_pembayaran');
        });

        // --- DATA MASTER (Manajemen User & Paket) ---
        // User CRUD
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Paket Harga CRUD
        Route::get('/paket', [UserController::class, 'paketIndex'])->name('paket.index');
        Route::put('/paket/{id}', [UserController::class, 'paketUpdate'])->name('paket.update');
    });

    // --- Breeze Profile ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
