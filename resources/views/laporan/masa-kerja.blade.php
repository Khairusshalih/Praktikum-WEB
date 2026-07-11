@extends('layouts.app')

@section('title', 'Masa Kerja > 5 Tahun')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-briefcase"></i> Pegawai dengan Masa Kerja &gt; 5 Tahun</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Golongan</th>
                        <th>Tanggal Masuk</th>
                        <th>Masa Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $pegawai)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $pegawai->nip }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td><span class="badge bg-info">{{ $pegawai->golongan->kode }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d-m-Y') }}</td>
                        <td>{{ $pegawai->masa_kerja_tahun }} tahun</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada pegawai dengan masa kerja &gt; 5 tahun</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
        </a>
    </div>
</div>
@endsection