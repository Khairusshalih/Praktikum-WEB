<?php

use App\Http\Controllers\GolonganController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

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

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Anda berhasil logout.');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('golongan', GolonganController::class);

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
});

Route::resource('penggajian', PenggajianController::class);

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('/slip-gaji', [LaporanController::class, 'slipGaji'])->name('slip-gaji');
    Route::get('/rekap-departemen', [LaporanController::class, 'rekapDepartemen'])->name('rekap-departemen');
    Route::get('/gaji-diatas-rata', [LaporanController::class, 'gajiDiatasRata'])->name('gaji-diatas-rata');
    Route::get('/potongan-terbesar', [LaporanController::class, 'potonganTerbesar'])->name('potongan-terbesar');
    Route::get('/total-per-bulan', [LaporanController::class, 'totalPerBulan'])->name('total-per-bulan');
    Route::get('/masa-kerja', [LaporanController::class, 'masaKerja'])->name('masa-kerja');
    Route::get('/urutan-gaji', [LaporanController::class, 'urutanGaji'])->name('urutan-gaji');
    Route::get('/pegawai-per-golongan', [LaporanController::class, 'pegawaiPerGolongan'])->name('pegawai-per-golongan');
    Route::get('/rekap-tunjangan', [LaporanController::class, 'rekapTunjangan'])->name('rekap-tunjangan');
    Route::get('/perbandingan-gaji-potongan', [LaporanController::class, 'perbandinganGajiPotongan'])->name('perbandingan-gaji-potongan');
});
