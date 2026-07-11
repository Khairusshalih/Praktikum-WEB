@extends('layouts.app')
@section('title', 'Profil Pegawai')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pegawai.index') }}" class="w-9 h-9 rounded-full bg-white hover:bg-slate-50 flex items-center justify-center text-slate-500 transition-colors border border-slate-200 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Profil Pegawai</h2>
            <p class="text-sm text-slate-500 mt-1">Informasi lengkap dan riwayat penggajian pegawai.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Profile -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm text-center pt-8 pb-6 px-6">
                <div class="w-24 h-24 rounded-full bg-indigo-50 border-4 border-white mx-auto relative flex items-center justify-center text-3xl font-bold text-indigo-600 shadow-sm mb-4">
                    {{ substr($pegawai->nama, 0, 1) }}
                    
                    @if($pegawai->status == 'aktif')
                        <div class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-green-500 border-2 border-white" title="Aktif"></div>
                    @else
                        <div class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-red-500 border-2 border-white" title="Nonaktif"></div>
                    @endif
                </div>

                <h3 class="text-lg font-bold text-slate-800">{{ $pegawai->nama }}</h3>
                <p class="text-slate-500 text-sm font-medium mb-2">{{ $pegawai->jabatan }}</p>
                <div class="inline-flex px-2.5 py-1 rounded bg-slate-50 border border-slate-200 text-xs font-mono text-slate-500 mb-6">
                    {{ $pegawai->nip }}
                </div>

                <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-6 mt-2 text-left">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Departemen</p>
                        <p class="text-sm font-medium text-slate-700">{{ $pegawai->departemen }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Golongan</p>
                        <p class="text-sm font-medium text-indigo-600">{{ $pegawai->golongan ? $pegawai->golongan->kode : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Bergabung Sejak</p>
                        <p class="text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Masa Kerja</p>
                        <p class="text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->diffInYears(now()) }} Tahun</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-sm font-medium transition-colors">
                        <i class="fas fa-edit text-slate-400"></i> Edit Profil
                    </a>
                </div>
            </div>

            <!-- Kontak Info -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h4 class="text-xs font-semibold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">Informasi Kontak</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Email</p>
                            <p class="text-sm text-slate-700 font-medium">{{ $pegawai->email }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-md bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-phone text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Telepon</p>
                            <p class="text-sm text-slate-700 font-medium">{{ $pegawai->no_telepon ?: '-' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-md bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <i class="fas fa-map-marker-alt text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Alamat Lengkap</p>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $pegawai->alamat ?: '-' }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content area (Riwayat Gaji) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Summary stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Take Home Pay</p>
                    </div>
                    @php $lastGaji = $pegawai->riwayatGaji()->latest('tanggal_gaji')->first(); @endphp
                    <h4 class="text-2xl font-bold text-slate-800 mt-1">Rp {{ $lastGaji ? number_format($lastGaji->gaji_bersih, 0, ',', '.') : '0' }}</h4>
                    <p class="text-xs text-slate-400 mt-1">Penerimaan gaji bulan terakhir</p>
                </div>
                
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Potongan</p>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mt-1">Rp {{ $lastGaji ? number_format($lastGaji->total_potongan, 0, ',', '.') : '0' }}</h4>
                    <p class="text-xs text-slate-400 mt-1">Potongan bulan terakhir</p>
                </div>
                
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-center items-center text-center">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-3">Status Gaji Terakhir</p>
                    @if($lastGaji && $lastGaji->status == 'selesai')
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                            <i class="fas fa-check-circle text-green-500"></i> Selesai Ditransfer
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-sm font-medium">
                            <i class="fas fa-clock text-amber-500"></i> Belum Diproses
                        </div>
                    @endif
                </div>
            </div>

            <!-- Table Riwayat -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 class="text-sm font-semibold text-slate-800">Riwayat Penggajian (5 Bulan Terakhir)</h3>
                    <button class="text-xs font-medium text-primary-600 hover:text-primary-700 transition-colors">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-xs uppercase tracking-wider text-slate-400 font-semibold">
                                <th class="px-6 py-4">Bulan/Tahun</th>
                                <th class="px-6 py-4">Gaji Pokok</th>
                                <th class="px-6 py-4 text-red-500">Potongan</th>
                                <th class="px-6 py-4 text-green-600">Total Bersih</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($pegawai->riwayatGaji()->latest('tahun')->latest('bulan')->take(5)->get() as $gaji)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-800">
                                            @php
                                                $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            @endphp
                                            {{ $namaBulan[$gaji->bulan - 1] }} {{ $gaji->tahun }}
                                        </div>
                                        <div class="text-xs text-slate-500 mt-0.5">Tgl: {{ \Carbon\Carbon::parse($gaji->tanggal_gaji)->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-red-600 font-medium">
                                        Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-green-600">
                                        Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($gaji->status == 'selesai')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 mb-3 text-slate-400">
                                            <i class="fas fa-file-invoice"></i>
                                        </div>
                                        <p class="text-slate-500 text-sm font-medium">Belum ada riwayat penggajian</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
