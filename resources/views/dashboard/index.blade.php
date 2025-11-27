@extends('layouts.dashboard')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Siswa</h1>
    <p class="page-subtitle">Pantau perkembangan pendaftaran dan status dokumen Anda</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($pendaftar)
    @if($rejectedDocs > 0)
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>⚠️ Perhatian!</strong> Ada {{ $rejectedDocs }} dokumen yang ditolak. Silakan upload ulang dokumen yang ditolak.
            <a href="{{ route('dokumen.index') }}" class="alert-link">Upload Sekarang</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($pendaftar->status == 'ADM_PASS')
        <div class="alert alert-success alert-dismissible fade show">
            <strong>🎉 Selamat!</strong> Anda telah lulus verifikasi administrasi. Silakan lanjutkan ke tahap berikutnya.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif($pendaftar->status == 'ADM_REJECT')
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>❌ Mohon Maaf</strong> Pendaftaran Anda tidak memenuhi syarat administrasi.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@endif

<!-- Timeline Proses Pendaftaran - Horizontal -->
<div class="chart-card mb-4">
    <h5 class="chart-title"><i class="bi bi-clock-history me-2"></i>Timeline Proses Pendaftaran</h5>
    <div class="horizontal-timeline">
        <!-- Step 1: Isi Form -->
        <div class="timeline-step {{ $pendaftar ? 'completed' : 'current' }}">
            <div class="step-marker">
                <i class="bi {{ $pendaftar ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
            </div>
            <div class="step-content">
                <h6 class="step-title">1. Isi Formulir</h6>
                <p class="step-desc">Lengkapi data pribadi dan pilih jurusan</p>
                @if($pendaftar)
                    <small class="text-success"><i class="bi bi-check me-1"></i>Selesai</small>
                @else
                    <a href="{{ route('pendaftaran.form') }}" class="btn btn-primary btn-sm">Isi Form</a>
                @endif
            </div>
        </div>

        <!-- Step 2: Upload Dokumen -->
        <div class="timeline-step {{ $pendaftar && $completeness >= 100 ? 'completed' : ($pendaftar ? 'current' : 'pending') }}">
            <div class="step-marker">
                <i class="bi {{ $pendaftar && $completeness >= 100 ? 'bi-check-circle-fill' : ($pendaftar ? 'bi-circle' : 'bi-circle') }}"></i>
            </div>
            <div class="step-content">
                <h6 class="step-title">2. Upload Dokumen</h6>
                <p class="step-desc">Upload 5 dokumen yang diperlukan</p>
                @if($pendaftar)
                    @if($completeness >= 100)
                        <small class="text-success"><i class="bi bi-check me-1"></i>Selesai</small>
                    @else
                        <small class="text-warning"><i class="bi bi-clock me-1"></i>{{ number_format($completeness, 0) }}%</small>
                        <br><a href="{{ route('dokumen.index') }}" class="btn btn-primary btn-sm mt-1">Upload</a>
                    @endif
                @else
                    <small class="text-muted">Langkah 1 dulu</small>
                @endif
            </div>
        </div>

        <!-- Step 3: Verifikasi Admin -->
        <div class="timeline-step {{ $pendaftar && ($pendaftar->status == 'ADM_PASS' || $pendaftar->status == 'PAID' || $verifiedDocs >= 5) ? 'completed' : ($pendaftar && $completeness >= 100 ? 'current' : 'pending') }}">
            <div class="step-marker">
                <i class="bi {{ $pendaftar && ($pendaftar->status == 'ADM_PASS' || $pendaftar->status == 'PAID' || $verifiedDocs >= 5) ? 'bi-check-circle-fill' : ($pendaftar && $completeness >= 100 ? 'bi-circle' : 'bi-circle') }}"></i>
            </div>
            <div class="step-content">
                <h6 class="step-title">3. Verifikasi Admin</h6>
                <p class="step-desc">Admin verifikasi dokumen</p>
                @if($pendaftar)
                    @if($pendaftar->status == 'ADM_PASS' || $pendaftar->status == 'PAID' || $verifiedDocs >= 5)
                        <small class="text-success"><i class="bi bi-check me-1"></i>Berhasil</small>
                    @elseif($pendaftar->status == 'ADM_REJECT')
                        <small class="text-danger"><i class="bi bi-x me-1"></i>Ditolak</small>
                    @elseif($completeness >= 100)
                        <small class="text-warning"><i class="bi bi-clock me-1"></i>Menunggu</small>
                    @else
                        <small class="text-muted">Upload dokumen dulu</small>
                    @endif
                @else
                    <small class="text-muted">Langkah sebelumnya</small>
                @endif
            </div>
        </div>

        <!-- Step 4: Upload Bukti Pembayaran -->
        <div class="timeline-step {{ isset($pembayaran) && $pembayaran && $pembayaran->bukti_bayar ? 'completed' : ($pendaftar && ($pendaftar->status == 'ADM_PASS' || $pendaftar->status == 'PAID') ? 'current' : 'pending') }}">
            <div class="step-marker">
                <i class="bi {{ isset($pembayaran) && $pembayaran && $pembayaran->bukti_bayar ? 'bi-check-circle-fill' : 'bi-upload' }}"></i>
            </div>
            <div class="step-content">
                <h6 class="step-title">4. Upload Bukti</h6>
                <p class="step-desc">Upload bukti pembayaran</p>
                @if($pendaftar)
                    @if(isset($pembayaran) && $pembayaran && $pembayaran->bukti_bayar)
                        <small class="text-success"><i class="bi bi-check me-1"></i>Terupload</small>
                    @elseif($pendaftar->status == 'ADM_PASS' || $pendaftar->status == 'PAID')
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-success btn-sm">Upload</a>
                    @else
                        <small class="text-muted">Verifikasi dulu</small>
                    @endif
                @else
                    <small class="text-muted">Langkah sebelumnya</small>
                @endif
            </div>
        </div>

        <!-- Step 5: Verifikasi Keuangan -->
        <div class="timeline-step {{ isset($pembayaran) && $pembayaran && $pembayaran->status == 'TERBAYAR' ? 'completed' : (isset($pembayaran) && $pembayaran && $pembayaran->bukti_bayar ? 'current' : 'pending') }}">
            <div class="step-marker">
                <i class="bi {{ isset($pembayaran) && $pembayaran && $pembayaran->status == 'TERBAYAR' ? 'bi-check-circle-fill' : 'bi-cash-coin' }}"></i>
            </div>
            <div class="step-content">
                <h6 class="step-title">5. Verifikasi Keuangan</h6>
                <p class="step-desc">Admin verifikasi pembayaran</p>
                @if($pendaftar)
                    @if(isset($pembayaran) && $pembayaran && $pembayaran->status == 'TERBAYAR')
                        <small class="text-success"><i class="bi bi-check me-1"></i>Terkonfirmasi</small>
                    @elseif(isset($pembayaran) && $pembayaran && $pembayaran->status == 'DITOLAK')
                        <small class="text-danger"><i class="bi bi-x me-1"></i>Ditolak</small>
                    @elseif(isset($pembayaran) && $pembayaran && $pembayaran->bukti_bayar)
                        <small class="text-warning"><i class="bi bi-clock me-1"></i>Menunggu</small>
                    @else
                        <small class="text-muted">Upload bukti dulu</small>
                    @endif
                @else
                    <small class="text-muted">Langkah sebelumnya</small>
                @endif
            </div>
        </div>

        <!-- Step 6: Selesai -->
        <div class="timeline-step {{ isset($pembayaran) && $pembayaran && $pembayaran->status == 'TERBAYAR' ? 'completed' : 'pending' }}">
            <div class="step-marker">
                <i class="bi {{ isset($pembayaran) && $pembayaran && $pembayaran->status == 'TERBAYAR' ? 'bi-check-circle-fill' : 'bi-trophy' }}"></i>
            </div>
            <div class="step-content">
                <h6 class="step-title">6. Selesai</h6>
                <p class="step-desc">Pendaftaran berhasil</p>
                @if(isset($pembayaran) && $pembayaran && $pembayaran->status == 'TERBAYAR')
                    <small class="text-success"><i class="bi bi-check me-1"></i>Selesai</small>
                @else
                    <small class="text-muted">Selesaikan semua</small>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper">
                <div class="stat-icon primary">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-number">
                    @if($pendaftar)
                        @if($pendaftar->status == 'SUBMIT')
                            Menunggu
                        @elseif($pendaftar->status == 'ADM_PASS')
                            Lulus
                        @elseif($pendaftar->status == 'ADM_REJECT')
                            Ditolak
                        @elseif($pendaftar->status == 'PAID')
                            Terbayar
                        @endif
                    @else
                        Belum Daftar
                    @endif
                </div>
                <div class="stat-label">Status Pendaftaran</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper">
                <div class="stat-icon success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $verifiedDocs }}/5</div>
                <div class="stat-label">Dokumen Terverifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper">
                <div class="stat-icon warning">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $pendingDocs }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper">
                <div class="stat-icon danger">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $rejectedDocs }}</div>
                <div class="stat-label">Dokumen Ditolak</div>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="chart-title mb-0"><i class="bi bi-file-earmark-text me-2"></i>Informasi Pendaftaran</h5>
                @if($pendaftar)
                    <a href="{{ route('dashboard.print-card') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-printer me-1"></i>Cetak Kartu
                    </a>
                @endif
            </div>
            <div class="info-list">
                @if($pendaftar)
                <div class="info-item">
                    <div class="info-label">No. Pendaftaran</div>
                    <div class="info-value">{{ $pendaftar->no_pendaftaran }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jurusan Pilihan</div>
                    <div class="info-value">
                        <span class="badge bg-primary">{{ $pendaftar->nama_jurusan }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal Daftar</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</div>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-info-circle fa-2x mb-2"></i>
                    <p>Belum melakukan pendaftaran</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-folder me-2"></i>Kelengkapan Dokumen</h5>
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-medium">Progress Upload</span>
                    <span class="fw-bold text-dark">{{ number_format($completeness, 0) }}%</span>
                </div>
                <div class="progress-container">
                    <div class="progress-bar" style="width: {{ $completeness }}%"></div>
                </div>
            </div>
            <a href="{{ route('dokumen.index') }}" class="btn btn-primary">
                <i class="bi bi-upload me-1"></i>Upload Dokumen
            </a>
        </div>
    </div>
</div>

<!-- Status Dokumen -->
<div class="chart-card">
    <h5 class="chart-title"><i class="bi bi-file-earmark-check me-2"></i>Status Dokumen</h5>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal Upload</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td>
                            <i class="bi bi-file-earmark me-2"></i>
                            @if($doc->jenis_dokumen == 'ijazah') Ijazah / SKL
                            @elseif($doc->jenis_dokumen == 'foto') Pas Foto
                            @elseif($doc->jenis_dokumen == 'kk') Kartu Keluarga
                            @elseif($doc->jenis_dokumen == 'akta_kelahiran') Akta Kelahiran
                            @elseif($doc->jenis_dokumen == 'raport') Raport
                            @endif
                        </td>
                        <td>
                            @if($doc->status == 'pending')
                                <span class="status-badge warning">
                                    <i class="bi bi-clock me-1"></i>Menunggu
                                </span>
                            @elseif($doc->status == 'verified')
                                <span class="status-badge success">
                                    <i class="bi bi-check-circle me-1"></i>Terverifikasi
                                </span>
                            @elseif($doc->status == 'rejected')
                                <span class="status-badge danger">
                                    <i class="bi bi-x-circle me-1"></i>Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="text-medium">{{ $doc->catatan ?? '-' }}</td>
                        <td class="text-medium">{{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fa-2x mb-2"></i>
                            <p>Belum ada dokumen yang diupload</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* Variabel konsisten dengan landing page */
:root {
    --cream: #FFFFFF;
    --cream-dark: #F5F5F5;
    --cream-darker: #E5E5E5;
    --primary: #1E40AF;
    --primary-light: #3B82F6;
    --primary-dark: #1E3A8A;
    --accent-red: #DC2626;
    --accent-red-light: #EF4444;
    --accent-red-dark: #B91C1C;
    --accent-green: #10B981;
    --accent-green-light: #34D399;
    --accent-green-dark: #059669;
    --accent-yellow: #F59E0B;
    --accent-yellow-light: #FBBF24;
    --accent-yellow-dark: #D97706;
    --text-dark: #1F2937;
    --text-medium: #4B5563;
    --text-light: #6B7280;
    --white: #FFFFFF;
}

/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.page-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.2rem;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    color: var(--text-light);
    margin: 0;
}

/* Chart Card (Card Utama) */
.chart-card {
    background: var(--white);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    border: 1px solid var(--cream-darker);
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}

.chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.chart-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.3rem;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
}

/* Stat Cards */
.stat-card {
    background: var(--white);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border: 1px solid var(--cream-darker);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.stat-icon-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--white);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.stat-icon.primary { background: var(--primary); }
.stat-icon.success { background: var(--accent-green); }
.stat-icon.warning { background: var(--accent-yellow); }
.stat-icon.danger { background: var(--accent-red); }

.stat-number {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 2rem;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    font-size: 0.95rem;
    color: var(--text-light);
    font-weight: 500;
}

/* Horizontal Timeline */
.horizontal-timeline {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 2rem 0;
}

.horizontal-timeline::before {
    content: '';
    position: absolute;
    top: 30px;
    left: 0;
    right: 0;
    height: 3px;
    background-color: var(--cream-darker);
    z-index: 1;
}

.timeline-step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
}

.step-marker {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    background-color: var(--white);
    border: 3px solid var(--cream-darker);
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.step-content {
    text-align: center;
    max-width: 180px;
}

.step-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.step-desc {
    font-size: 0.85rem;
    color: var(--text-light);
    margin-bottom: 0.8rem;
    line-height: 1.4;
}

/* Timeline Status */
.timeline-step.completed .step-marker {
    border-color: var(--accent-green);
    background-color: var(--accent-green);
    color: var(--white);
}

.timeline-step.current .step-marker {
    border-color: var(--primary);
    background-color: var(--primary);
    color: var(--white);
    box-shadow: 0 0 0 5px rgba(30, 64, 175, 0.2);
}

.timeline-step.pending .step-marker {
    border-color: var(--cream-darker);
    background-color: var(--white);
    color: var(--text-light);
}

.timeline-step.completed::after {
    content: '';
    position: absolute;
    top: 30px;
    left: 50%;
    right: -50%;
    height: 3px;
    background-color: var(--accent-green);
    z-index: 1;
}

.timeline-step:last-child::after {
    display: none;
}

/* Info List */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--cream-dark);
    border-radius: 12px;
    border: 1px solid var(--cream-darker);
}

