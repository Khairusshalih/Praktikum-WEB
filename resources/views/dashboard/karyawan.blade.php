@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<style>
    .profile-card {
        border-radius: 16px;
        border: none;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin: 0 auto 15px;
    }
    .profile-name {
        font-size: 1.3rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 0;
    }
    .profile-role {
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
    }
    .welcome-text {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1a1a2e;
    }
    .welcome-text small {
        font-weight: 400;
        color: #6c757d;
        font-size: 0.9rem;
    }
    .date-badge {
        background: #f8f9fa;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 0.85rem;
        color: #6c757d;
    }
    .date-badge i {
        margin-right: 8px;
        color: #667eea;
    }
    .salary-card {
        border-radius: 16px;
        border: none;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 20px;
        text-align: center;
    }
    .salary-card .amount {
        font-size: 2rem;
        font-weight: 700;
    }
    .salary-card .label {
        font-size: 0.85rem;
        opacity: 0.85;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-row .label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .info-row .value {
        font-weight: 600;
        color: #1a1a2e;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }
    .status-badge.inactive {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<!-- Welcome Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="welcome-text">
            👋 Selamat Datang, <span style="color: #667eea;">{{ Auth::user()->name }}</span>
            <small>| Karyawan</small>
        </div>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">
            Lihat informasi pribadi dan riwayat gaji Anda
        </p>
    </div>
    <div class="date-badge">
        <i class="fas fa-calendar-alt"></i>
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
    </div>
</div>

@if($pegawai ?? false)
<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-xl-5 col-lg-6">
        <div class="card profile-card shadow-sm h-100">
            <div class="card-body text-center">
                <div class="profile-avatar">
                    {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                </div>
                <h5 class="profile-name">{{ $pegawai->nama }}</h5>
                <p class="profile-role">{{ $pegawai->jabatan }} • {{ $pegawai->departemen }}</p>
                
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <span class="status-badge {{ $pegawai->status == 'aktif' ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                        {{ ucfirst($pegawai->status) }}
                    </span>
                    <span class="badge bg-info text-white px-3 py-2">
                        <i class="fas fa-layer-group me-1"></i>
                        Gol. {{ $pegawai->golongan->kode ?? '-' }}
                    </span>
                </div>

                <hr class="my-3">

                <div class="text-start">
                    <div class="info-row">
                        <span class="label"><i class="fas fa-id-card me-2 text-muted"></i> NIP</span>
                        <span class="value">{{ $pegawai->nip }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label"><i class="fas fa-envelope me-2 text-muted"></i> Email</span>
                        <span class="value">{{ $pegawai->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label"><i class="fas fa-phone me-2 text-muted"></i> Telepon</span>
                        <span class="value">{{ $pegawai->no_telepon ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label"><i class="fas fa-calendar-plus me-2 text-muted"></i> Tanggal Masuk</span>
                        <span class="value">{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d-m-Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label"><i class="fas fa-clock me-2 text-muted"></i> Masa Kerja</span>
                        <span class="value">
                            @php
                            $masaKerja = \Carbon\Carbon::parse($pegawai->tanggal_masuk)->diff(\Carbon\Carbon::now());
                            @endphp
                            {{ $masaKerja->y }} tahun, {{ $masaKerja->m }} bulan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Card -->
    <div class="col-xl-7 col-lg-6">
        <div class="row g-4">
            <!-- Gaji Terakhir -->
            <div class="col-12">
                <div class="card profile-card shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-money-bill-wave text-success me-2"></i> 
                            Gaji Terakhir
                        </h6>
                    </div>
                    <div class="card-body pt-0">
                        @if($gajiTerakhir ?? false)
                        <div class="salary-card mb-3">
                            <div class="label">Total Gaji Bersih</div>
                            <div class="amount">Rp {{ number_format($gajiTerakhir->gaji_bersih, 0, ',', '.') }}</div>
                            <div class="label mt-1">
                                Periode: {{ $gajiTerakhir->nama_bulan }} {{ $gajiTerakhir->tahun }}
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Gaji Pokok</small>
                                    <strong>Rp {{ number_format($gajiTerakhir->gaji_pokok, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Total Tunjangan</small>
                                    <strong class="text-success">Rp {{ number_format($gajiTerakhir->total_tunjangan, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Total Potongan</small>
                                    <strong class="text-danger">Rp {{ number_format($gajiTerakhir->total_potongan, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded-3 text-center border border-success border-opacity-25">
                                    <small class="text-muted d-block">Status</small>
                                    <strong class="text-success">
                                        @if($gajiTerakhir->status == 'selesai')
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                        @elseif($gajiTerakhir->status == 'diproses')
                                        <i class="fas fa-spinner me-1"></i> Diproses
                                        @else
                                        <i class="fas fa-pencil me-1"></i> Draft
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle fa-2x d-block mb-2"></i>
                            Belum ada data penggajian untuk Anda
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-12">
                <div class="card profile-card shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-rocket text-primary me-2"></i> 
                            Quick Access
                        </h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('slip-gaji-saya') }}" class="btn btn-outline-primary w-100 py-3 rounded-3">
                                    <i class="fas fa-receipt me-2"></i> Slip Gaji Saya
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('dashboard.karyawan') }}" class="btn btn-outline-secondary w-100 py-3 rounded-3">
                                    <i class="fas fa-home me-2"></i> Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning shadow-sm rounded-3">
    <i class="fas fa-exclamation-triangle me-2"></i>
    Data pegawai tidak ditemukan untuk akun ini. Silakan hubungi administrator.
</div>
@endif
@endsection