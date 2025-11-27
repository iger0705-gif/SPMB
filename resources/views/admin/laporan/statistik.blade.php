@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .chart-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: 'Inter', sans-serif; }
    .stat-box { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; }
    .stat-box h3 { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 32px; margin: 10px 0; }
    .stat-box p { color: #64748b; margin: 0; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title"><i class="bi bi-graph-up me-2"></i>Laporan Statistik</h4>
            <p class="page-subtitle">Analisis data pendaftaran dengan grafik dan visualisasi</p>
        </div>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer me-2"></i>Print Laporan
        </button>
    </div>

    <!-- Filter Periode -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rasio Kelulusan & Konversi -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-box" style="border-left: 4px solid #3b82f6;">
                <p>Total Pendaftar</p>
                <h3 class="text-primary">{{ $totalPendaftar }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box" style="border-left: 4px solid #10b981;">
                <p>Lulus Administrasi</p>
                <h3 class="text-success">{{ $lulusAdm }}</h3>
                <small class="text-muted">{{ number_format($rasioLulus, 1) }}%</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box" style="border-left: 4px solid #8b5cf6;">
                <p>Terbayar</p>
                <h3 style="color: #8b5cf6;">{{ $terbayar }}</h3>
                <small class="text-muted">{{ number_format($konversiPembayaran, 1) }}%</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box" style="border-left: 4px solid #f59e0b;">
                <p>Rasio Konversi</p>
                <h3 class="text-warning">{{ number_format($konversiPembayaran, 1) }}%</h3>
            </div>
        </div>
    </div>

    <!-- Trend Pendaftaran -->
    <div class="chart-card mb-4">
        <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
            <i class="bi bi-graph-up me-2 text-primary"></i>Trend Pendaftaran Periode
        </h6>
        <div style="height: 300px; padding: 20px 0;">
            @php
                $maxTotal = $trendPendaftaran->max('total') ?: 1;
            @endphp
            <div class="d-flex align-items-end justify-content-around h-100" style="gap: 8px;">
                @foreach($trendPendaftaran as $trend)
                <div class="text-center" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                    <div class="position-relative" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                        <div class="fw-bold mb-2" style="font-size: 14px; color: #3b82f6;">{{ $trend->total }}</div>
                        <div class="rounded-3 shadow-sm" 
                             style="height: {{ ($trend->total / $maxTotal * 100) }}%; 
                                    background: linear-gradient(180deg, #3b82f6, #8b5cf6);
                                    min-height: 30px;">
                        </div>
                    </div>
                    <div class="mt-3" style="font-size: 10px; font-weight: 600; color: #64748b;">
                        {{ \Carbon\Carbon::parse($trend->tanggal)->format('d/m') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Perbandingan Jurusan -->
        <div class="col-lg-6">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-mortarboard me-2 text-success"></i>Perbandingan per Jurusan
                </h6>
                @foreach($perbandinganJurusan as $jurusan)
                @php
                    $rasio = $jurusan->kuota > 0 ? ($jurusan->total_pendaftar / $jurusan->kuota * 100) : 0;
                    $color = $rasio >= 100 ? '#10b981' : ($rasio >= 75 ? '#3b82f6' : '#f59e0b');
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>{{ $jurusan->nama }}</strong>
                        <span style="font-size: 13px;">
                            {{ $jurusan->total_pendaftar }}/{{ $jurusan->kuota }} 
                            <strong style="color: {{ $color }};">({{ number_format($rasio, 0) }}%)</strong>
                        </span>
                    </div>
                    <div class="progress" style="height: 20px; border-radius: 10px;">
                        <div class="progress-bar" 
                             style="width: {{ min($rasio, 100) }}%; background: {{ $color }};">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Perbandingan Gelombang -->
        <div class="col-lg-6">
            <div class="chart-card">
                <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
                    <i class="bi bi-calendar-event me-2 text-info"></i>Perbandingan per Gelombang
                </h6>
                @php
                    $totalGelombang = $perbandinganGelombang->sum('total');
                    $colors = ['#667eea', '#f093fb', '#4facfe'];
                @endphp
                @foreach($perbandinganGelombang as $index => $gelombang)
                @php
                    $persentase = $totalGelombang > 0 ? ($gelombang->total / $totalGelombang * 100) : 0;
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>{{ $gelombang->nama }}</strong>
                        <span>{{ $gelombang->total }} ({{ number_format($persentase, 1) }}%)</span>
                    </div>
                    <div class="progress" style="height: 20px; border-radius: 10px;">
                        <div class="progress-bar" 
                             style="width: {{ $persentase }}%; background: {{ $colors[$index % 3] }};">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Analisis Asal Sekolah -->
    <div class="chart-card">
        <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;">
            <i class="bi bi-building me-2 text-warning"></i>Top 20 Asal Sekolah
        </h6>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ranking</th>
                        <th>Nama Sekolah</th>
                        <th>Kabupaten</th>
                        <th>Jumlah</th>
                        <th>Rata-rata Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asalSekolah as $index => $sekolah)
                    <tr>
                        <td>
                            @if($index == 0)
                            <span class="badge bg-warning">🥇 #1</span>
                            @elseif($index == 1)
                            <span class="badge bg-secondary">🥈 #2</span>
                            @elseif($index == 2)
                            <span class="badge bg-info">🥉 #3</span>
                            @else
                            <span class="badge bg-light text-dark">#{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $sekolah->nama_sekolah }}</strong></td>
                        <td>{{ $sekolah->kabupaten }}</td>
                        <td><span class="badge bg-primary">{{ $sekolah->jumlah }}</span></td>
                        <td><strong class="text-success">{{ number_format($sekolah->rata_nilai, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
