@extends('layouts.app')
@section('title', 'Laporan Penggajian')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Ringkasan Laporan</h2>
        <p class="text-sm text-slate-500">Lihat laporan bulanan penggajian untuk membantu analisis keuangan.</p>
        <div class="mt-6 space-y-4">
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Periode</p>
                <p class="mt-1 font-semibold text-slate-800">12 bulan terakhir</p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Format</p>
                <p class="mt-1 font-semibold text-slate-800">PDF / Excel</p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Status</p>
                <p class="mt-1 font-semibold text-slate-800">Tersedia</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Tindakan Cepat</h2>
        <div class="space-y-4">
            <button class="w-full rounded-lg bg-primary-600 text-white px-4 py-3 text-sm font-medium hover:bg-primary-700 transition-colors">Unduh Laporan PDF</button>
            <button class="w-full rounded-lg border border-slate-200 bg-white text-slate-700 px-4 py-3 text-sm font-medium hover:bg-slate-50 transition-colors">Unduh Laporan Excel</button>
            <button class="w-full rounded-lg bg-slate-900 text-white px-4 py-3 text-sm font-medium hover:bg-slate-800 transition-colors">Cetak Ringkasan</button>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">Laporan Bulanan Terakhir</h2>
            <p class="text-sm text-slate-500">Total penggajian per bulan dalam 12 bulan terakhir.</p>
        </div>
        <span class="text-xs uppercase tracking-[0.24em] text-slate-400">{{ $reports->count() }} bulan</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead class="bg-slate-50 text-slate-600 text-sm uppercase tracking-[0.12em]">
                <tr>
                    <th class="px-6 py-4 font-medium">Periode</th>
                    <th class="px-6 py-4 font-medium">Jumlah Transaksi</th>
                    <th class="px-6 py-4 font-medium">Total Gaji Bersih</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                @forelse($reports as $report)
                <tr>
                    <td class="px-6 py-4">{{ sprintf('%02d', $report->bulan) }}/{{ $report->tahun }}</td>
                    <td class="px-6 py-4">{{ number_format($report->transaksi, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($report->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada data laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
