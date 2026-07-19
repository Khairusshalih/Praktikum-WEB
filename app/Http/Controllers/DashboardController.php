<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Data untuk admin (lengkap)
            $totalPegawai = Pegawai::count();
            $totalGolongan = Golongan::count();
            $pegawaiAktif = Pegawai::where('status', 'aktif')->count();
            $totalGajiBulanIni = KomponenGaji::where('bulan', date('n'))
                ->where('tahun', date('Y'))
                ->sum('gaji_bersih');

            $topGaji = KomponenGaji::with('pegawai')
                ->where('bulan', date('n'))
                ->where('tahun', date('Y'))
                ->orderBy('gaji_bersih', 'desc')
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'totalPegawai',
                'totalGolongan',
                'pegawaiAktif',
                'totalGajiBulanIni',
                'topGaji'
            ));
        }

        // Data untuk karyawan (terbatas)
        $pegawai = Pegawai::where('email', $user->email)->first();
        $gajiTerakhir = null;

        if ($pegawai) {
            $gajiTerakhir = KomponenGaji::where('pegawai_id', $pegawai->id)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->first();
        }

        return view('dashboard.karyawan', compact('pegawai', 'gajiTerakhir'));
    }
}