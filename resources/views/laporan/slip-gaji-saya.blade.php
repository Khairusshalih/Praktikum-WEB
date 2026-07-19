@extends('layouts.app')

@section('title', 'Slip Gaji Saya')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-receipt"></i> Slip Gaji Saya</h5>
        <a href="{{ route('dashboard.karyawan') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <!-- Informasi Pegawai -->
        <div class="alert alert-info">
            <i class="fas fa-user-circle"></i> 
            <strong>{{ $pegawai->nama }}</strong> 
            (NIP: {{ $pegawai->nip }}) - 
            {{ $pegawai->departemen }} / {{ $pegawai->jabatan }}
        </div>

        <!-- Filter Form -->
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @foreach($bulanList as $key => $nama)
                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('slip-gaji-saya') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Periode</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Potongan</th>
                        <th>Gaji Bersih</th>
                        <th>Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slipGaji as $key => $item)
                    <tr>
                        <td>{{ $slipGaji->firstItem() + $key }}</td>
                        <td>{{ $bulanList[$item->bulan] }} {{ $item->tahun }}</td>
                        <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->tunjangan_makan + $item->tunjangan_transport + $item->tunjangan_lainnya, 0, ',', '.') }}</td>
                        <td class="text-danger">Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</td>
                        <td class="fw-bold text-success">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                            @elseif($item->status == 'diproses')
                            <span class="badge bg-warning">Diproses</span>
                            @else
                            <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('laporan.export-pdf', ['jenis' => 'slip-gaji', 'id' => $item->id]) }}" 
                               class="btn btn-sm btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                            Belum ada data penggajian untuk Anda
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $slipGaji->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection