<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use App\Http\Requests\KomponenGajiRequest;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KomponenGaji::with('pegawai.golongan');

        // Filter berdasarkan pegawai
        if ($request->filled('pegawai_id')) {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan periode
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $komponenGaji = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Data untuk filter
        $pegawaiList = Pegawai::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $bulanList = $this->getBulanList();
        $tahunList = range(2020, date('Y') + 1);
        $statusList = ['draft', 'diproses', 'selesai'];

        // Statistik ringkasan
        $totalGajiBersih = $query->clone()->sum('gaji_bersih');
        $totalPegawaiDigaji = $query->clone()->distinct('pegawai_id')->count('pegawai_id');
        $rataRataGaji = $query->clone()->avg('gaji_bersih');

        return view('komponen-gaji.index', compact(
            'komponenGaji',
            'pegawaiList',
            'bulanList',
            'tahunList',
            'statusList',
            'totalGajiBersih',
            'totalPegawaiDigaji',
            'rataRataGaji'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawaiList = Pegawai::with('golongan')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $bulanList = $this->getBulanList();
        $tahunList = range(2020, date('Y') + 1);

        return view('komponen-gaji.create', compact('pegawaiList', 'bulanList', 'tahunList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KomponenGajiRequest $request)
    {
        try {
            $data = $request->validated();
            KomponenGaji::create($data);

            return redirect()->route('komponen-gaji.index')
                ->with('success', 'Data penggajian berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KomponenGaji $komponenGaji)
    {
        $komponenGaji->load('pegawai.golongan');

        $totalTunjangan = $komponenGaji->total_tunjangan;
        $persentasePotongan = $komponenGaji->gaji_pokok > 0
            ? ($komponenGaji->total_potongan / $komponenGaji->gaji_pokok) * 100
            : 0;

        return view('komponen-gaji.show', compact('komponenGaji', 'totalTunjangan', 'persentasePotongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomponenGaji $komponenGaji)
    {
        $pegawaiList = Pegawai::with('golongan')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $bulanList = $this->getBulanList();
        $tahunList = range(2020, date('Y') + 1);

        return view('komponen-gaji.edit', compact('komponenGaji', 'pegawaiList', 'bulanList', 'tahunList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KomponenGajiRequest $request, KomponenGaji $komponenGaji)
    {
        try {
            $data = $request->validated();
            $komponenGaji->update($data);

            return redirect()->route('komponen-gaji.index')
                ->with('success', 'Data penggajian berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomponenGaji $komponenGaji)
    {
        try {
            $komponenGaji->delete();

            return redirect()->route('komponen-gaji.index')
                ->with('success', 'Data penggajian berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * API untuk mendapatkan data pegawai (untuk AJAX)
     */
    public function getPegawaiData(Pegawai $pegawai)
    {
        $pegawai->load('golongan');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pegawai->id,
                'nip' => $pegawai->nip,
                'nama' => $pegawai->nama,
                'golongan_kode' => $pegawai->golongan->kode,
                'golongan_nama' => $pegawai->golongan->nama_golongan,
                'gaji_pokok' => $pegawai->golongan->gaji_pokok,
                'tunjangan_makan' => $pegawai->golongan->tunjangan_makan,
                'tunjangan_transport' => $pegawai->golongan->tunjangan_transport,
                'departemen' => $pegawai->departemen,
                'jabatan' => $pegawai->jabatan,
            ]
        ]);
    }

    /**
     * Helper: Daftar bulan
     */
    private function getBulanList()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    }
}