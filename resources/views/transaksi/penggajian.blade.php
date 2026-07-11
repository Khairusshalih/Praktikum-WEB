@extends('layouts.app')
@section('title', 'Transaksi Penggajian')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Transaksi {{ $monthName }} {{ $currentYear }}</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ number_format($monthlyTransactions, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fas fa-receipt text-xl"></i>
            </div>
        </div>
        <p class="mt-4 text-sm text-slate-500">Jumlah transaksi penggajian yang tercatat pada tahun berjalan.</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Total Gaji Dibayarkan</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
        </div>
        <p class="mt-4 text-sm text-slate-500">Total gaji bersih yang sudah dibayarkan sepanjang tahun ini.</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Pegawai Terbayar</p>
                <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ number_format($paidEmployees, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fas fa-user-check text-xl"></i>
            </div>
        </div>
        <p class="mt-4 text-sm text-slate-500">Jumlah pegawai dengan riwayat gaji pada tahun ini.</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">Riwayat Transaksi Terbaru</h2>
            <p class="text-sm text-slate-500">Lihat detail transaksi penggajian terbaru dari pegawai.</p>
        </div>
        <span class="text-xs uppercase tracking-[0.24em] text-slate-400">{{ $transactions->total() }} entri</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead class="bg-slate-50 text-slate-600 text-sm uppercase tracking-[0.12em]">
                <tr>
                    <th class="px-6 py-4 font-medium">No</th>
                    <th class="px-6 py-4 font-medium">Nama Pegawai</th>
                    <th class="px-6 py-4 font-medium">Departemen</th>
                    <th class="px-6 py-4 font-medium">Bulan</th>
                    <th class="px-6 py-4 font-medium">Gaji Bersih</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                @forelse($transactions as $index => $transaction)
                <tr>
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-800">{{ $transaction->pegawai->nama ?? '-' }}</div>
                        <div class="text-xs text-slate-400">{{ $transaction->pegawai->jabatan ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $transaction->pegawai->departemen ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ sprintf('%02d', $transaction->bulan) }}/{{ $transaction->tahun }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($transaction->gaji_bersih, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($transaction->status) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi penggajian tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="border-t border-slate-100 bg-slate-50 p-4">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
