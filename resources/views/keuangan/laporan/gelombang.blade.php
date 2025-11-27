@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .stat-card { font-family: 'Inter', sans-serif; }
    .table { font-family: 'Inter', sans-serif; font-size: 13px; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title"><i class="bi bi-graph-up-arrow me-2"></i>Laporan per Gelombang</h4>
            <p class="page-subtitle">Analisis kinerja per gelombang pendaftaran</p>
        </div>
        <a href="{{ route('keuangan.laporan') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Filter Gelombang -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-funnel me-2"></i>Pilih Gelombang</label>
                    <select name="gelombang_id" class="form-select" required>
                        <option value="">-- Pilih Gelombang --</option>
                        @foreach($gelombang as $g)
                        <option value="{{ $g->id }}" {{ isset($gelombangId) && $gelombangId == $g->id ? 'selected' : '' }}>
                            {{ $g->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
                @if(isset($gelombangId))
                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-success" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Print
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if(isset($gelombangData))
    <!-- Info Gelombang -->
    <div class="card shadow-sm mb-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-2 fw-bold">{{ $gelombangData->nama }}</h5>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-calendar-event me-2"></i>
                        {{ \Carbon\Carbon::parse($gelombangData->tgl_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($gelombangData->tgl_selesai)->format('d M Y') }}
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <h6 class="mb-1 opacity-75">Sisa Waktu</h6>
                    <h3 class="mb-0 fw-bold">{{ $sisaHari }} Hari</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Gelombang -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-primary">
                    <i class="bi bi-bullseye"></i>
                </div>
                <div class="stat-number text-primary">Rp {{ number_format($targetPenerimaan, 0, ',', '.') }}</div>
                <div class="stat-label">Target Penerimaan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-success">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-number text-success">Rp {{ number_format($realisasiPenerimaan, 0, ',', '.') }}</div>
                <div class="stat-label">Realisasi Penerimaan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-info">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="stat-number text-info">{{ number_format($pencapaian, 1) }}%</div>
                <div class="stat-label">Pencapaian</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-warning">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-number text-warning">{{ $totalTerbayar }} / {{ $totalPendaftar }}</div>
                <div class="stat-label">Pembayar / Pendaftar</div>
            </div>
        </div>
    </div>

    <!-- Grafik Target vs Realisasi -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart me-2"></i>Target vs Realisasi</h6>
        </div>
        <div class="card-body">
            <div style="padding: 20px 0;">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-weight: 600; font-size: 14px;">Target Penerimaan</span>
                        <span style="font-weight: 700; font-size: 16px; color: #3b82f6;">Rp {{ number_format($targetPenerimaan, 0, ',', '.') }}</span>
                    </div>
                    <div class="progress" style="height: 30px; border-radius: 10px; background: #f1f5f9;">
                        <div class="progress-bar" 
                             style="width: 100%; 
                                    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                                    border-radius: 10px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    color: white;
                                    font-weight: 600;">
                            100%
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-weight: 600; font-size: 14px;">Realisasi Penerimaan</span>
                        <span style="font-weight: 700; font-size: 16px; color: #10b981;">Rp {{ number_format($realisasiPenerimaan, 0, ',', '.') }}</span>
                    </div>
                    <div class="progress" style="height: 30px; border-radius: 10px; background: #f1f5f9;">
                        <div class="progress-bar" 
                             style="width: {{ $pencapaian }}%; 
                                    background: linear-gradient(90deg, #10b981, #38f9d7);
                                    border-radius: 10px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    color: white;
                                    font-weight: 600;">
                            {{ number_format($pencapaian, 1) }}%
                        </div>
                    </div>
                </div>
                @if($pencapaian >= 100)
                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle-fill me-2"></i><strong>Target Tercapai!</strong> Selamat, target penerimaan gelombang ini telah terpenuhi.
                </div>
                @elseif($pencapaian >= 75)
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i><strong>Hampir Tercapai!</strong> Tinggal sedikit lagi untuk mencapai target.
                </div>
                @else
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Perlu Ditingkatkan!</strong> Masih ada {{ number_format(100 - $pencapaian, 1) }}% lagi untuk mencapai target.
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Trend Pendaftaran -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Trend Pendaftaran per Hari</h6>
        </div>
        <div class="card-body">
            <div style="height: 300px; padding: 20px 0;">
                @php
                    $maxTotal = $trendPendaftaran->max('total') ?: 1;
                @endphp
                <div class="d-flex align-items-end justify-content-around h-100" style="gap: 8px;">
                    @foreach($trendPendaftaran as $trend)
                    <div class="text-center" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                        <div class="position-relative" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                            <div class="fw-bold mb-2" style="font-size: 14px; color: #43e97b;">{{ $trend->total }}</div>
                            <div class="rounded-3 shadow-sm" 
                                 style="height: {{ ($trend->total / $maxTotal * 100) }}%; 
                                        background: linear-gradient(180deg, #43e97b, #38f9d7);
                                        min-height: 30px;">
                            </div>
                        </div>
                        <div class="mt-3" style="font-size: 10px; font-weight: 600; color: #64748b;">{{ \Carbon\Carbon::parse($trend->tanggal)->format('d/m') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox" style="font-size: 80px; color: #cbd5e1;"></i>
            <h5 class="mt-3 text-muted">Pilih Gelombang</h5>
            <p class="text-muted">Silakan pilih gelombang untuk melihat laporan</p>
        </div>
    </div>
    @endif
</div>
@endsection
