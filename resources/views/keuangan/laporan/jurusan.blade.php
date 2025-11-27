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
            <h4 class="page-title"><i class="bi bi-mortarboard me-2"></i>Laporan per Jurusan</h4>
            <p class="page-subtitle">Analisis revenue per jurusan</p>
        </div>
        <a href="{{ route('keuangan.laporan') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Filter Periode -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar-check me-2"></i>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar-x me-2"></i>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-success" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Print
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Total Keseluruhan -->
    <div class="card shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="card-body text-center py-4">
            <h6 class="mb-2 opacity-75">Total Penerimaan Keseluruhan</h6>
            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</h2>
        </div>
    </div>

    <!-- Ringkasan per Jurusan -->
    <div class="row mb-4">
        @php
            $colors = ['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a'];
        @endphp
        @foreach($laporanJurusan as $index => $jurusan)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px; background: {{ $colors[$index % 5] }}20;">
                            <i class="bi bi-mortarboard" style="font-size: 24px; color: {{ $colors[$index % 5] }};"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $jurusan->nama }}</h6>
                            <small class="text-muted">Jurusan</small>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <small class="text-muted d-block">Total Penerimaan</small>
                        <h5 class="mb-0 fw-bold text-success">Rp {{ number_format($jurusan->total_penerimaan, 0, ',', '.') }}</h5>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <small class="text-muted d-block">Jumlah Siswa</small>
                            <strong class="text-primary">{{ $jurusan->jumlah_siswa }} siswa</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Rata-rata</small>
                            <strong class="text-info">Rp {{ number_format($jurusan->rata_rata, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Grafik Pie Chart -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart me-2"></i>Persentase Penerimaan per Jurusan</h6>
        </div>
        <div class="card-body">
            <div style="padding: 20px 0;">
                @foreach($laporanJurusan as $index => $jurusan)
                @php
                    $percentage = $totalKeseluruhan > 0 ? ($jurusan->total_penerimaan / $totalKeseluruhan * 100) : 0;
                @endphp
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 20px; height: 20px; border-radius: 4px; background: {{ $colors[$index % 5] }};"></div>
                            <span style="font-weight: 600; font-size: 14px;">{{ $jurusan->nama }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-weight: 700; font-size: 16px; color: {{ $colors[$index % 5] }};">Rp {{ number_format($jurusan->total_penerimaan / 1000000, 1) }}jt</span>
                            <span style="font-size: 12px; color: #94a3b8;">({{ number_format($percentage, 1) }}%)</span>
                        </div>
                    </div>
                    <div class="progress" style="height: 12px; border-radius: 10px; background: #f1f5f9;">
                        <div class="progress-bar" 
                             style="width: {{ $percentage }}%; 
                                    background: {{ $colors[$index % 5] }};
                                    border-radius: 10px;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tabel Comparatif -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-table me-2"></i>Tabel Perbandingan Jurusan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Jurusan</th>
                            <th>Total Penerimaan</th>
                            <th>Jumlah Siswa</th>
                            <th>Rata-rata</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanJurusan->sortByDesc('total_penerimaan')->values() as $index => $jurusan)
                        @php
                            $percentage = $totalKeseluruhan > 0 ? ($jurusan->total_penerimaan / $totalKeseluruhan * 100) : 0;
                        @endphp
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
                            <td><strong>{{ $jurusan->nama }}</strong></td>
                            <td><strong class="text-success">Rp {{ number_format($jurusan->total_penerimaan, 0, ',', '.') }}</strong></td>
                            <td>{{ $jurusan->jumlah_siswa }} siswa</td>
                            <td>Rp {{ number_format($jurusan->rata_rata, 0, ',', '.') }}</td>
                            <td><span class="badge bg-primary">{{ number_format($percentage, 1) }}%</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
