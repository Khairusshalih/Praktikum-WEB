<?php

use App\Http\Controllers\GolonganController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route root - redirect ke dashboard jika sudah login, atau ke login
Route::get('/', function () {
    return Auth::check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});

// Routes untuk Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil. Selamat datang kembali!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email')
            ->with('error', 'Login gagal. Silakan periksa kembali email dan password Anda.');
    });
});

// Routes Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Anda berhasil logout.');
})->middleware('auth')->name('logout');

// Routes yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $totalPegawai = \App\Models\Pegawai::count();
        $totalGolongan = \App\Models\Golongan::count();
        $aktif = \App\Models\Pegawai::where('status', 'aktif')->count();
        return view('dashboard', compact('totalPegawai', 'totalGolongan', 'aktif'));
    })->name('dashboard');

    // Resource CRUD
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('golongan', GolonganController::class);
    Route::resource('komponen-gaji', KomponenGajiController::class);

    // Transaksi Penggajian
    Route::get('/transaksi/penggajian', function () {
        $currentYear = now()->year;
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthName = $monthNames[now()->month - 1];

        $monthlyTransactions = \App\Models\KomponenGaji::where('tahun', $currentYear)->count();
        $totalPaid = \App\Models\KomponenGaji::where('tahun', $currentYear)->sum('gaji_bersih');
        $paidEmployees = \App\Models\KomponenGaji::where('tahun', $currentYear)->distinct('pegawai_id')->count('pegawai_id');

        $transactions = \App\Models\KomponenGaji::with('pegawai.golongan')
            ->orderByDesc('tanggal_gaji')
            ->paginate(10);

        return view('transaksi.penggajian', compact('currentYear', 'monthName', 'monthlyTransactions', 'totalPaid', 'paidEmployees', 'transactions'));
    })->name('transaksi.penggajian');

    Route::get('/transaksi/laporan', function () {
        $reports = \App\Models\KomponenGaji::selectRaw('tahun, bulan, SUM(gaji_bersih) as total, COUNT(*) as transaksi')
            ->groupBy('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->limit(12)
            ->get();

        return view('transaksi.laporan', compact('reports'));
    })->name('transaksi.laporan');

    // Routes Laporan
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