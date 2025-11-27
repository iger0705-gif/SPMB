<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PPDB SMK Bakti Nusantara 666</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        .auth-container {
            display: flex;
            min-height: 100vh;
        }

        /* LAYER 1: KOLOM KIRI - BACKGROUND */
        .left-layer {
            width: 40%;
            min-height: 100vh;
            background: #1E40AF;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            position: fixed;
            left: 0;
            top: 0;
            overflow: hidden;
        }

        .left-layer::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(236, 72, 153, 0.15);
            border-radius: 50%;
            filter: blur(80px);
        }

        .left-layer::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: rgba(59, 130, 246, 0.15);
            border-radius: 50%;
            filter: blur(60px);
        }

        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 35px;
            position: relative;
            z-index: 1;
        }

        .brand img {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            margin-right: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .brand-text h1 {
            font-size: 21px;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, #ffffff 0%, #fce7f3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text p {
            font-size: 12px;
            color: #e9d5ff;
            margin: 0;
            font-weight: 500;
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .left-content h2 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 30px;
            line-height: 1.3;
            background: linear-gradient(135deg, #ffffff 0%, #f3e8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            font-size: 14px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(5px);
        }

        .feature-item i {
            font-size: 22px;
            color: #10b981;
            margin-right: 14px;
            filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.5));
        }

        /* LAYER 2: KOLOM KANAN - CARD CONTAINER */
        .right-layer {
            position: fixed;
            right: 0;
            top: 0;
            width: 60%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        /* LAYER 3: REGISTER CARD */
        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 25px 30px;
            width: 90%;
            max-width: 440px;
            margin: auto;
        }

        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .card-header p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }



        .form-group {
            margin-bottom: 12px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #1e293b;
        }

        .form-control {
            width: 100%;
            padding: 11px 12px 11px 38px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            transition: all 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e293b;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }



        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
            margin-bottom: 12px;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        }

        .login-link {
            text-align: center;
            font-size: 12px;
            color: #64748b;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .login-link a {
            color: #1e293b;
            text-decoration: none;
            font-weight: 700;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
        
        .back-to-home {
            text-align: center;
            margin-top: 15px;
        }
        
        .btn-back {
            color: #64748b;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-back:hover {
            color: #1e293b;
            background: #f3e8ff;
        }

        .alert {
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .alert-danger {
            background: #fef2f2;
            border: 2px solid #fecaca;
            color: #dc2626;
        }

        .alert i {
            margin-right: 6px;
            font-size: 14px;
        }

        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
            }

            .left-layer {
                width: 100%;
                height: auto;
                position: relative;
                padding: 30px 20px;
                min-height: auto;
            }

            .left-content h2 {
                font-size: 22px;
            }

            .right-layer {
                width: 100%;
                position: relative;
                padding: 30px 20px;
                min-height: auto;
            }

            .register-card {
                max-width: 100%;
            }

            .role-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- LAYER 1: KOLOM KIRI - BACKGROUND -->
        <div class="left-layer">
            <div class="brand">
                <img src="{{ asset('assets/images/logo baknus1.jpg') }}" alt="Logo">
                <div class="brand-text">
                    <h1>SMK Bakti Nusantara 666</h1>
                    <p>Sistem PPDB Online</p>
                </div>
            </div>

            <div class="left-content">
                <h2>Mulai Perjalanan Anda Bersama Kami</h2>
                
                <ul class="feature-list">
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Pendaftaran cepat dan mudah</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Proses verifikasi online</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Tracking status real-time</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Data aman dan terenkripsi</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- LAYER 2: KOLOM KANAN - CARD CONTAINER -->
        <div class="right-layer">
            <!-- LAYER 3: REGISTER CARD -->
            <div class="register-card">
                <div class="card-header">
                    <h2>Buat Akun Baru</h2>
                    <p>Daftar untuk mengakses sistem PPDB</p>
                </div>



                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" value="pendaftar">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" class="form-control" placeholder="Password (minimal 8 karakter)" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-register">
                        <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                    </button>
                </form>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
                
                <div class="back-to-home">
                    <a href="{{ route('home') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
