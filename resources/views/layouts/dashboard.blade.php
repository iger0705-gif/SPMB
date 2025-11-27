<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PPDB SMK Bakti Nusantara 666</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #8b5cf6;
            --dark: #1e293b;
            --light: #f8fafc;
            --sidebar-bg: #1e40af; /* Changed to #1E40AF */
            --sidebar-text: #f1f5f9;
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            overflow-x: hidden;
        }

        /* TOP NAVBAR - SIMPLIFIED - MODIFIED */
        .top-navbar {
            background: #1E40AF; /* Changed to #1E40AF */
            height: 70px;
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            z-index: 1020;
            display: flex;
            align-items: center;
            padding: 0 30px;
            transition: left 0.3s ease;
        }

        .page-title-nav {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: white; /* Changed to white */
            flex: 1;
        }

        /* SIDEBAR - INTEGRATED */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1030;
        }

        /* BRAND AREA */
        .sidebar-brand {
            padding: 12px 18px 8px 18px; /* Reduced padding top and bottom */
            border-right: 2px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand img {
            width: 50px; /* Increased from 38px to 50px */
            height: 50px; /* Increased from 38px to 50px */
            border-radius: 8px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* SPMB Logo Styles */
        .spmb-logo {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 1px;
            line-height: 1; /* Ensure tight line height */
        }

        .spmb-s {
            color: #FF5252; /* Bright Red */
        }

        .spmb-p {
            color: #FFD740; /* Bright Yellow */
        }

        .spmb-m {
            color: #69F0AE; /* Bright Green */
        }

        .spmb-b {
            color: #18FFFF; /* Turquoise */
        }

        .school-name {
            font-size: 11px;
            color: white;
            font-weight: 500;
            margin-top: 1px; /* Reduced from 2px to 1px */
            letter-spacing: 0.5px;
            line-height: 1.2; /* Tighter line height */
        }

        /* NAVIGATION MENU */
        .sidebar-nav {
            padding: 8px 0; /* Reduced padding */
        }

        .nav-item {
            margin-bottom: 2px;
        }

        .nav-link {
            color: var(--sidebar-text);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 13px;
            font-weight: 500;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: #ffffff;
            border-left-color: var(--primary);
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.15);
            color: #ffffff;
            border-left-color: var(--sidebar-active);
        }

        .nav-icon {
            width: 22px;
            margin-right: 14px;
            font-size: 19px;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
            transition: all 0.3s ease;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 26px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #64748b;
        }

        /* STAT CARDS */
        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .stat-trend {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .stat-trend.up {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-trend.down {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .stat-number {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 6px;
            color: var(--dark);
        }

        .stat-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .stat-primary { background: rgba(59, 130, 246, 0.1); color: var(--primary); }
        .stat-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .stat-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .stat-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); }

        /* CHARTS & TABLES */
        .chart-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }

        .chart-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 18px;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .table {
            font-size: 14px;
        }

        .table thead th {
            background: #f8fafc;
            color: var(--dark);
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .top-navbar {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 20px 15px;
            }
            
            .stat-card {
                padding: 20px;
            }
        }

        /* USER DROPDOWN IN NAVBAR - MODIFIED */
        .user-dropdown {
            border: none;
            background: none;
            cursor: pointer;
            color: white; /* Added white color */
        }

        .user-avatar-nav {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #FF5252, #FFD740, #69F0AE, #18FFFF);
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            font-weight: 700;
            font-size: 18px;
        }

        .user-info {
            text-align: left;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: white; /* Changed to white */
        }

        .user-role-badge {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.8); /* Changed to white with transparency */
        }

        /* MOBILE TOGGLE */
        .mobile-toggle {
            display: none;
        }

        @media (max-width: 992px) {
            .mobile-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- TOP NAVBAR - SIMPLIFIED - MODIFIED -->
    <nav class="top-navbar">
        <button class="btn btn-link mobile-toggle me-3" id="sidebarToggle">
            <i class="bi bi-list fs-4 text-white"></i> <!-- Changed to white -->
        </button>
        
        <div class="page-title-nav">
            Dashboard {{ Auth::check() && Auth::user()->role == 'verifikator_adm' ? 'Verifikator' : (Auth::check() ? ucfirst(str_replace('_', ' ', Auth::user()->role)) : '') }}
        </div>
        
        <div class="dropdown">
            @auth
            <button class="user-dropdown dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar-nav">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="user-info d-none d-md-block">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role-badge">{{ Auth::user()->role == 'verifikator_adm' ? 'Verifikator' : ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</div>
                </div>
            </button>
            @endauth
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- SIDEBAR - INTEGRATED -->
    <div class="sidebar" id="sidebar">
        <!-- BRAND AREA -->
        <div class="sidebar-brand">
            <img src="{{ asset('assets/images/logo baknus1.jpg') }}" alt="Logo">
            <div class="brand-text">
                <div class="spmb-logo">
                    <span class="spmb-s">S</span>
                    <span class="spmb-p">P</span>
                    <span class="spmb-m">M</span>
                    <span class="spmb-b">B</span>
                </div>
                <div class="school-name">SMK Bakti Nusantara 666</div>
            </div>
        </div>
        
        <!-- NAVIGATION MENU -->
        <nav class="sidebar-nav">
            @if(Auth::check() && Auth::user()->role == 'pendaftar')
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard Pendaftaran</span>
                </a>
                <a href="{{ route('pendaftaran.form') }}" class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text nav-icon"></i>
                    <span class="nav-text">Formulir Pendaftaran</span>
                </a>
                <a href="{{ route('dokumen.index') }}" class="nav-link {{ request()->routeIs('dokumen.*') ? 'active' : '' }}">
                    <i class="bi bi-cloud-upload nav-icon"></i>
                    <span class="nav-text">Upload Berkas</span>
                </a>
                <a href="{{ route('pembayaran.index') }}" class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card nav-icon"></i>
                    <span class="nav-text">Pembayaran</span>
                </a>
            @elseif(Auth::check() && Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="nav-item">
                    <a href="#masterSubmenu" class="nav-link {{ request()->routeIs('admin.master*') ? 'active' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.master*') ? 'true' : 'false' }}">
                        <i class="bi bi-gear nav-icon"></i>
                        <span class="nav-text">Master Data</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.master*') ? 'show' : '' }}" id="masterSubmenu">
                        <a href="{{ route('admin.master.jurusan') }}" class="nav-link ps-5 {{ request()->routeIs('admin.master.jurusan*') ? 'active' : '' }}">
                            <i class="bi bi-mortarboard nav-icon"></i>
                            <span class="nav-text">Jurusan & Kuota</span>
                        </a>
                        <a href="{{ route('admin.master.gelombang') }}" class="nav-link ps-5 {{ request()->routeIs('admin.master.gelombang*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event nav-icon"></i>
                            <span class="nav-text">Gelombang Pendaftaran</span>
                        </a>
                        <a href="{{ route('admin.master.biaya') }}" class="nav-link ps-5 {{ request()->routeIs('admin.master.biaya*') ? 'active' : '' }}">
                            <i class="bi bi-cash-coin nav-icon"></i>
                            <span class="nav-text">Biaya Pendaftaran</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.pendaftar') }}" class="nav-link {{ request()->routeIs('admin.pendaftar*') ? 'active' : '' }}">
                    <i class="bi bi-people nav-icon"></i>
                    <span class="nav-text">Data Pendaftar</span>
                </a>
                <a href="{{ route('peta.index') }}" class="nav-link {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill nav-icon"></i>
                    <span class="nav-text">Peta Sebaran</span>
                </a>
                <a href="{{ route('admin.laporan.statistik') }}" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph nav-icon"></i>
                    <span class="nav-text">Laporan & Export</span>
                </a>
            @elseif(Auth::check() && Auth::user()->role == 'verifikator_adm')
                <a href="{{ route('verifikator.dashboard') }}" class="nav-link {{ request()->routeIs('verifikator.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard Verifikasi</span>
                </a>
                <a href="{{ route('verifikator.daftar') }}" class="nav-link {{ request()->routeIs('verifikator.daftar') ? 'active' : '' }}">
                    <i class="bi bi-list-check nav-icon"></i>
                    <span class="nav-text">Daftar Pendaftar</span>
                </a>
                <a href="{{ route('admin.verifikasi.dokumen.index') }}" class="nav-link {{ request()->routeIs('admin.verifikasi.dokumen*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check nav-icon"></i>
                    <span class="nav-text">Verifikasi Berkas</span>
                </a>
                <a href="{{ route('verifikator.log') }}" class="nav-link {{ request()->routeIs('verifikator.log') ? 'active' : '' }}">
                    <i class="bi bi-journal-text nav-icon"></i>
                    <span class="nav-text">Log Verifikasi</span>
                </a>
            @elseif(Auth::check() && Auth::user()->role == 'keuangan')
                <a href="{{ route('keuangan.dashboard') }}" class="nav-link {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard Keuangan</span>
                </a>
                <a href="{{ route('keuangan.verifikasi') }}" class="nav-link {{ request()->routeIs('keuangan.verifikasi') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack nav-icon"></i>
                    <span class="nav-text">Verifikasi Pembayaran</span>
                </a>
                <a href="{{ route('keuangan.rekap') }}" class="nav-link {{ request()->routeIs('keuangan.rekap') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph nav-icon"></i>
                    <span class="nav-text">Rekap & Laporan</span>
                </a>
            @elseif(Auth::check() && Auth::user()->role == 'kepsek')
                <a href="{{ route('kepsek.dashboard') }}" class="nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard Eksekutif</span>
                </a>
                <a href="{{ route('kepsek.grafik') }}" class="nav-link {{ request()->routeIs('kepsek.grafik') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line nav-icon"></i>
                    <span class="nav-text">Grafik Pendaftaran</span>
                </a>
                <a href="{{ route('kepsek.analisis') }}" class="nav-link {{ request()->routeIs('kepsek.analisis') ? 'active' : '' }}">
                    <i class="bi bi-building nav-icon"></i>
                    <span class="nav-text">Analisis Asal Sekolah</span>
                </a>
                <a href="{{ route('peta.index') }}" class="nav-link {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill nav-icon"></i>
                    <span class="nav-text">Peta Sebaran</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Notification Toasts -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        @if(session('success'))
        <div class="toast show" role="alert">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i>
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('success') }}</div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="toast show" role="alert">
            <div class="toast-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('error') }}</div>
        </div>
        @endif
        
        @if($errors->any())
        <div class="toast show" role="alert">
            <div class="toast-header bg-warning text-white">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong class="me-auto">Peringatan</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        });

        // Auto-collapse sidebar on mobile
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.remove('show');
        }
        
        // Auto hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    var bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>