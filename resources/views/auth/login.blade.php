@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="h-full flex items-center justify-center py-6 px-4">
    <div class="w-full max-w-sm rounded-3xl border border-slate-200 bg-white shadow-xl p-8">
        <div class="mb-8 text-center">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-primary-500 text-white text-xl shadow-lg shadow-primary-500/20">
                <i class="fas fa-lock"></i>
            </span>
            <h1 class="mt-6 text-3xl font-semibold text-slate-900">Masuk ke Sistem</h1>
            <p class="mt-3 text-sm text-slate-500">Masukkan email dan password Anda untuk melanjutkan.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-4">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="email@example.com" />
                </label>
                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Password</span>
                    <input type="password" name="password" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100" placeholder="Masukkan password" />
                </label>
                @error('password')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-sm text-slate-500">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary-600 shadow-sm focus:ring-primary-500" />
                    Ingat saya
                </label>
                <span class="text-xs text-slate-400">Hubungi admin untuk akses baru</span>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">Masuk</button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-500">
            Dengan masuk, Anda setuju dengan kebijakan penggunaan sistem.
        </p>
    </div>
</div>
@endsection
