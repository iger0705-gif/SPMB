<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SMK Bakti Nusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .smk-header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="smk-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-1">SMK BAKTI NUSANTARA 666</h1>
                    <p class="mb-0">Penerimaan Peserta Didik Baru Online</p>
                </div>
                <div class="col-md-4 text-end">
                    <nav>
                        <a href="{{ url('/') }}" class="text-light text-decoration-none me-3">Beranda</a>
                        <a href="{{ route('tracking.index') }}" class="text-light text-decoration-none me-3">Tracking</a>
                        @if (Route::has('login'))
                            @auth
                                <!-- CEK ADMIN -->
                                @if(Auth::user()->admin == true || Auth::user()->admin == 1)
                                    <a href="{{ route('admin.dashboard') }}" class="text-light text-decoration-none me-3">Admin</a>
                                    <a href="{{ route('admin.verifikasi.dashboard') }}" class="text-light text-decoration-none me-3">Verifikasi</a>
                                @else
                                    <a href="{{ route('dokumen.index') }}" class="text-light text-decoration-none me-3">Dokumen</a>
                                @endif
                                <a href="{{ url('/dashboard') }}" class="text-light text-decoration-none me-3">Dashboard</a>
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                   class="text-light text-decoration-none">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-light text-decoration-none me-3">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-light text-decoration-none">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 SMK Bakti Nusantara 666. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>