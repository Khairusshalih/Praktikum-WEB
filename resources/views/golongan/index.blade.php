@extends('layouts.app')
@section('title', 'Data Golongan')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Golongan</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola data tingkat golongan dan standar gaji dasar pegawai.</p>
    </div>
    <a href="{{ route('golongan.create') }}" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm text-sm">
        <i class="fas fa-plus"></i>
        <span>Tambah Golongan</span>
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Golongan</th>
                    <th class="px-6 py-4">Gaji Pokok</th>
                    <th class="px-6 py-4">Tunjangan Makan</th>
                    <th class="px-6 py-4">Tunjangan Transport</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($golongan as $key => $item)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 text-slate-500">
                            {{ $golongan->firstItem() + $key }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $item->kode }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $item->nama_golongan }}
                            <div class="text-xs text-slate-500 font-normal mt-0.5">{{ $item->pegawai()->count() ?? 0 }} Pegawai terkait</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            Rp {{ number_format($item->tunjangan_makan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            Rp {{ number_format($item->tunjangan_transport, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('golongan.show', $item->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center transition-colors" title="Detail">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('golongan.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center transition-colors" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('golongan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus golongan ini?');">
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
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 mb-3">
                                <i class="fas fa-layer-group text-slate-400"></i>
                            </div>
                            <h3 class="text-sm font-medium text-slate-800 mb-1">Belum ada data</h3>
                            <p class="text-slate-500 text-sm">Silakan tambahkan data golongan baru terlebih dahulu.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($golongan->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        {{ $golongan->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection
