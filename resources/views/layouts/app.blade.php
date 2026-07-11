<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Penggajian - @yield('title', 'Dashboard')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* No custom scrollbar effects */
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex antialiased bg-slate-100 text-slate-800 @guest overflow-hidden @endguest">

    <!-- Sidebar: Solid Slate 900 for professional contrast -->
    @auth
    <aside class="w-64 fixed inset-y-0 left-0 bg-slate-900 border-r border-slate-800 z-50 flex flex-col transition-all duration-300">
        <div class="flex items-center justify-start px-6 h-16 border-b border-slate-800">
            <div class="flex items-center gap-3 text-white font-bold text-lg tracking-wide">
                <i class="fas fa-wallet text-primary-500"></i>
                <span>Aplikasi<span class="text-primary-500 font-normal"> Penggajian</span></span>
            </div>
        </div>
        
        <div class="flex-1 py-6 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Main Menu</p>
            
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-chart-pie text-sm w-5 text-center"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            
            <a href="{{ route('pegawai.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('pegawai.*') ? 'bg-primary-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-users text-sm w-5 text-center"></i>
                <span class="font-medium text-sm">Data Pegawai</span>
            </a>
            
            <a href="{{ route('golongan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('golongan.*') ? 'bg-primary-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-layer-group text-sm w-5 text-center"></i>
                <span class="font-medium text-sm">Data Golongan</span>
            </a>
            
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-3">Transaksi</p>
            <a href="{{ route('transaksi.penggajian') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('transaksi.penggajian') ? 'bg-primary-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-calculator text-sm w-5 text-center"></i>
                <span class="font-medium text-sm">Penggajian</span>
            </a>
            <a href="{{ route('transaksi.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('transaksi.laporan') ? 'bg-primary-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-file-invoice text-sm w-5 text-center"></i>
                <span class="font-medium text-sm">Laporan</span>
            </a>
        </div>
        
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-slate-700 flex items-center justify-center text-white font-medium text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-white">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-slate-400">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button id="logout-button" type="submit" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-slate-800 text-white text-sm hover:bg-slate-700 transition-colors">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- Main Content -->
    <main class="flex-1 min-h-screen flex flex-col relative z-10 @auth ml-64 @endauth @guest h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 @endguest">
        @auth
        <!-- Top Navbar: Clean White -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40">
            <h1 class="text-xl font-semibold text-slate-800 tracking-tight">@yield('title', 'Dashboard')</h1>
            
            <div class="flex items-center gap-4">
                <button class="w-9 h-9 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-500 transition-colors relative">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
            </div>
        </header>
        @endauth

        <!-- Page Content -->
        <div class="flex-1 @auth p-8 @else px-4 py-10 @endauth">
            <div class="animate-fade-in">
                @yield('content')
            </div>
        </div>

        @auth
        <!-- Footer -->
        <footer class="py-4 px-8 border-t border-slate-200 bg-white text-slate-500 text-sm mt-auto flex justify-between items-center">
            <span>&copy; {{ date('Y') }} Aplikasi Penggajian.</span>
            <span>Internal Use Only</span>
        </footer>
        @endauth
    </main>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        $flashJson = json_encode([
            'success' => session('success'),
            'error' => session('error'),
            'validation' => $errors->any() ? $errors->first() : null,
        ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    @endphp
    <div id="flash-data" data-flash="{{ $flashJson }}" class="hidden"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flashElement = document.getElementById('flash-data');
            const flash = flashElement ? JSON.parse(flashElement.dataset.flash || '{}') : {};

            if (flash.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: flash.success,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
            }

            if (flash.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: flash.error,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
            }

            if (flash.validation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi',
                    text: flash.validation,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
            }

            const logoutButton = document.querySelector('#logout-button');
            if (logoutButton) {
                logoutButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Keluar dari sistem?',
                        text: 'Anda akan diminta login kembali untuk mengakses dashboard.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Logout',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.querySelector('#logout-form').submit();
                        }
                    });
                });
            }
        });
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    </style>
</body>
</html>
