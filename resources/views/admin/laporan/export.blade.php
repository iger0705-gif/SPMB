@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .export-card { 
        background: white; 
        border-radius: 12px; 
        padding: 30px; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }
    .export-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .export-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin: 0 auto 20px;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Export Data Pendaftar</h4>
        <p class="page-subtitle">Download data pendaftar dalam berbagai format</p>
    </div>

    <!-- Filter Export -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-funnel me-2"></i>Filter Data Export</h6>
        </div>
        <div class="card-body">
            <form id="exportForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jurusan</label>
                        <select name="jurusan_id" class="form-select">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Gelombang</label>
                        <select name="gelombang_id" class="form-select">
                            <option value="">Semua Gelombang</option>
                            @foreach($gelombang as $g)
                            <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="SUBMIT">Menunggu Verifikasi</option>
                            <option value="ADM_PASS">Lulus Administrasi</option>
                            <option value="ADM_REJECT">Ditolak</option>
                            <option value="PAID">Terbayar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Periode</label>
                        <select name="periode" class="form-select">
                            <option value="all">Semua Periode</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Options -->
    <div class="row g-4 justify-content-center">
        <div class="col-md-5">
            <div class="export-card text-center">
                <div class="export-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                    <i class="bi bi-file-earmark-excel"></i>
                </div>
                <h5 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Export ke Excel</h5>
                <p class="text-muted mb-3">Download data lengkap dalam format Excel (.csv) untuk analisis lebih lanjut</p>
                <button class="btn btn-success btn-lg w-100" onclick="exportData('excel')">
                    <i class="bi bi-download me-2"></i>Download Excel
                </button>
                <small class="text-muted d-block mt-2">Format: .csv | Compatible with Excel</small>
            </div>
        </div>

        <div class="col-md-5">
            <div class="export-card text-center">
                <div class="export-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white;">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <h5 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Export ke PDF</h5>
                <p class="text-muted mb-3">Download laporan formal dalam format PDF dengan kop sekolah</p>
                <button class="btn btn-danger btn-lg w-100" onclick="exportData('pdf')">
                    <i class="bi bi-download me-2"></i>Download PDF
                </button>
                <small class="text-muted d-block mt-2">Format: .pdf | Print Ready</small>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card border-0 shadow-sm mt-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-2"><i class="bi bi-info-circle me-2"></i>Informasi Export</h5>
            <ul class="mb-0" style="line-height: 2;">
                <li><strong>Excel:</strong> File CSV yang berisi data lengkap pendaftar (No Pendaftaran, Nama, Email, Jurusan, Gelombang, Status, Asal Sekolah, Tanggal)</li>
                <li><strong>PDF:</strong> Format laporan formal dengan header, footer, dan kop sekolah dalam bentuk tabel</li>
                <li><strong>Filter:</strong> Gunakan filter di atas untuk menyaring data sebelum export</li>
            </ul>
        </div>
    </div>
</div>

<script>
function exportData(format) {
    const form = document.getElementById('exportForm');
    const formData = new FormData(form);
    formData.append('format', format);
    
    const params = new URLSearchParams(formData);
    window.location.href = '{{ route("admin.laporan.export.proses") }}?' + params.toString();
}
</script>
@endsection