.info-label {
    font-weight: 600;
    color: var(--text-dark);
    flex: 1;
}

.info-value {
    color: var(--text-medium);
    font-weight: 500;
}

/* Progress Bar */
.progress-container {
    height: 12px;
    background: var(--cream-darker);
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(135deg, var(--accent-green), var(--accent-green-dark));
    border-radius: 6px;
    transition: width 0.5s ease;
    position: relative;
    overflow: hidden;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Table Styles */
.table-container {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid var(--cream-darker);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
}

.data-table thead {
    background: var(--cream-dark);
}

.data-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-dark);
    border-bottom: 1px solid var(--cream-darker);
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--cream-darker);
    color: var(--text-medium);
}

.data-table tr:last-child td {
    border-bottom: none;
}

.data-table tr:hover {
    background: var(--cream-dark);
}

/* Status Badges */
.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.status-badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--accent-green);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--accent-yellow);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-badge.danger {
    background: rgba(220, 38, 38, 0.1);
    color: var(--accent-red);
    border: 1px solid rgba(220, 38, 38, 0.2);
}

/* Buttons */
.btn {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.6rem 1.2rem;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: var(--white);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, var(--accent-green), var(--accent-green-dark));
    color: var(--white);
}

.btn-outline-primary {
    border: 2px solid var(--primary);
    color: var(--primary);
    background: transparent;
}

.btn-outline-primary:hover {
    background: var(--primary);
    color: var(--white);
}

/* Alerts */
.alert {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--accent-green);
    border-left: 4px solid var(--accent-green);
}

.alert-danger {
    background: rgba(220, 38, 38, 0.1);
    color: var(--accent-red);
    border-left: 4px solid var(--accent-red);
}

.alert-link {
    color: inherit;
    text-decoration: underline;
    font-weight: 600;
}

/* Badges */
.badge {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .horizontal-timeline {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .horizontal-timeline::before {
        display: none;
    }
    
    .timeline-step {
        flex-direction: row;
        width: 100%;
        margin-bottom: 1.5rem;
    }
    
    .step-marker {
        margin-right: 1rem;
        margin-bottom: 0;
    }
    
    .step-content {
        text-align: left;
        max-width: none;
        flex: 1;
    }
    
    .timeline-step.completed::after {
        display: none;
    }

    .chart-card {
        padding: 1.5rem;
    }

    .page-title {
        font-size: 1.8rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}

@media (max-width: 480px) {
    .chart-card {
        padding: 1rem;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }

    .step-marker {
        width: 50px;
        height: 50px;
        font-size: 1rem;
    }
}
</style>
@endsection