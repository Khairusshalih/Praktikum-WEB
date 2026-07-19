<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aplikasi Penggajian</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 450px;
            width: 100%;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-card .logo i {
            font-size: 3rem;
            color: #667eea;
            background: #f0f0ff;
            padding: 20px;
            border-radius: 50%;
        }
        .login-card .logo h3 {
            margin-top: 15px;
            font-weight: 700;
            color: #333;
        }
        .login-card .logo p {
            color: #888;
            font-size: 0.9rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-dashboard {
            background: #28a745;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
            color: white;
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 0.85rem;
        }
        .footer-text a {
            color: #667eea;
            text-decoration: none;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-money-bill-wave"></i>
            <h3>Aplikasi Penggajian</h3>
            <p>Sistem Informasi Penggajian Karyawan</p>
        </div>

        @auth
            <div class="alert alert-success text-center">
                <i class="fas fa-check-circle"></i> Anda sudah login!
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
                    <i class="fas fa-tachometer-alt"></i> Masuk ke Dashboard
                </a>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Silakan login untuk mengakses sistem
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('login') }}" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        @endauth

        <div class="footer-text mt-4">
            <p>&copy; {{ date('Y') }} Aplikasi Penggajian - Praktikum Pemrograman Web - By KHAIRUSSHALIH</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>