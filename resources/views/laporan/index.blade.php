@extends('layouts.app')

@section('title', 'Laporan Penggajian')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Daftar Laporan Penggajian</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @php
                $laporan = [
                    ['route' => 'laporan.slip-gaji', 'icon' => 'fa-file-invoice-dollar', 'title' => 'Slip Gaji', 'desc' => 'Slip gaji seluruh pegawai per periode'],
                    ['route' => 'laporan.rekap-departemen', 'icon' => 'fa-building', 'title' => 'Rekap per Departemen', 'desc' => 'Total & rata-rata gaji per departemen'],
                    ['route' => 'laporan.gaji-diatas-rata', 'icon' => 'fa-arrow-trend-up', 'title' => 'Gaji di Atas Rata-rata', 'desc' => 'Pegawai dengan gaji melebihi rata-rata'],
                    ['route' => 'laporan.potongan-terbesar', 'icon' => 'fa-arrow-trend-down', 'title' => 'Potongan Terbesar', 'desc' => 'Top 10 pegawai dengan potongan terbesar'],
                    ['route' => 'laporan.total-per-bulan', 'icon' => 'fa-calendar', 'title' => 'Total Gaji per Bulan', 'desc' => 'Tren total gaji sepanjang tahun'],
                    ['route' => 'laporan.masa-kerja', 'icon' => 'fa-briefcase', 'title' => 'Masa Kerja > 5 Tahun', 'desc' => 'Daftar pegawai senior'],
                    ['route' => 'laporan.urutan-gaji', 'icon' => 'fa-sort-amount-down', 'title' => 'Urutan Gaji Bersih', 'desc' => 'Ranking gaji bersih tertinggi'],
                    ['route' => 'laporan.pegawai-per-golongan', 'icon' => 'fa-layer-group', 'title' => 'Pegawai per Golongan', 'desc' => 'Distribusi pegawai tiap golongan'],
                    ['route' => 'laporan.rekap-tunjangan', 'icon' => 'fa-hand-holding-dollar', 'title' => 'Rekap Tunjangan', 'desc' => 'Total tunjangan makan, transport, lainnya'],
                    ['route' => 'laporan.perbandingan-gaji-potongan', 'icon' => 'fa-scale-balanced', 'title' => 'Gaji Pokok vs Potongan', 'desc' => 'Perbandingan per departemen'],
                ];
            @endphp
            @foreach($laporan as $item)
            <div class="col-md-4">
                <a href="{{ route($item['route']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas {{ $item['icon'] }} fa-2x text-primary mb-2"></i>
                            <h6 class="card-title">{{ $item['title'] }}</h6>
                            <p class="card-text text-muted small">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection