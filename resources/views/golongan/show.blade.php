@extends('layouts.app')
@section('title', 'Detail Golongan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('golongan.index') }}" class="w-9 h-9 rounded-full bg-white hover:bg-slate-50 flex items-center justify-center text-slate-500 transition-colors border border-slate-200 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Detail Golongan: {{ $golongan->kode }}</h2>
            <p class="text-sm text-slate-500 mt-1">Rincian standar penggajian untuk golongan ini.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm relative">
        <!-- Decorative bg strip -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

        <div class="p-8 mt-2 relative z-10">
            <div class="flex flex-col sm:flex-row items-start justify-between mb-8 pb-8 border-b border-slate-100 gap-4">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl shadow-sm">
                        {{ $golongan->kode }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $golongan->nama_golongan }}</h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="px-2.5 py-1 rounded bg-slate-50 border border-slate-200 text-xs font-medium text-slate-600">
                                <i class="fas fa-users mr-1.5 text-blue-500"></i> {{ $golongan->pegawai()->count() }} Pegawai Aktif
                            </span>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('golongan.edit', $golongan->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-medium transition-colors shadow-sm">
                    <i class="fas fa-edit text-blue-600"></i> Edit Data
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="p-5 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Gaji Pokok</p>
                        <p class="text-3xl font-bold text-slate-800 tracking-tight">Rp {{ number_format($golongan->gaji_pokok, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                            <p class="text-xs font-medium text-slate-500 mb-1">Tunj. Makan</p>
                            <p class="text-lg font-bold text-slate-700">Rp {{ number_format($golongan->tunjangan_makan, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                            <p class="text-xs font-medium text-slate-500 mb-1">Tunj. Transport</p>
                            <p class="text-lg font-bold text-slate-700">Rp {{ number_format($golongan->tunjangan_transport, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-semibold text-slate-800 uppercase tracking-wider mb-2 pb-2 border-b border-slate-100">Keterangan</p>
                        @if($golongan->keterangan)
                            <div class="text-slate-600 text-sm leading-relaxed p-4 bg-slate-50 rounded-lg border border-slate-100">
                                {{ $golongan->keterangan }}
                            </div>
                        @else
                            <div class="p-4 rounded-lg border border-dashed border-slate-200 text-slate-400 text-sm flex items-center gap-2 bg-slate-50">
                                <i class="fas fa-info-circle"></i> Tidak ada keterangan tambahan.
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-xs font-semibold text-slate-800 uppercase tracking-wider mb-2 pb-2 border-b border-slate-100">Metadata</p>
                        <div class="flex items-center gap-4 text-xs text-slate-500 bg-white p-3 rounded-lg border border-slate-200">
                            <div>
                                <i class="fas fa-calendar-plus mr-1 text-slate-400"></i> Dibuat: {{ $golongan->created_at->format('d M Y') }}
                            </div>
                            <div>
                                <i class="fas fa-calendar-check mr-1 text-slate-400"></i> Diupdate: {{ $golongan->updated_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
