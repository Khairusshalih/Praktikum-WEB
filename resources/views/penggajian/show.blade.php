@extends('layouts.app')

@section('title', 'Slip Gaji')

@section('content')
@php
    $namaBulan = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
@endphp
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Slip Gaji</h5>
        <a href="{{ route('penggajian.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="text-center mb-4">
            <h4>SLIP GAJI PEGAWAI</h4>
            <p class="text-muted">Periode {{ $namaBulan[$penggajian->bulan] }} {{ $penggajian->tahun }}</p>
        </div>

        <table class="table table-borderless">
            <tr>
                <th width="30%">Nama Pegawai</th>
                <td>: {{ $penggajian->pegawai->nama }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>: {{ $penggajian->pegawai->nip }}</td>
            </tr>
            <tr>
                <th>Departemen / Jabatan</th>
                <td>: {{ $penggajian->pegawai->departemen }} / {{ $penggajian->pegawai->jabatan }}</td>
            </tr>
            <tr>
                <th>Golongan</th>
                <td>: {{ $penggajian->pegawai->golongan->kode }} - {{ $penggajian->pegawai->golongan->nama_golongan }}</td>
            </tr>
        </table>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">Pendapatan</div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td>Gaji Pokok</td><td class="text-end">Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }}</td></tr>
                            <tr><td>Tunjangan Makan</td><td class="text-end">Rp {{ number_format($penggajian->tunjangan_makan, 0, ',', '.') }}</td></tr>
                            <tr><td>Tunjangan Transport</td><td class="text-end">Rp {{ number_format($penggajian->tunjangan_transport, 0, ',', '.') }}</td></tr>
                            <tr><td>Tunjangan Lainnya</td><td class="text-end">Rp {{ number_format($penggajian->tunjangan_lainnya, 0, ',', '.') }}</td></tr>
                            <tr class="border-top"><th>Total Pendapatan</th><th class="text-end">Rp {{ number_format($penggajian->gaji_pokok + $penggajian->tunjangan_makan + $penggajian->tunjangan_transport + $penggajian->tunjangan_lainnya, 0, ',', '.') }}</th></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">Potongan</div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td>Potongan Absensi</td><td class="text-end">Rp {{ number_format($penggajian->potongan_absensi, 0, ',', '.') }}</td></tr>
                            <tr><td>Potongan Lainnya</td><td class="text-end">Rp {{ number_format($penggajian->potongan_lainnya, 0, ',', '.') }}</td></tr>
                            <tr class="border-top"><th>Total Potongan</th><th class="text-end">Rp {{ number_format($penggajian->total_potongan, 0, ',', '.') }}</th></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-success text-center mt-3">
            <h5 class="mb-0">GAJI BERSIH: Rp {{ number_format($penggajian->gaji_bersih, 0, ',', '.') }}</h5>
        </div>

        <div class="text-end">
            <a href="{{ route('penggajian.edit', $penggajian->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection