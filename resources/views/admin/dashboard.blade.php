@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Dashboard Admin PPDB</h1>
            <p class="page-subtitle">Monitoring dan pengelolaan penerimaan peserta didik baru</p>
        </div>
        <div>
            <a href="{{ route('admin.verifikasi.dashboard') }}" class="btn btn-warning">
                <i class="bi bi-search me-1"></i>Dashboard Verifikasi
            </a>
        </div>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon stat-primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-number text-primary">{{ $totalPendaftar }}</div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon stat-secondary">
                <i class="bi bi-file-text"></i>
            </div>
            <div class="stat-number text-secondary">{{ $draft }}</div>
            <div class="stat-label">Draft</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon stat-warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-number text-warning">{{ $menungguVerifikasi }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon stat-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-number text-success">{{ $lulusAdministrasi }}</div>
            <div class="stat-label">Lulus</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon stat-danger">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-number text-danger">{{ $ditolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon stat-info">
                <i class="bi bi-credit-card"></i>
            </div>
            <div class="stat-number text-info">{{ $terbayar }}</div>
            <div class="stat-label">Terbayar</div>
        </div>
    </div>
</div>

<!-- GRAFIK & CHART -->
<div class="row mb-4">
    <!-- GRAFIK PENDAFTAR PER JURUSAN -->
    <div class="col-xl-8 col-lg-7">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-bar-chart-fill me-2"></i>Pendaftar per Jurusan</h5>
            <div style="height: 320px; padding: 20px 0;">
                @php
                    $maxTotal = $pendaftarPerJurusan->max('total') ?: 1;
                    $colors = ['#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981'];
                @endphp
                <div class="d-flex align-items-end justify-content-around h-100" style="gap: 15px;">
                    @foreach($pendaftarPerJurusan as $index => $jurusan)
                    <div class="text-center" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                        <div class="position-relative" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                            <div class="fw-bold mb-2" style="font-size: 18px; color: {{ $colors[$index % 5] }};">{{ $jurusan->total }}</div>
                            <div class="rounded-3 shadow-sm" 
                                 style="height: {{ ($jurusan->total / $maxTotal * 100) }}%; 
                                        background: linear-gradient(180deg, {{ $colors[$index % 5] }}, {{ $colors[$index % 5] }}dd);
                                        min-height: 30px;
                                        transition: all 0.3s ease;"
                                 onmouseover="this.style.transform='scaleY(1.05)'; this.style.filter='brightness(1.1)'"
                                 onmouseout="this.style.transform='scaleY(1)'; this.style.filter='brightness(1)'">
                            </div>
                        </div>
                        <div class="mt-3" style="font-size: 12px; font-weight: 600; color: #64748b;">{{ Str::limit($jurusan->nama, 15) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- STATUS PENDAFTAR -->
    <div class="col-xl-4 col-lg-5">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-pie-chart-fill me-2"></i>Status Pendaftaran</h5>
            <div style="padding: 20px 0;">
                @php
                    $statusColors = [
                        'DRAFT' => ['color' => '#64748b', 'label' => 'Draft', 'icon' => 'file-text'],
                        'SUBMIT' => ['color' => '#f59e0b', 'label' => 'Menunggu', 'icon' => 'clock'],
                        'ADM_PASS' => ['color' => '#10b981', 'label' => 'Lulus Adm', 'icon' => 'check-circle'],
                        'ADM_REJECT' => ['color' => '#ef4444', 'label' => 'Ditolak', 'icon' => 'x-circle'],
                        'PAID' => ['color' => '#3b82f6', 'label' => 'Terbayar', 'icon' => 'credit-card'],
                    ];
                @endphp
                @foreach($statusPendaftaran as $status)
                @php
                    $statusInfo = $statusColors[$status->status] ?? ['color' => '#64748b', 'label' => $status->status, 'icon' => 'circle'];
                    $percentage = $totalPendaftar > 0 ? ($status->total / $totalPendaftar * 100) : 0;
                @endphp
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-{{ $statusInfo['icon'] }}" style="color: {{ $statusInfo['color'] }}; font-size: 18px;"></i>
                            <span style="font-weight: 600; font-size: 14px; color: #1e293b;">{{ $statusInfo['label'] }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-weight: 700; font-size: 16px; color: {{ $statusInfo['color'] }};">{{ $status->total }}</span>
                            <span style="font-size: 12px; color: #94a3b8;">({{ number_format($percentage, 1) }}%)</span>
                        </div>
                    </div>
                    <div class="progress" style="height: 12px; border-radius: 10px; background: #f1f5f9;">
                        <div class="progress-bar" 
                             style="width: {{ $percentage }}%; 
                                    background: linear-gradient(90deg, {{ $statusInfo['color'] }}, {{ $statusInfo['color'] }}dd);
                                    border-radius: 10px;
                                    transition: width 0.6s ease;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- TABEL DATA PENDAFTAR -->
<div class="chart-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="chart-title mb-0"><i class="bi bi-table me-2"></i>Pendaftar Terbaru</h5>
        <a href="{{ route('admin.pendaftar') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-arrow-right me-1"></i>Lihat Semua
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftarTerbaru as $pendaftar)
                <tr>
                    <td><span class="badge bg-secondary">{{ $pendaftar->no_pendaftaran }}</span></td>
                    <td><strong>{{ $pendaftar->nama_lengkap }}</strong></td>
                    <td><span class="badge" style="background: #8b5cf6;">{{ $pendaftar->nama_jurusan }}</span></td>
                    <td><small class="text-muted">{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</small></td>
                    <td>
                        @if($pendaftar->status == 'DRAFT')
                        <span class="badge bg-secondary"><i class="bi bi-file-text me-1"></i>Draft</span>
                        @elseif($pendaftar->status == 'SUBMIT')
                        <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Menunggu</span>
                        @elseif($pendaftar->status == 'ADM_PASS')
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Lulus</span>
                        @elseif($pendaftar->status == 'ADM_REJECT')
                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                        @elseif($pendaftar->status == 'PAID')
                        <span class="badge bg-info"><i class="bi bi-credit-card me-1"></i>Terbayar</span>
                        @else
                        <span class="badge bg-light text-dark">{{ $pendaftar->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pendaftar.detail', $pendaftar->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection