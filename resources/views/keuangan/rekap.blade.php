@extends('layouts.dashboard')

@section('title', 'Rekap & Laporan Keuangan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Rekap & Laporan Keuangan</h1>
    <p class="page-subtitle">Data lengkap pembayaran dan analisis keuangan PPDB</p>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon stat-success">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-number text-success">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</div>
            <div class="stat-label">Total Penerimaan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon stat-primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-number text-primary">{{ $rekap->count() }}</div>
            <div class="stat-label">Siswa Terbayar</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon stat-warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-number text-warning">{{ $statusPembayaran->where('status', 'MENUNGGU_VERIFIKASI')->first()->total ?? 0 }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon stat-danger">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-number text-danger">{{ $statusPembayaran->where('status', 'DITOLAK')->first()->total ?? 0 }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Laporan per Jurusan -->
    <div class="col-lg-6 mb-4">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-mortarboard me-2"></i>Penerimaan per Jurusan</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Siswa</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanJurusan as $jurusan)
                        <tr>
                            <td><strong>{{ $jurusan->nama }}</strong></td>
                            <td><span class="badge bg-primary">{{ $jurusan->jumlah_siswa }}</span></td>
                            <td><strong>Rp {{ number_format($jurusan->total_penerimaan, 0, ',', '.') }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Laporan Harian -->
    <div class="col-lg-6 mb-4">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-calendar-day me-2"></i>Penerimaan 7 Hari Terakhir</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanHarian as $hari)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($hari->tanggal)->format('d/m/Y') }}</td>
                            <td><span class="badge bg-info">{{ $hari->jumlah }}</span></td>
                            <td><strong>Rp {{ number_format($hari->total, 0, ',', '.') }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Pembayaran -->
<div class="chart-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="chart-title mb-0"><i class="bi bi-table me-2"></i>Detail Pembayaran Terbayar</h5>
        <button class="btn btn-success btn-sm" onclick="exportToExcel()">
            <i class="bi bi-file-excel me-1"></i>Export Excel
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="rekapTable">
            <thead class="table-light">
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Jumlah</th>
                    <th>Tanggal Bayar</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekap as $item)
                <tr>
                    <td><span class="badge bg-secondary">{{ $item->no_pendaftaran }}</span></td>
                    <td><strong>{{ $item->nama_lengkap }}</strong></td>
                    <td><span class="badge" style="background: #8b5cf6;">{{ $item->nama_jurusan }}</span></td>
                    <td><strong>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</strong></td>
                    <td><small>{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d/m/Y H:i') }}</small></td>
                    <td><small>{{ \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d/m/Y H:i') }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function exportToExcel() {
    const table = document.getElementById('rekapTable');
    const wb = XLSX.utils.table_to_book(table, {sheet: "Rekap Pembayaran"});
    XLSX.writeFile(wb, 'rekap-pembayaran-' + new Date().toISOString().slice(0,10) + '.xlsx');
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@endsection