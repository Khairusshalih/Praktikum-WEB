<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use App\Http\Requests\PenggajianRequest;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajian = KomponenGaji::with('pegawai.golongan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->paginate(10);

        return view('penggajian.index', compact('penggajian'));
    }

    public function create()
    {
        $pegawai = Pegawai::where('status', 'aktif')->with('golongan')->get();
        return view('penggajian.create', compact('pegawai'));
    }

    public function store(PenggajianRequest $request)
    {
        $data = $request->validated();

        // Cek duplikasi (satu pegawai hanya boleh digaji sekali per bulan/tahun)
        $sudahAda = KomponenGaji::where('pegawai_id', $data['pegawai_id'])
            ->where('bulan', $data['bulan'])
            ->where('tahun', $data['tahun'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Pegawai ini sudah memiliki data gaji pada bulan/tahun tersebut!');
        }

        $pegawai = Pegawai::with('golongan')->findOrFail($data['pegawai_id']);
        $golongan = $pegawai->golongan;

        // Ambil komponen gaji otomatis dari golongan
        $gajiPokok          = $golongan->gaji_pokok;
        $tunjanganMakan      = $golongan->tunjangan_makan;
        $tunjanganTransport  = $golongan->tunjangan_transport;
        $tunjanganLainnya    = $data['tunjangan_lainnya'] ?? 0;

        $potonganAbsensi = $data['potongan_absensi'] ?? 0;
        $potonganLainnya = $data['potongan_lainnya'] ?? 0;
        $totalPotongan   = $potonganAbsensi + $potonganLainnya;

        // Perhitungan otomatis gaji bersih
        $gajiBersih = $gajiPokok + $tunjanganMakan + $tunjanganTransport
            + $tunjanganLainnya - $totalPotongan;

        KomponenGaji::create([
            'pegawai_id'           => $pegawai->id,
            'bulan'                => $data['bulan'],
            'tahun'                => $data['tahun'],
            'gaji_pokok'           => $gajiPokok,
            'tunjangan_makan'      => $tunjanganMakan,
            'tunjangan_transport'  => $tunjanganTransport,
            'tunjangan_lainnya'    => $tunjanganLainnya,
            'potongan_absensi'     => $potonganAbsensi,
            'potongan_lainnya'     => $potonganLainnya,
            'total_potongan'       => $totalPotongan,
            'gaji_bersih'          => $gajiBersih,
            'status'               => $data['status'],
            'tanggal_gaji'         => $data['tanggal_gaji'],
        ]);

        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil dibuat! Gaji bersih: Rp ' . number_format($gajiBersih, 0, ',', '.'));
    }

    public function show(KomponenGaji $penggajian)
    {
        $penggajian->load('pegawai.golongan');
        return view('penggajian.show', compact('penggajian'));
    }

    public function edit(KomponenGaji $penggajian)
    {
        $pegawai = Pegawai::where('status', 'aktif')->with('golongan')->get();
        return view('penggajian.edit', compact('penggajian', 'pegawai'));
    }

    public function update(PenggajianRequest $request, KomponenGaji $penggajian)
    {
        $data = $request->validated();

        $pegawai  = Pegawai::with('golongan')->findOrFail($data['pegawai_id']);
        $golongan = $pegawai->golongan;

        $gajiPokok          = $golongan->gaji_pokok;
        $tunjanganMakan      = $golongan->tunjangan_makan;
        $tunjanganTransport  = $golongan->tunjangan_transport;
        $tunjanganLainnya    = $data['tunjangan_lainnya'] ?? 0;

        $potonganAbsensi = $data['potongan_absensi'] ?? 0;
        $potonganLainnya = $data['potongan_lainnya'] ?? 0;
        $totalPotongan   = $potonganAbsensi + $potonganLainnya;

        $gajiBersih = $gajiPokok + $tunjanganMakan + $tunjanganTransport
            + $tunjanganLainnya - $totalPotongan;

        $penggajian->update([
            'pegawai_id'           => $pegawai->id,
            'bulan'                => $data['bulan'],
            'tahun'                => $data['tahun'],
            'gaji_pokok'           => $gajiPokok,
            'tunjangan_makan'      => $tunjanganMakan,
            'tunjangan_transport'  => $tunjanganTransport,
            'tunjangan_lainnya'    => $tunjanganLainnya,
            'potongan_absensi'     => $potonganAbsensi,
            'potongan_lainnya'     => $potonganLainnya,
            'total_potongan'       => $totalPotongan,
            'gaji_bersih'          => $gajiBersih,
            'status'               => $data['status'],
            'tanggal_gaji'         => $data['tanggal_gaji'],
        ]);

        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil diupdate!');
    }

    public function destroy(KomponenGaji $penggajian)
    {
        $penggajian->delete();

        return redirect()
            ->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil dihapus!');
    }
}