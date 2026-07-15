@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Penggajian</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('komponen-gaji.store') }}" method="POST" id="formPenggajian">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pilih Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select @error('pegawai_id') is-invalid @enderror"
                            id="pegawai_id" name="pegawai_id" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawaiList as $pegawai)
                            <option value="{{ $pegawai->id }}"
                                data-gaji-pokok="{{ $pegawai->golongan->gaji_pokok }}"
                                data-tunjangan-makan="{{ $pegawai->golongan->tunjangan_makan }}"
                                data-tunjangan-transport="{{ $pegawai->golongan->tunjangan_transport }}"
                                data-golongan="{{ $pegawai->golongan->kode }}"
                                data-departemen="{{ $pegawai->departemen }}"
                                data-jabatan="{{ $pegawai->jabatan }}"
                                {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                {{ $pegawai->nama }} ({{ $pegawai->nip }}) - Gol. {{ $pegawai->golongan->kode }}
                            </option>
                            @endforeach
                        </select>
                        @error('pegawai_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                        <select class="form-select @error('bulan') is-invalid @enderror"
                            id="bulan" name="bulan" required>
                            <option value="">Pilih Bulan</option>
                            @foreach($bulanList as $key => $nama)
                            <option value="{{ $key }}" {{ old('bulan') == $key ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <select class="form-select @error('tahun') is-invalid @enderror"
                            id="tahun" name="tahun" required>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ old('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                        @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Pegawai -->
            <div class="alert alert-info" id="infoPegawai" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <small>NIP</small><br>
                        <strong id="info_nip">-</strong>
                    </div>
                    <div class="col-md-4">
                        <small>Departemen</small><br>
                        <strong id="info_departemen">-</strong>
                    </div>
                    <div class="col-md-4">
                        <small>Jabatan</small><br>
                        <strong id="info_jabatan">-</strong>
                    </div>
                </div>
            </div>

            <hr>
            <h6 class="mb-3"><i class="fas fa-chart-line"></i> Komponen Gaji</h6>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror"
                                id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}"
                                readonly style="background-color: #e9ecef;">
                        </div>
                        @error('gaji_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_makan" class="form-label">Tunjangan Makan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control"
                                id="tunjangan_makan" name="tunjangan_makan"
                                readonly style="background-color: #e9ece