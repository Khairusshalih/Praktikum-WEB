@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    .stat-card {
        border-radius: 16px;
        border: none;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .stat-card .stat-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 2.5rem;
        opacity: 0.15;
    }
    .stat-card .stat-number {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .stat-card .stat-label {
        font-size: 0.85rem;
        opacity: 0.85;
        margin-bottom: 0;
    }
    .stat-card .stat-change {
        font-size: 0.8rem;
        background: rgba(255,255,255,0.2);
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 5px;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .bg-gradient-dark {
        background: linear-gradient(135deg, #434343 0%, #000000 100%);
    }
    .top-card {
        border-radius: 16px;
        border: none;
        transition: all 0.3s ease;
    }
    .top-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .top-card .rank-badge {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        background: #e9ecef;
        color: #6c757d;
    }
    .top-card .rank-badge.gold {
        background: linear-gradient(135deg, #ffd700, #f0a500);
        color: white;
    }
    .top-card .rank-badge.silver {
        background: linear-gradient(135deg, #c0c0c0, #a8a8a8);
        color: white;
    }
    .top-card .rank-badge.bronze {
        background: linear-gradient(135deg, #cd7f32, #b87333);
        color: white;
    }
    .quick-action-btn {
        border-radius: 12px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        text-align: center;
        border: 2px solid #e9ecef;
        background: white;
        text-decoration: none;
        color: #333;
    }
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: transparent;
        text-decoration: none;
    }
    .quick-action-btn i {
        font-size: 1.8rem;
        display: block;
        margin-bottom: 8px;
    }
    .quick-action-btn .label {
        font-size: 0.85rem;
        font-weight: 600;
    }
    .quick-action-btn.blue:hover { background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-color: transparent; }
    .quick-action-btn.green:hover { background: linear-gradient(135deg, #11998e, #38ef7d); color: white; border-color: transparent; }
    .quick-action-btn.orange:hover { background: linear-gradient(135deg, #f093fb, #f5576c); color: white; border-color: transparent; }
    .quick-action-btn.purple:hover { background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; border-color: transparent; }

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
</style>

<!-- Welcome Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="welcome-text">
            👋 Selamat Datang, <span style="color: #667eea;">{{ Auth::user()->name }}</span>
            <small>| Administrator</small>
        </div>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">
            Kelola dan pantau seluruh data penggajian dengan mudah
        </p>
    </div>
    <div class="date-badge">
        <i class="fas fa-calendar-alt"></i>
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card card text-white bg-gradient-primary">
            <div class="card-body">
                <i class="fas fa-users stat-icon"></i>
                <p class="stat-label">Total Pegawai</p>
                <h2 class="stat-number">{{ $totalPegawai ?? 0 }}</h2>
                <span class="stat-change">
                    <i class="fas fa-arrow-up"></i> 100% data
                </span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card card text-white bg-gradient-success">
            <div class="card-body">
                <i class="fas fa-user-check stat-icon"></i>
                <p class="stat-label">Pegawai Aktif</p>
                <h2 class="stat-number">{{ $pegawaiAktif ?? 0 }}</h2>
                <span class="stat-change">
                    <i class="fas fa-check-circle"></i> {{ $pegawaiAktif ?? 0 > 0 ? round(($pegawaiAktif / ($totalPegawai ?? 1)) * 100) : 0 }}% dari total
                </span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card card text-white bg-gradient-info">
            <div class="card-body">
                <i class="fas fa-money-bill-wave stat-icon"></i>
                <p class="stat-label">Total Gaji Bulan Ini</p>
                <h4 class="stat-number" style="font-size: 1.6rem;">Rp {{ number_format($totalGajiBulanIni ?? 0, 0, ',', '.') }}</h4>
                <span class="stat-change">
                    <i class="fas fa-calendar-alt"></i> {{ date('F Y') }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card card text-white bg-gradient-warning">
            <div class="card-body">
                <i class="fas fa-layer-group stat-icon"></i>
                <p class="stat-label">Total Golongan</p>
                <h2 class="stat-number">{{ $totalGolongan ?? 0 }}</h2>
                <span class="stat-change">
                    <i class="fas fa-arrow-up"></i> Struktur aktif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access & Info -->
<div class="row g-4">
    <!-- Quick Access -->
    <div class="col-xl-8">
        <div class="card top-card shadow-sm">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-rocket text-primary me-2"></i> Quick Access</h6>
            </div>
            <div class="card-body pt-0">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('pegawai.index') }}" class="quick-action-btn blue d-block">
                            <i class="fas fa-users"></i>
                            <span class="label">Pegawai</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('golongan.index') }}" class="quick-action-btn green d-block">
                            <i class="fas fa-layer-group"></i>
                            <span class="label">Golongan</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('komponen-gaji.index') }}" class="quick-action-btn orange d-block">
                            <i class="fas fa-calculator"></i>
                            <span class="label">Penggajian</span>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('laporan.index') }}" class="quick-action-btn purple d-block">
                            <i class="fas fa-chart-line"></i>
                            <span class="label">Laporan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Sistem -->
    <div class="col-xl-4">
        <div class="card top-card shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle text-info me-2"></i> Informasi Sistem</h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-database text-primary me-2" style="width: 20px;"></i>
                    <span class="text-muted" style="font-size: 0.9rem;">
                        <strong>{{ \App\Models\Pegawai::count() }}</strong> Pegawai
                    </span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-layer-group text-success me-2" style="width: 20px;"></i>
                    <span class="text-muted" style="font-size: 0.9rem;">
                        <strong>{{ \App\Models\Golongan::count() }}</strong> Golongan
                    </span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-calculator text-warning me-2" style="width: 20px;"></i>
                    <span class="text-muted" style="font-size: 0.9rem;">
                        <strong>{{ \App\Models\KomponenGaji::count() }}</strong> Transaksi Gaji
                    </span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-users text-info me-2" style="width: 20px;"></i>
                    <span class="text-muted" style="font-size: 0.9rem;">
                        <strong>{{ \App\Models\User::count() }}</strong> User Terdaftar
                    </span>
                </div>
                <hr class="my-2">
                <div class="text-muted" style="font-size: 0.8rem;">
                    <i class="fas fa-check-circle text-success me-1"></i> 
                    Sistem berjalan dengan baik
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top 5 Gaji Tertinggi & Grafik Sederhana -->
<div class="row g-4 mt-2">
    <div class="col-xl-8">
        <div class="card top-card shadow-sm">
            <div class="card-header bg-transparent border-0 pt-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fas fa-trophy text-warning me-2"></i> Top 5 Gaji Tertinggi Bulan Ini</h6>
                <span class="badge bg-light text-muted">{{ date('F Y') }}</span>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">Rank</th>
                                <th>Nama Pegawai</th>
                                <th>Departemen</th>
                                <th class="text-end">Gaji Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($topGaji ?? []) as $key => $item)
                            <tr>
                                <td>
                                    <span class="rank-badge 
                                        @if($key == 0) gold 
                                        @elseif($key == 1) silver 
                                        @elseif($key == 2) bronze 
                                        @endif">
                                        {{ $key + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $item->pegawai->nama ?? '-' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $item->pegawai->nip ?? '-' }}</small>
                                </td>
                                <td>{{ $item->pegawai->departemen ?? '-' }}</td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($item->gaji_bersih ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle fa-2x d-block mb-2"></i>
                                    Belum ada data penggajian bulan ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cepat -->
    <div class="col-xl-4">
        <div class="card top-card shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie text-success me-2"></i> Statistik Cepat</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted" style="font-size: 0.85rem;">Pegawai Aktif</span>
                        <span class="fw-bold">{{ $pegawaiAktif ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ ($pegawaiAktif ?? 0) > 0 ? round(($pegawaiAktif / ($totalPegawai ?? 1)) * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted" style="font-size: 0.85rem;">Total Golongan</span>
                        <span class="fw-bold">{{ $totalGolongan ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted" style="font-size: 0.85rem;">Transaksi Gaji</span>
                        <span class="fw-bold">{{ \App\Models\KomponenGaji::count() }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted" style="font-size: 0.85rem;">User Terdaftar</span>
                        <span class="fw-bold">{{ \App\Models\User::count() }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                    </div>
                </div>
                <hr class="my-3">
                <div class="text-center">
                    <span class="badge bg-success px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i> Sistem Online
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Info -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card top-card shadow-sm bg-light">
            <div class="card-body text-center text-muted" style="font-size: 0.85rem;">
                <i class="fas fa-database me-2"></i>
                Total Data: 
                <strong>{{ \App\Models\Pegawai::count() }}</strong> Pegawai, 
                <strong>{{ \App\Models\Golongan::count() }}</strong> Golongan,
                <strong>{{ \App\Models\KomponenGaji::count() }}</strong> Transaksi Gaji
                <span class="mx-2">|</span>
                <i class="fas fa-clock me-1"></i>
                Terakhir diperbarui: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB
            </div>
        </div>
    </div>
</div>
@endsection