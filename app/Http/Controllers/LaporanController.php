<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use App\Models\Golongan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Halaman utama laporan (daftar menu laporan)
     */
    public function index()
    {
        return view('laporan.index');
    }

    /**
     * 1. Slip Gaji per Pegawai per Periode
     */
    public function slipGaji(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $data = KomponenGaji::with('pegawai.golongan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        return view('laporan.slip-gaji', compact('data', 'bulan', 'tahun'));
    }

    /**
     * 2. Rekap Gaji per Departemen
     */
    public function rekapDepartemen(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $rekap = KomponenGaji::join('pegawai', 'komponen_gaji.pegawai_id', '=', 'pegawai.id')
            ->select(
                'pegawai.departemen',
                DB::raw('COUNT(*) as jumlah_pegawai'),
                DB::raw('SUM(komponen_gaji.gaji_bersih) as total_gaji'),
                DB::raw('AVG(komponen_gaji.gaji_bersih) as rata_gaji')
            )
            ->where('komponen_gaji.bulan', $bulan)
            ->where('komponen_gaji.tahun', $tahun)
            ->groupBy('pegawai.departemen')
            ->orderByDesc('total_gaji')
            ->get();

        return view('laporan.rekap-departemen', compact('rekap', 'bulan', 'tahun'));
    }

    /**
     * 3. Pegawai dengan Gaji di Atas Rata-rata
     */
    public function gajiDiatasRata(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $rataRata = KomponenGaji::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->avg('gaji_bersih') ?? 0;

        $data = KomponenGaji::with('pegawai.golongan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('gaji_bersih', '>', $rataRata)
            ->orderByDesc('gaji_bersih')
            ->get();

        return view('laporan.gaji-diatas-rata', compact('data', 'rataRata', 'bulan', 'tahun'));
    }

    /**
     * 4. Pegawai dengan Potongan Terbesar (Top 10)
     */
    public function potonganTerbesar(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $data = KomponenGaji::with('pegawai.golongan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderByDesc('total_potongan')
            ->limit(10)
            ->get();

        return view('laporan.potongan-terbesar', compact('data', 'bulan', 'tahun'));
    }

    /**
     * 5. Total Gaji per Bulan (Tren Tahunan)
     */
    public function totalPerBulan(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $data = KomponenGaji::select(
                'bulan',
                DB::raw('SUM(gaji_bersih) as total_gaji'),
                DB::raw('COUNT(*) as jumlah_transaksi')
            )
            ->where('tahun', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('laporan.total-per-bulan', compact('data', 'tahun'));
    }

    /**
     * 6. Pegawai dengan Masa Kerja Lebih dari 5 Tahun
     */
    public function masaKerja()
    {
        $batasTanggal = Carbon::now()->subYears(5);

        $data = Pegawai::with('golongan')
            ->where('tanggal_masuk', '<=', $batasTanggal)
            ->orderBy('tanggal_masuk')
            ->get()
            ->map(function ($pegawai) {
                $pegawai->masa_kerja_tahun = Carbon::parse($pegawai->tanggal_masuk)->diffInYears(now());
                return $pegawai;
            });

        return view('laporan.masa-kerja', compact('data'));
    }

    /**
     * 7. Urutan Gaji Bersih Tertinggi ke Terendah
     */
    public function urutanGaji(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $data = KomponenGaji::with('pegawai.golongan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderByDesc('gaji_bersih')
            ->get();

        return view('laporan.urutan-gaji', compact('data', 'bulan', 'tahun'));
    }

    /**
     * 8. Jumlah Pegawai per Golongan
     */
    public function pegawaiPerGolongan()
    {
        $data = Golongan::withCount('pegawai')
            ->orderByDesc('pegawai_count')
            ->get();

        $totalPegawai = Pegawai::count();

        return view('laporan.pegawai-per-golongan', compact('data', 'totalPegawai'));
    }

    /**
     * 9. Rekap Tunjangan (Makan, Transport, Lainnya)
     */
    public function rekapTunjangan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $rekap = KomponenGaji::select(
                DB::raw('SUM(tunjangan_makan) as total_makan'),
                DB::raw('SUM(tunjangan_transport) as total_transport'),
                DB::raw('SUM(tunjangan_lainnya) as total_lainnya'),
                DB::raw('COUNT(*) as jumlah_pegawai')
            )
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        return view('laporan.rekap-tunjangan', compact('rekap', 'bulan', 'tahun'));
    }

    /**
     * 10. Perbandingan Gaji Pokok vs Potongan per Departemen
     */
    public function perbandinganGajiPotongan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $data = KomponenGaji::join('pegawai', 'komponen_gaji.pegawai_id', '=', 'pegawai.id')
            ->select(
                'pegawai.departemen',
                DB::raw('SUM(komponen_gaji.gaji_pokok) as total_gaji_pokok'),
                DB::raw('SUM(komponen_gaji.total_potongan) as total_potongan'),
                DB::raw('ROUND(SUM(komponen_gaji.total_potongan) / SUM(komponen_gaji.gaji_pokok) * 100, 2) as persentase_potongan')
            )
            ->where('komponen_gaji.bulan', $bulan)
            ->where('komponen_gaji.tahun', $tahun)
            ->groupBy('pegawai.departemen')
            ->orderByDesc('total_gaji_pokok')
            ->get();

        return view('laporan.perbandingan-gaji-potongan', compact('data', 'bulan', 'tahun'));
    }
}