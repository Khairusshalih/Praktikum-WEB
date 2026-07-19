<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route login langsung menampilkan view
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Route default redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard berdasarkan role
Route::get('/dashboard/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard.admin');

Route::get('/dashboard/karyawan', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:karyawan'])
    ->name('dashboard.karyawan');

// Route yang hanya bisa diakses admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('golongan', GolonganController::class);
    Route::resource('komponen-gaji', KomponenGajiController::class);

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/slip-gaji', [LaporanController::class, 'slipGaji'])->name('slip-gaji');
        Route::get('/rekap-departemen', [LaporanController::class, 'rekapDepartemen'])->name('rekap-departemen');
        Route::get('/gaji-diatas-rata', [LaporanController::class, 'gajiDiatasRata'])->name('gaji-diatas-rata');
        Route::get('/potongan-terbesar', [LaporanController::class, 'potonganTerbesar'])->name('potongan-terbesar');
        Route::get('/total-gaji-per-bulan', [LaporanController::class, 'totalGajiPerBulan'])->name('total-gaji-per-bulan');
        Route::get('/masa-kerja-5-tahun', [LaporanController::class, 'masaKerjaLimaTahun'])->name('masa-kerja-5-tahun');
        Route::get('/urutan-gaji-bersih', [LaporanController::class, 'urutanGajiBersih'])->name('urutan-gaji-bersih');
        Route::get('/jumlah-pegawai-per-golongan', [LaporanController::class, 'jumlahPegawaiPerGolongan'])->name('jumlah-pegawai-per-golongan');
        Route::get('/rekap-tunjangan', [LaporanController::class, 'rekapTunjangan'])->name('rekap-tunjangan');
        Route::get('/perbandingan-gaji-potongan', [LaporanController::class, 'perbandinganGajiPotongan'])->name('perbandingan-gaji-potongan');
        Route::get('/export-pdf/{jenis}', [LaporanController::class, 'exportPdf'])->name('export-pdf');
    });
});

// Route yang bisa diakses semua user (termasuk karyawan)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Karyawan bisa melihat slip gaji sendiri
    Route::get('/slip-gaji-saya', [LaporanController::class, 'slipGajiSaya'])->name('slip-gaji-saya');
});

// Auth routes (jika menggunakan Breeze)
require __DIR__.'/auth.php';