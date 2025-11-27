@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .chart-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: 'Inter', sans-serif; }
    .chart-title { font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title"><i class="bi bi-graph-up me-2"></i>Grafik Pendaftaran</h4>
            <p class="page-subtitle">Visualisasi data pendaftaran lengkap</p>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select" onchange="window.location.href='?periode='+this.value">
                <option value="7" {{ $periode == 7 ? 'selected' : '' }}>7 Hari</option>
                <option value="30" {{ $periode == 30 ? 'selected' : '' }}>30 Hari</option>
                <option value="90" {{ $periode == 90 ? 'selected' : '' }}>90 Hari</option>
            </select>
            <a href="{{ route('kepsek.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Grafik Tren Multi-Line -->
    <div class="chart-card mb-4">
        <h6 class="chart-title mb-3"><i class="bi bi-graph-up me-2 text-primary"></i>Tren Pendaftaran (Multi-Line)</h6>
        <div style="height: 350px; padding: 20px 0;">
            @php
                $maxValue = max(
                    $trenData->max('total_pendaftar') ?: 1,
                    $trenData->max('lulus_adm') ?: 1,
                    $trenData->max('terbayar') ?: 1
                );
            @endphp
            <div class="position-relative h-100">
                <!-- Legend -->
                <div class="d-flex gap-3 mb-3 justify-content-center">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 20px; height: 3px; background: #3b82f6;"></div>
                        <small>Pendaftar Baru</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 20px; height: 3px; background: #10b981;"></div>
                        <small>Lulus Administrasi</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 20px; height: 3px; background: #8b5cf6;"></div>
                        <small>Pembayaran Lunas</small>
                    </div>
                </div>
                
                <!-- Chart Area -->
                <div class="d-flex align-items-end justify-content-around" style="height: 280px; gap: 8px;">
                    @foreach($trenData as $tren)
                    <div class="text-center position-relative" style="flex: 1; height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                        <!-- Bars -->
                        <div class="position-relative" style="height: 100%; display: flex; gap: 2px; align-items: flex-end;">
                            <div class="rounded-top" title="Pendaftar: {{ $tren->total_pendaftar }}"
                                 style="flex: 1; height: {{ ($tren->total_pendaftar / $maxValue * 100) }}%; background: #3b82f6; min-height: 5px;"></div>
                            <div class="rounded-top" title="Lulus: {{ $tren->lulus_adm }}"
                                 style="flex: 1; height: {{ ($tren->lulus_adm / $maxValue * 100) }}%; background: #10b981; min-height: 5px;"></div>
                            <div class="rounded-top" title="Bayar: {{ $tren->terbayar }}"
                                 style="flex: 1; height: {{ ($tren->terbayar / $maxValue * 100) }}%; background: #8b5cf6; min-height: 5px;"></div>
                        </div>
                        <div class="mt-2" style="font-size: 9px; color: #64748b; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($tren->tanggal)->format('d/m') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Status Pendaftaran (Donut Chart) -->
        <div class="col-lg-6">
            <div class="chart-card">
                <h6 class="chart-title mb-3"><i class="bi bi-pie-chart-fill me-2 text-success"></i>Status Pendaftaran</h6>
                <div style="padding: 20px 0;">
                    @php
                        $statusColors = [
                            'SUBMIT' => ['color' => '#f59e0b', 'label' => 'Menunggu Verifikasi', 'icon' => 'clock'],
                            'ADM_PASS' => ['color' => '#10b981', 'label' => 'Lulus Administrasi', 'icon' => 'check-circle'],
                            'ADM_REJECT' => ['color' => '#ef4444', 'label' => 'Ditolak', 'icon' => 'x-circle'],
                            'PAID' => ['color' => '#3b82f6', 'label' => 'Terbayar', 'icon' => 'credit-card'],
                        ];
                        $totalStatus = $statusData->sum('total');
                    @endphp
                    @foreach($statusData as $status)
                    @php
                        $info = $statusColors[$status->status] ?? ['color' => '#64748b', 'label' => $status->status, 'icon' => 'circle'];
                        $percentage = $totalStatus > 0 ? ($status->total / $totalStatus * 100) : 0;
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-{{ $info['icon'] }}" style="color: {{ $info['color'] }}; font-size: 18px;"></i>
                                <span style="font-weight: 600; font-size: 14px;">{{ $info['label'] }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-weight: 700; font-size: 16px; color: {{ $info['color'] }};">{{ $status->total }}</span>
                                <span style="font-size: 12px; color: #94a3b8;">({{ number_format($percentage, 1) }}%)</span>
                            </div>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 10px; background: #f1f5f9;">
                            <div class="progress-bar" 
                                 style="width: {{ $percentage }}%; 
                                        background: {{ $info['color'] }};
                                        border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pendaftar per Jurusan (Bar Chart) -->
        <div class="col-lg-6">
            <div class="chart-card">
                <h6 class="chart-title mb-3"><i class="bi bi-bar-chart-fill me-2 text-info"></i>Pendaftar per Jurusan</h6>
                <div style="height: 300px; padding: 20px 0;">
                    @php
                        $maxJurusan = $jurusanData->max('total') ?: 1;
                        $colors = ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444'];
                    @endphp
                    <div class="d-flex align-items-end justify-content-around h-100" style="gap: 15px;">
                        @foreach($jurusanData as $index => $jurusan)
                        <div class="text-center" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                            <div class="position-relative" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                                <div class="fw-bold mb-2" style="font-size: 18px; color: {{ $colors[$index % 5] }};">{{ $jurusan->total }}</div>
                                <div class="rounded-3 shadow-sm" 
                                     style="height: {{ ($jurusan->total / $maxJurusan * 100) }}%; 
                                            background: linear-gradient(180deg, {{ $colors[$index % 5] }}, {{ $colors[$index % 5] }}dd);
                                            min-height: 30px;">
                                </div>
                            </div>
                            <div class="mt-3" style="font-size: 11px; font-weight: 600; color: #64748b;">{{ Str::limit($jurusan->nama, 12) }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftar per Gelombang -->
    <div class="chart-card">
        <h6 class="chart-title mb-3"><i class="bi bi-graph-up-arrow me-2 text-warning"></i>Pendaftar per Gelombang</h6>
        <div style="padding: 20px 0;">
            @php
                $totalGelombang = $gelombangData->sum('total');
                $gelombangColors = ['#667eea', '#f093fb', '#4facfe'];
            @endphp
            @foreach($gelombangData as $index => $gelombang)
            @php
                $percentage = $totalGelombang > 0 ? ($gelombang->total / $totalGelombang * 100) : 0;
            @endphp
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong style="font-size: 15px;">{{ $gelombang->nama }}</strong>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-weight: 700; font-size: 18px; color: {{ $gelombangColors[$index % 3] }};">{{ $gelombang->total }}</span>
                        <span style="font-size: 13px; color: #94a3b8;">({{ number_format($percentage, 1) }}%)</span>
                    </div>
                </div>
                <div class="progress" style="height: 25px; border-radius: 10px; background: #f1f5f9;">
                    <div class="progress-bar" 
                         style="width: {{ $percentage }}%; 
                                background: linear-gradient(90deg, {{ $gelombangColors[$index % 3] }}, {{ $gelombangColors[$index % 3] }}dd);
                                border-radius: 10px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: white;
                                font-weight: 600;
                                font-size: 13px;">
                        {{ $gelombang->total }} siswa
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
