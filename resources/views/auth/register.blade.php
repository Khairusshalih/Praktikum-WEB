@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4">
    <div class="w-full max-w-sm rounded-3xl border border-slate-200 bg-white shadow-xl p-8">
        <div class="mb-8 text-center">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-primary-500 text-white text-xl shadow-lg shadow-primary-500/20">
                <i class="fas fa-user-plus"></i>
            </span>
            <h1 class="mt-6 text-3xl font-semibold text-slate-900">Buat Akun Baru</h1>
            <p class="mt-3 text-sm text-slate-500">Isi informasi di bawah untuk mendaftar.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Nama Lengkap</span>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="Nama lengkap" />
                </label>
                @error('name')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="email@example.com" />
                </label>
                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Password</span>
                    <input type="password" name="password" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="Minimal 8 karakter" />
                </label>
                @error('password')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Konfirmasi Password</span>
                    <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="Ulangi password" />
                </label>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">Daftar</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700">Masuk sekarang</a>
        </p>
    </div>
</div>
@endsection
