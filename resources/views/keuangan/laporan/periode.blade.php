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
            <h4 class="page-title"><i class="bi bi-calendar-range me-2"></i>Laporan Periode</h4>
            <p class="page-subtitle">Analisis keuangan periode tertentu</p>
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

    <!-- Ringkasan Periode -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-number text-success">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Penerimaan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-primary">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number text-primary">{{ $transaksiSukses }}</div>
                <div class="stat-label">Transaksi Sukses</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-danger">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-number text-danger">{{ $transaksiDitolak }}</div>
                <div class="stat-label">Transaksi Ditolak</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-number text-warning">{{ $transaksiPending }}</div>
                <div class="stat-label">Transaksi Pending</div>
            </div>
        </div>
    </div>

    <!-- Grafik Tren Harian -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Tren Penerimaan Harian</h6>
        </div>
        <div class="card-body">
            <div style="height: 300px; padding: 20px 0;">
                @php
                    $maxTotal = $trenHarian->max('total') ?: 1;
                @endphp
                <div class="d-flex align-items-end justify-content-around h-100" style="gap: 10px;">
                    @foreach($trenHarian as $hari)
                    <div class="text-center" style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                        <div class="position-relative" style="height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                            <div class="fw-bold mb-2" style="font-size: 12px; color: #10b981;">Rp {{ number_format($hari->total / 1000, 0) }}k</div>
                            <div class="rounded-3 shadow-sm" 
                                 style="height: {{ ($hari->total / $maxTotal * 100) }}%; 
                                        background: linear-gradient(180deg, #10b981, #10b981dd);
                                        min-height: 30px;">
                            </div>
                        </div>
                        <div class="mt-3" style="font-size: 10px; font-weight: 600; color: #64748b;">{{ \Carbon\Carbon::parse($hari->tanggal)->format('d/m') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Transaksi -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul me-2"></i>Detail Transaksi Periode</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><small>{{ \Carbon\Carbon::parse($t->tanggal_verifikasi)->format('d/m/Y') }}</small></td>
                            <td><span class="badge bg-secondary">{{ $t->no_pendaftaran }}</span></td>
                            <td><strong>{{ $t->nama_lengkap }}</strong></td>
                            <td>{{ $t->nama_jurusan }}</td>
                            <td><strong class="text-success">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</strong></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada transaksi pada periode ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
