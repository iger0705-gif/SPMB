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
            <h4 class="page-title"><i class="bi bi-calendar-day me-2"></i>Laporan Harian</h4>
            <p class="page-subtitle">Monitoring transaksi pembayaran harian</p>
        </div>
        <a href="{{ route('keuangan.laporan') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Filter Tanggal -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar3 me-2"></i>Pilih Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
                <div class="col-md-6 text-end">
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

    <!-- Ringkasan Harian -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-success">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-number text-success">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pembayaran Masuk</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-primary">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stat-number text-primary">{{ $jumlahTransaksi }}</div>
                <div class="stat-label">Jumlah Transaksi</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-info">
                    <i class="bi bi-calculator"></i>
                </div>
                <div class="stat-number text-info">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
                <div class="stat-label">Rata-rata per Transaksi</div>
            </div>
        </div>
    </div>

    <!-- Detail Transaksi -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul me-2"></i>Detail Transaksi Harian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-secondary">{{ $t->no_pendaftaran }}</span></td>
                            <td><strong>{{ $t->nama_lengkap }}</strong></td>
                            <td>{{ $t->nama_jurusan }}</td>
                            <td><strong class="text-success">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</strong></td>
                            <td><span class="badge bg-success">Terbayar</span></td>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($t->tanggal_verifikasi)->format('H:i') }}</small></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada transaksi pada tanggal ini</p>
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
