@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-user-circle"></i> Detail Pegawai</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">NIP</th>
                        <td><strong>{{ $pegawai->nip }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $pegawai->nama }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pegawai->email }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>{{ $pegawai->no_telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $pegawai->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Tanggal Masuk</th>
                        <td>{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Masa Kerja</th>
                        <td>
                            @php
                            $masaKerja = \Carbon\Carbon::parse($pegawai->tanggal_masuk)->diff(\Carbon\Carbon::now());
                            @endphp
                            {{ $masaKerja->y }} tahun, {{ $masaKerja->m }} bulan
                        </td>
                    </tr>
                    <tr>
                        <th>Departemen</th>
                        <td>{{ $pegawai->departemen }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>{{ $pegawai->jabatan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($pegawai->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Golongan -->
        <div class="alert alert-light mt-3">
            <h6><i class="fas fa-chart-line"></i> Detail Gaji berdasarkan Golongan</h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <small>Golongan</small><br>
                    <strong><span class="badge bg-info">{{ $pegawai->golongan->kode }}</span></strong>
                </div>
                <div class="col-md-3">
                    <small>Nama Golongan</small><br>
                    <strong>{{ $pegawai->golongan->nama_golongan }}</strong>
                </div>
                <div class="col-md-3">
                    <small>Gaji Pokok</small><br>
                    <strong>Rp {{ number_format($pegawai->golongan->gaji_pokok, 0, ',', '.') }}</strong>
                </div>
                <div class="col-md-3">
                    <small>Total Tunjangan</small><br>
                    <strong>Rp {{ number_format($pegawai->golongan->tunjangan_makan + $pegawai->golongan->tunjangan_transport, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div>
                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Yakin ingin menghapus pegawai {{ $pegawai->nama }}?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection