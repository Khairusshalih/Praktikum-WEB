<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Penggajian - @yield('title', 'Dashboard')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ auth()->user() && auth()->user()->isAdmin() ? route('dashboard.admin') : route('dashboard.karyawan') }}">
                <i class="fas fa-money-bill-wave"></i> Aplikasi Penggajian
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- Menu Admin -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" 
                                   href="{{ route('dashboard.admin') }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-database"></i> Master Data
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pegawai.index') }}">
                                        <i class="fas fa-users"></i> Pegawai</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('golongan.index') }}">
                                        <i class="fas fa-layer-group"></i> Golongan</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('komponen-gaji.index') }}">
                                        <i class="fas fa-calculator"></i> Penggajian</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" 
                                   href="{{ route('laporan.index') }}">
                                    <i class="fas fa-chart-line"></i> Laporan
                                </a>
                            </li>
                        @else
                            <!-- Menu Karyawan -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard.karyawan') ? 'active' : '' }}" 
                                   href="{{ route('dashboard.karyawan') }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('slip-gaji-saya') }}">
                                    <i class="fas fa-receipt"></i> Slip Gaji Saya
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <!-- User Dropdown -->
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            <span class="badge bg-light text-dark ms-1">{{ Auth::user()->role }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted small">
                                    <i class="fas fa-envelope"></i> {{ Auth::user()->email }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-chart-simple"></i> Menu Utama
                    </div>
                    <div class="list-group list-group-flush">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard.admin') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                                <a href="{{ route('pegawai.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> Data Pegawai
                                </a>
                                <a href="{{ route('golongan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('golongan.*') ? 'active' : '' }}">
                                    <i class="fas fa-layer-group"></i> Data Golongan
                                </a>
                                <a href="{{ route('komponen-gaji.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('komponen-gaji.*') ? 'active' : '' }}">
                                    <i class="fas fa-calculator"></i> Transaksi Gaji
                                </a>
                                <a href="{{ route('laporan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i> Laporan
                                </a>
                            @else
                                <a href="{{ route('dashboard.karyawan') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.karyawan') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                                <a href="{{ route('slip-gaji-saya') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-receipt"></i> Slip Gaji Saya
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="list-group-item list-group-item-action text-danger border-0" 
                                        onclick="return confirm('Yakin ingin logout?')">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="col-md-10">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-muted py-3 mt-5">
        <div class="container">
            <span>&copy; {{ date('Y') }} Aplikasi Penggajian - Praktikum Pemrograman Web - By KHAIRUSSHALIH</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>