@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .page-subtitle { font-family: 'Inter', sans-serif; }
    .card { border-radius: 12px; border: 1px solid #e2e8f0; font-family: 'Inter', sans-serif; }
    .card-title { font-family: 'Poppins', sans-serif; font-weight: 600; }
    .btn { font-family: 'Inter', sans-serif; font-weight: 500; }
    .laporan-card { transition: all 0.3s ease; cursor: pointer; }
    .laporan-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan Keuangan</h4>
        <p class="page-subtitle">Pilih jenis laporan yang ingin Anda lihat</p>
    </div>

    <div class="row g-4">
        <!-- Laporan Harian -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('keuangan.laporan.harian') }}" class="text-decoration-none">
                <div class="card laporan-card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-calendar-day text-white" style="font-size: 36px;"></i>
                        </div>
                        <h5 class="card-title mb-2">Laporan Harian</h5>
                        <p class="text-muted small mb-0">Monitoring transaksi per hari</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan Periode -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('keuangan.laporan.periode') }}" class="text-decoration-none">
                <div class="card laporan-card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="bi bi-calendar-range text-white" style="font-size: 36px;"></i>
                        </div>
                        <h5 class="card-title mb-2">Laporan Periode</h5>
                        <p class="text-muted small mb-0">Analisis periode tertentu</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan per Jurusan -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('keuangan.laporan.jurusan') }}" class="text-decoration-none">
                <div class="card laporan-card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="bi bi-mortarboard text-white" style="font-size: 36px;"></i>
                        </div>
                        <h5 class="card-title mb-2">Laporan per Jurusan</h5>
                        <p class="text-muted small mb-0">Revenue per jurusan</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan per Gelombang -->
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('keuangan.laporan.gelombang') }}" class="text-decoration-none">
                <div class="card laporan-card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="bi bi-graph-up-arrow text-white" style="font-size: 36px;"></i>
                        </div>
                        <h5 class="card-title mb-2">Laporan per Gelombang</h5>
                        <p class="text-muted small mb-0">Kinerja per gelombang</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card border-0 shadow-sm mt-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-2"><i class="bi bi-info-circle-fill me-2 text-primary"></i>Informasi Laporan</h5>
                    <p class="mb-0 text-muted">Semua laporan dapat diekspor ke format Excel dan PDF. Gunakan filter untuk menyesuaikan data yang ditampilkan.</p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-file-earmark-spreadsheet text-success" style="font-size: 60px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
