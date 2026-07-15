<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Penggajian - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-money-bill-wave"></i>
                Aplikasi Penggajian
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pegawai.index') }}">
                            <i class="fas fa-users"></i>
                            Pegawai
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('golongan.index') }}">
                            <i class="fas fa-layer-group"></i>
                            Golongan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('komponen-gaji.index') }}">
                            <i class="fas fa-calculator"></i>
                            Penggajian
                        </a>
                    </li>

                    <!-- Menu Laporan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="laporanDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            <i class="fas fa-chart-line"></i>
                            Laporan
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.slip-gaji') }}">
                                    <i class="fas fa-receipt"></i>
                                    Slip Gaji
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.rekap-departemen') }}">
                                    <i class="fas fa-building"></i>
                                    Rekap per Departemen
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.gaji-diatas-rata') }}">
                                    <i class="fas fa-arrow-up"></i>
                                    Gaji > Rata-rata
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.potongan-terbesar') }}">
                                    <i class="fas fa-minus-circle"></i>
                                    Potongan Terbesar
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('laporan.total-gaji-per-bulan') }}">
                                    <i class="fas fa-chart-bar"></i>
                                    Total Gaji per Bulan
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>

                <!-- Tombol Logout di Navbar -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> 
                            {{ Auth::user()->name ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted small">
                                    <i class="fas fa-envelope"></i> {{ Auth::user()->email ?? 'admin@penggajian.com' }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"
                                    onclick="return confirm('Yakin ingin logout?')">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>


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
                        <i class="fas fa-chart-simple"></i>
                        Menu Utama
                    </div>

                    <div class="list-group list-group-flush">

                        <a href="{{ route('pegawai.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-users"></i>
                            Data Pegawai
                        </a>

                        <a href="{{ route('golongan.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-layer-group"></i>
                            Data Golongan
                        </a>

                        <a href="{{ route('komponen-gaji.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calculator"></i>
                            Penggajian
                        </a>

                        <a href="{{ route('laporan.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-alt"></i>
                            Laporan
                        </a>

                         <!-- Tombol Logout di Sidebar -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="list-group-item list-group-item-action text-danger border-0" 
                                    onclick="return confirm('Yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>

                    </div>

                </div>
            </div>

            <!-- Content -->
            <div class="col-md-10">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                        </button>
                    </div>
                @endif

                @yield('content')

            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-muted py-3 mt-5">
        <div class="container">
            <span>&copy; {{ date('Y') }} Aplikasi Penggajian - Praktikum Pemrograman Web</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>