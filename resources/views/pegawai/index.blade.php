@extends('layouts.app')
@section('title', 'Data Pegawai')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Data Pegawai</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola data seluruh pegawai aktif maupun nonaktif.</p>
    </div>
    <a href="{{ route('pegawai.create') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm text-sm">
        <i class="fas fa-plus"></i>
        <span>Tambah Pegawai</span>
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm mb-6 p-4">
    <form action="{{ route('pegawai.index') }}" method="GET" class="flex items-center gap-3 w-full max-w-md relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-search text-slate-400"></i>
        </div>
        <input type="text" name="search" class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm" placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
        <button type="submit" class="absolute inset-y-0 right-1 top-1 bottom-1 px-4 bg-primary-600 hover:bg-primary-700 text-white rounded-md text-sm font-medium transition-colors">
            Cari
        </button>
    </form>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                    <th class="px-6 py-4">Pegawai</th>
                    <th class="px-6 py-4">Departemen & Jabatan</th>
                    <th class="px-6 py-4">Golongan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($pegawai as $item)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold shrink-0">
                                    {{ substr($item->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-slate-800">{{ $item->nama }}</div>
                                    <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                                        <span class="text-slate-400">{{ $item->nip }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $item->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-medium">{{ $item->departemen }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $item->jabatan }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->golongan)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                    {{ $item->golongan->kode }}
                                </span>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status == 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pegawai.show', $item->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center transition-colors" title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('pegawai.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center transition-colors" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pegawai {{ $item->nama }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 mb-3">
                                <i class="fas fa-users-slash text-slate-400"></i>
                            </div>
                            <h3 class="text-sm font-medium text-slate-800 mb-1">Tidak ada data pegawai</h3>
                            <p class="text-slate-500 text-sm">Pencarian tidak ditemukan atau data masih kosong.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($pegawai->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        {{ $pegawai->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
