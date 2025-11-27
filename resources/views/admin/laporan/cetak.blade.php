@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .template-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .template-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .template-preview {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-printer me-2"></i>Cetak Laporan</h4>
        <p class="page-subtitle">Template laporan siap cetak dengan format formal</p>
    </div>

    <div class="row g-4">
        <!-- Laporan Harian -->
        <div class="col-md-6 col-lg-4">
            <div class="template-card" onclick="cetakLaporan('harian')">
                <div class="template-preview">
                    <i class="bi bi-calendar-day" style="font-size: 48px; color: #3b82f6;"></i>
                    <h6 class="mt-3 mb-0 fw-bold">Laporan Harian</h6>
                </div>
                <h6 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Laporan Harian</h6>
                <p class="text-muted small mb-3">Rekap pendaftaran per hari dengan detail transaksi dan statistik harian</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary">Format A4</span>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-printer me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- Laporan Mingguan -->
        <div class="col-md-6 col-lg-4">
            <div class="template-card" onclick="cetakLaporan('mingguan')">
                <div class="template-preview">
                    <i class="bi bi-calendar-week" style="font-size: 48px; color: #10b981;"></i>
                    <h6 class="mt-3 mb-0 fw-bold">Laporan Mingguan</h6>
                </div>
                <h6 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Laporan Mingguan</h6>
                <p class="text-muted small mb-3">Ringkasan pendaftaran per minggu dengan trend dan perbandingan</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-success">Format A4</span>
                    <button class="btn btn-sm btn-outline-success">
                        <i class="bi bi-printer me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- Laporan Bulanan -->
        <div class="col-md-6 col-lg-4">
            <div class="template-card" onclick="cetakLaporan('bulanan')">
                <div class="template-preview">
                    <i class="bi bi-calendar-month" style="font-size: 48px; color: #f59e0b;"></i>
                    <h6 class="mt-3 mb-0 fw-bold">Laporan Bulanan</h6>
                </div>
                <h6 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Laporan Bulanan</h6>
                <p class="text-muted small mb-3">Laporan komprehensif per bulan dengan grafik dan analisis lengkap</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-warning">Format A4</span>
                    <button class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-printer me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- Laporan Per Jurusan -->
        <div class="col-md-6 col-lg-4">
            <div class="template-card" onclick="cetakLaporan('jurusan')">
                <div class="template-preview">
                    <i class="bi bi-mortarboard" style="font-size: 48px; color: #8b5cf6;"></i>
                    <h6 class="mt-3 mb-0 fw-bold">Laporan per Jurusan</h6>
                </div>
                <h6 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Laporan per Jurusan</h6>
                <p class="text-muted small mb-3">Detail pendaftar per jurusan dengan rasio kuota dan statistik</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge" style="background: #8b5cf6;">Format A4</span>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-printer me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- Laporan Per Gelombang -->
        <div class="col-md-6 col-lg-4">
            <div class="template-card" onclick="cetakLaporan('gelombang')">
                <div class="template-preview">
                    <i class="bi bi-graph-up-arrow" style="font-size: 48px; color: #06b6d4;"></i>
                    <h6 class="mt-3 mb-0 fw-bold">Laporan per Gelombang</h6>
                </div>
                <h6 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Laporan per Gelombang</h6>
                <p class="text-muted small mb-3">Analisis kinerja per gelombang dengan target vs realisasi</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-info">Format A4</span>
                    <button class="btn btn-sm btn-outline-info">
                        <i class="bi bi-printer me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- Laporan Lengkap -->
        <div class="col-md-6 col-lg-4">
            <div class="template-card" onclick="cetakLaporan('lengkap')">
                <div class="template-preview">
                    <i class="bi bi-file-earmark-text" style="font-size: 48px; color: #ef4444;"></i>
                    <h6 class="mt-3 mb-0 fw-bold">Laporan Lengkap</h6>
                </div>
                <h6 class="fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">Laporan Lengkap</h6>
                <p class="text-muted small mb-3">Laporan komprehensif semua data dengan kop sekolah formal</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-danger">Format A4</span>
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-printer me-1"></i>Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="alert alert-info mt-4">
        <h6 class="fw-bold mb-2"><i class="bi bi-info-circle me-2"></i>Informasi Cetak Laporan</h6>
        <ul class="mb-0">
            <li>Semua template menggunakan format A4 dengan kop sekolah resmi</li>
            <li>Laporan dilengkapi dengan header (logo, nama sekolah, alamat) dan footer (tanggal, halaman)</li>
            <li>Gunakan browser print (Ctrl+P) untuk mencetak atau save as PDF</li>
            <li>Pastikan printer setting: Portrait, A4, Margins Normal</li>
        </ul>
    </div>
</div>

<!-- Modal Parameter -->
<div class="modal fade" id="modalParameter" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Parameter Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCetak" method="GET" target="_blank">
                <div class="modal-body">
                    <div id="parameterContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-printer me-2"></i>Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function cetakLaporan(jenis) {
    const form = document.getElementById('formCetak');
    const content = document.getElementById('parameterContent');
    form.action = '{{ route("admin.laporan.cetak.proses") }}';
    
    let html = '<input type="hidden" name="jenis" value="' + jenis + '">';
    
    if (jenis === 'harian') {
        html += '<div class="mb-3"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ date("Y-m-d") }}" required></div>';
    } else if (jenis === 'mingguan') {
        html += '<div class="mb-3"><label class="form-label">Tanggal Mulai</label><input type="date" name="tanggal_mulai" class="form-control" required></div>';
        html += '<div class="mb-3"><label class="form-label">Tanggal Akhir</label><input type="date" name="tanggal_akhir" class="form-control" required></div>';
    } else if (jenis === 'bulanan') {
        html += '<div class="mb-3"><label class="form-label">Bulan</label><input type="month" name="bulan" class="form-control" value="{{ date("Y-m") }}" required></div>';
    } else if (jenis === 'jurusan') {
        html += '<div class="mb-3"><label class="form-label">Pilih Jurusan</label><select name="jurusan_id" class="form-select" required>';
        @foreach($jurusan as $j)
        html += '<option value="{{ $j->id }}">{{ $j->nama }}</option>';
        @endforeach
        html += '</select></div>';
    } else if (jenis === 'gelombang') {
        html += '<div class="mb-3"><label class="form-label">Pilih Gelombang</label><select name="gelombang_id" class="form-select" required>';
        @foreach($gelombang as $g)
        html += '<option value="{{ $g->id }}">{{ $g->nama }}</option>';
        @endforeach
        html += '</select></div>';
    }
    
    content.innerHTML = html;
    new bootstrap.Modal(document.getElementById('modalParameter')).show();
}
</script>
@endsection
