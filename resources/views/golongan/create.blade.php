@extends('layouts.app')
@section('title', isset($golongan) ? 'Edit Golongan' : 'Tambah Golongan Baru')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('golongan.index') }}" class="w-9 h-9 rounded-full bg-white hover:bg-slate-50 flex items-center justify-center text-slate-500 transition-colors border border-slate-200 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ isset($golongan) ? 'Edit Data Golongan' : 'Tambah Golongan Baru' }}</h2>
            <p class="text-sm text-slate-500 mt-1">Silakan lengkapi formulir di bawah ini dengan data yang valid.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <form action="{{ isset($golongan) ? route('golongan.update', $golongan->id) : route('golongan.store') }}" method="POST" class="p-8">
            @csrf
            @if(isset($golongan))
                @method('PUT')
            @endif

            <div class="mb-8 pb-6 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                    <div class="w-7 h-7 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-layer-group text-sm"></i>
                    </div>
                    Data Golongan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode" class="block text-sm font-medium text-slate-700 mb-1.5">Kode Golongan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <i class="fas fa-hashtag text-slate-400"></i>
                            </div>
                            <input type="text" id="kode" name="kode" value="{{ old('kode', $golongan->kode ?? '') }}"
                                class="block w-full pl-12 pr-4 py-2 bg-white border {{ $errors->has('kode') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm"
                                placeholder="Contoh: III-A">
                        </div>
                        @error('kode')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_golongan" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Golongan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <i class="fas fa-layer-group text-slate-400"></i>
                            </div>
                            <input type="text" id="nama_golongan" name="nama_golongan" value="{{ old('nama_golongan', $golongan->nama_golongan ?? '') }}"
                                class="block w-full pl-12 pr-4 py-2 bg-white border {{ $errors->has('nama_golongan') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm"
                                placeholder="Contoh: Penata Muda">
                        </div>
                        @error('nama_golongan')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="gaji_pokok" class="block text-sm font-medium text-slate-700 mb-1.5">Gaji Pokok <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <span class="text-slate-400 font-medium">Rp</span>
                            </div>
                            <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $golongan->gaji_pokok ?? '') }}"
                                class="block w-full pl-12 pr-4 py-2 bg-white border {{ $errors->has('gaji_pokok') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm"
                                placeholder="0">
                        </div>
                        @error('gaji_pokok')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tunjangan_makan" class="block text-sm font-medium text-slate-700 mb-1.5">Tunjangan Makan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <span class="text-slate-400 font-medium">Rp</span>
                            </div>
                            <input type="number" id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan', $golongan->tunjangan_makan ?? '') }}"
                                class="block w-full pl-12 pr-4 py-2 bg-white border {{ $errors->has('tunjangan_makan') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm"
                                placeholder="0">
                        </div>
                        @error('tunjangan_makan')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tunjangan_transport" class="block text-sm font-medium text-slate-700 mb-1.5">Tunjangan Transport</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <span class="text-slate-400 font-medium">Rp</span>
                            </div>
                            <input type="number" id="tunjangan_transport" name="tunjangan_transport" value="{{ old('tunjangan_transport', $golongan->tunjangan_transport ?? '') }}"
                                class="block w-full pl-12 pr-4 py-2 bg-white border {{ $errors->has('tunjangan_transport') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm"
                                placeholder="0">
                        </div>
                        @error('tunjangan_transport')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" rows="3"
                    class="block w-full px-4 py-3 bg-white border {{ $errors->has('keterangan') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm"
                    placeholder="Catatan tambahan mengenai golongan ini...">{{ old('keterangan', $golongan->keterangan ?? '') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 mt-8 border-t border-slate-100">
                <a href="{{ route('golongan.index') }}" class="px-5 py-2 rounded-lg font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 rounded-lg font-medium text-white bg-primary-600 hover:bg-primary-700 transition-colors shadow-sm flex items-center gap-2 text-sm">
                    <i class="fas fa-save"></i>
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
