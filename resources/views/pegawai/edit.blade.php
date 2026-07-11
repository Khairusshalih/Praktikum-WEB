@extends('layouts.app')
@section('title', isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai Baru')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pegawai.index') }}" class="w-9 h-9 rounded-full bg-white hover:bg-slate-50 flex items-center justify-center text-slate-500 transition-colors border border-slate-200 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">{{ isset($pegawai) ? 'Edit Data Pegawai' : 'Tambah Pegawai Baru' }}</h2>
            <p class="text-sm text-slate-500 mt-1">Lengkapi data profil pegawai untuk sistem penggajian.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <form action="{{ isset($pegawai) ? route('pegawai.update', $pegawai->id) : route('pegawai.store') }}" method="POST" class="p-8">
            @csrf
            @if(isset($pegawai))
                @method('PUT')
            @endif

            <div class="mb-8 pb-6 border-b border-slate-100">
                <h3 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                    <div class="w-7 h-7 rounded bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-id-card text-sm"></i>
                    </div>
                    Informasi Dasar
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIP -->
                    <div>
                        <label for="nip" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Induk Pegawai (NIP) <span class="text-red-500">*</span></label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}" 
                            class="block w-full px-4 py-2 bg-white border {{ $errors->has('nip') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm" 
                            placeholder="Contoh: PEG2024001">
                        @error('nip')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $pegawai->nama ?? '') }}" 
                            class="block w-full px-4 py-2 bg-white border {{ $errors->has('nama') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm" 
                            placeholder="Contoh: Budi Santoso">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email Aktif <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $pegawai->email ?? '') }}" 
                            class="block w-full px-4 py-2 bg-white border {{ $errors->has('email') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm" 
                            placeholder="budi@perusahaan.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pegawai->no_telepon ?? '') }}" 
                            class="block w-full px-4 py-2 bg-white border {{ $errors->has('no_telepon') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm" 
                            placeholder="081234567890">
                        @error('no_telepon')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mt-6">
                    <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="2" 
                        class="block w-full px-4 py-2 bg-white border {{ $errors->has('alamat') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm" 
                        placeholder="Jl. Contoh No. 123, Jakarta">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <h3 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                    <div class="w-7 h-7 rounded bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-briefcase text-sm"></i>
                    </div>
                    Jabatan & Penempatan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Departemen -->
                    <div>
                        <label for="departemen" class="block text-sm font-medium text-slate-700 mb-1.5">Departemen <span class="text-red-500">*</span></label>
                        <select id="departemen" name="departemen" class="block w-full px-4 py-2 bg-white border {{ $errors->has('departemen') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 transition-shadow sm:text-sm">
                            <option value="">Pilih Departemen</option>
                            @php $departements = ['IT', 'HRD', 'Keuangan', 'Marketing', 'Operasional', 'Sales', 'Research & Development']; @endphp
                            @foreach($departements as $dept)
                                <option value="{{ $dept }}" {{ old('departemen', $pegawai->departemen ?? '') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        @error('departemen')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-slate-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan ?? '') }}" 
                            class="block w-full px-4 py-2 bg-white border {{ $errors->has('jabatan') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow sm:text-sm" 
                            placeholder="Contoh: Senior Developer">
                        @error('jabatan')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Masuk <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pegawai->tanggal_masuk ?? '') }}" 
                            class="block w-full px-4 py-2 bg-white border {{ $errors->has('tanggal_masuk') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 transition-shadow sm:text-sm">
                        @error('tanggal_masuk')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Golongan -->
                    <div>
                        <label for="golongan_id" class="block text-sm font-medium text-slate-700 mb-1.5">Golongan / Grade <span class="text-red-500">*</span></label>
                        <select id="golongan_id" name="golongan_id" class="block w-full px-4 py-2 bg-white border {{ $errors->has('golongan_id') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 transition-shadow sm:text-sm">
                            <option value="">Pilih Golongan</option>
                            @foreach($golongan as $g)
                                <option value="{{ $g->id }}" {{ old('golongan_id', $pegawai->golongan_id ?? '') == $g->id ? 'selected' : '' }}>
                                    {{ $g->kode }} - {{ $g->nama_golongan }}
                                </option>
                            @endforeach
                        </select>
                        @error('golongan_id')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Status Karyawan <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="block w-full px-4 py-2 bg-white border {{ $errors->has('status') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-slate-300 focus:ring-primary-500 focus:border-primary-500' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 transition-shadow sm:text-sm">
                            <option value="aktif" {{ old('status', $pegawai->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif Bekerja</option>
                            <option value="nonaktif" {{ old('status', $pegawai->status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif / Resign</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 mt-8 border-t border-slate-100">
                <a href="{{ route('pegawai.index') }}" class="px-5 py-2 rounded-lg font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors text-sm">
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
