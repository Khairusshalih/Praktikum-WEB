@extends('layouts.app')
@section('title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Pegawai Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Pegawai</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ \App\Models\Pegawai::count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium flex items-center"><i class="fas fa-arrow-up mr-1 text-xs"></i> 12%</span>
            <span class="text-slate-500 ml-2">dari bulan lalu</span>
        </div>
    </div>

    <!-- Total Golongan Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Golongan</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ \App\Models\Golongan::count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fas fa-layer-group text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-slate-500">Struktur aktif saat ini</span>
        </div>
    </div>

    <!-- Pegawai Aktif Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Pegawai Aktif</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ \App\Models\Pegawai::where('status', 'aktif')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                <i class="fas fa-user-check text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-slate-500">
            <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></div>
            <span>Berstatus Aktif Bekerja</span>
        </div>
    </div>
</div>

<!-- Extra Dashboard Area -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h4 class="text-base font-semibold text-slate-800 mb-4">Aktivitas Terbaru</h4>
        <div class="flex flex-col items-center justify-center py-12 text-slate-400">
            <i class="fas fa-chart-line text-4xl mb-3 text-slate-200"></i>
            <p class="text-sm">Belum ada data grafik untuk ditampilkan.</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h4 class="text-base font-semibold text-slate-800 mb-4">Pengumuman</h4>
        <div class="space-y-4">
            <div class="p-4 rounded-lg bg-blue-50 border border-blue-100 flex gap-4">
                <div class="mt-0.5 text-blue-600">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <h5 class="text-slate-800 font-medium text-sm">Pembaruan Sistem</h5>
                    <p class="text-sm text-slate-600 mt-1">Antarmuka telah diperbarui dengan skema warna yang lebih profesional dan bersih.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
