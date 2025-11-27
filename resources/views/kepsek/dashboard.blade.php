@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .kpi-card { 
        background: white; 
        border-radius: 12px; 
        padding: 20px; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
        border-left: 4px solid;
        font-family: 'Inter', sans-serif;
    }
    .kpi-value { font-size: 32px; font-weight: 700; font-family: 'Poppins', sans-serif; }
    .kpi-label { font-size: 13px; color: #64748b; }
    .kpi-subtitle { font-size: 12px; color: #94a3b8; }
    .chart-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard Eksekutif</h4>
            <p class="page-subtitle">Monitoring dan analisis PPDB secara real-time</p>
        </div>
        <div>
            <select class="form-select" onchange="window.location.href='?periode='+this.value">
                <option value="7" {{ $periode == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ $periode == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="90" {{ $periode == 90 ? 'selected' : '' }}>90 Hari Terakhir</option>
            </select>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="kpi-card" style="border-left-color: #3b82f6;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="kpi-label">Total Pendaftar</div>
                    <i class="bi bi-people text-primary" style="font-size: 24px;"></i>
                </div>
                <div class="kpi-value text-primary">{{ $totalPendaftar }}</div>
                <div class="kpi-subtitle">
                    vs Target: {{ $targetPendaftar }} ({{ number_format($pencapaianTarget, 1) }}%)
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card" style="border-left-color: #10b981;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="kpi-label">Lulus Administrasi</div>
                    <i class="bi bi-check-circle text-success" style="font-size: 24px;"></i>
                </div>
                <div class="kpi-value text-success">{{ $lulusAdministrasi }}</div>
                <div class="kpi-subtitle">Rasio: {{ number_format($rasioLulus, 1) }}%</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card" style="border-left-color: #8b5cf6;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="kpi-label">Pembayaran Lunas</div>
                    <i class="bi bi-credit-card text-purple" style="font-size: 24px; color: #8b5cf6;"></i>
                </div>
                <div class="kpi-value" style="color: #8b5cf6;">{{ $pembayaranLunas }}</div>
                <div class="kpi-subtitle">Konversi: {{ number_format($konversiPembayaran, 1) }}%</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kpi-card" style="border-left-color: #f59e0b;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="kpi-label">Tren Harian</div>
                    <i class="bi bi-graph-up-arrow text-warning" style="font-size: 24px;"></i>
                </div>
                <div class="kpi-value text-warning">
                    @if($trenPendaftaran->count() > 0)
                    {{ $trenPendaftaran->last()->total }}
                    @else
                    0
                    @endif
                </div>
                <div class="kpi-subtitle">Pendaftar hari ini</div>
            </div>
        </div>
    </div>

    <!-- Grafik Tren Pendaftaran -->
    <div class="chart-card mb-4">
        <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
            <i class="bi bi-graph-up me-2 text-primary"></i>Tren Pendaftaran Harian
        </h6>
        <div style="height: 300px; padding: 20px 0;">
            @php
                $maxTotal = $trenPendaftaran->max('total') ?: 1;
            @endphp
            <div class="d-flex align-items-end justify-content-around h-100" style="gap: 8px;">
                @foreach($trenPendaftaran as $tren)
                <div class="text-center" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                    <div class="position-relative" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                        <div class="fw-bold mb-2" style="font-size: 14px; color: #3b82f6;">{{ $tren->total }}</div>
                        <div class="rounded-3 shadow-sm" 
                             style="height: {{ ($tren->total / $maxTotal * 100) }}%; 
                                    background: linear-gradient(180deg, #3b82f6, #8b5cf6);
                                    min-height: 30px;">
                        </div>
                    </div>
                    <div class="mt-3" style="font-size: 10px; font-weight: 600; color: #64748b;">
                        {{ \Carbon\Carbon::parse($tren->tanggal)->format('d/m') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Pendaftar vs Kuota per Jurusan -->
        <div class="col-lg-6">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-bar-chart-fill me-2 text-success"></i>Pendaftar vs Kuota per Jurusan
                </h6>
                <div style="padding: 10px 0;">
                    @foreach($jurusanData as $jurusan)
                    @php
                        $rasio = $jurusan->kuota > 0 ? ($jurusan->jumlah_pendaftar / $jurusan->kuota * 100) : 0;
                        $color = $rasio >= 100 ? '#10b981' : ($rasio >= 75 ? '#3b82f6' : '#f59e0b');
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong style="font-size: 14px;">{{ $jurusan->nama }}</strong>
                            <span style="font-size: 13px; color: #64748b;">
                                {{ $jurusan->jumlah_pendaftar }}/{{ $jurusan->kuota }} 
                                <strong style="color: {{ $color }};">({{ number_format($rasio, 0) }}%)</strong>
                            </span>
                        </div>
                        <div class="progress" style="height: 20px; border-radius: 10px; background: #f1f5f9;">
                            <div class="progress-bar" 
                                 style="width: {{ min($rasio, 100) }}%; 
                                        background: {{ $color }};
                                        border-radius: 10px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 11px;
                                        font-weight: 600;">
                                {{ $jurusan->jumlah_pendaftar }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Komposisi Asal Sekolah -->
        <div class="col-lg-6">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-pie-chart-fill me-2 text-info"></i>Top 10 Asal Sekolah
                </h6>
                <div style="padding: 10px 0;">
                    @php
                        $totalAsalSekolah = $asalSekolah->sum('jumlah');
                        $colors = ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899', '#84cc16', '#f97316', '#6366f1'];
                    @endphp
                    @foreach($asalSekolah as $index => $sekolah)
                    @php
                        $persentase = $totalAsalSekolah > 0 ? ($sekolah->jumlah / $totalAsalSekolah * 100) : 0;
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 12px; height: 12px; border-radius: 3px; background: {{ $colors[$index % 10] }};"></div>
                                <span style="font-size: 13px; font-weight: 500;">{{ Str::limit($sekolah->nama_sekolah, 30) }}</span>
                            </div>
                            <span style="font-size: 12px; color: #64748b;">
                                <strong>{{ $sekolah->jumlah }}</strong> ({{ number_format($persentase, 1) }}%)
                            </span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 10px; background: #f1f5f9;">
                            <div class="progress-bar" 
                                 style="width: {{ $persentase }}%; 
                                        background: {{ $colors[$index % 10] }};
                                        border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body text-center py-4">
            <h5 class="text-white mb-3" style="font-family: 'Poppins', sans-serif;">Quick Actions</h5>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="{{ route('kepsek.grafik') }}" class="btn btn-light">
                    <i class="bi bi-graph-up me-2"></i>Grafik Lengkap
                </a>
                <a href="{{ route('kepsek.analisis') }}" class="btn btn-light">
                    <i class="bi bi-building me-2"></i>Analisis Sekolah
                </a>
                <button class="btn btn-light" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Print Dashboard
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
