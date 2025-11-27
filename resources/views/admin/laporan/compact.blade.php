@extends('layouts.dashboard')

@section('title', 'Laporan & Export Data')

@section('content')
<div class="page-header">
    <h1 class="page-title">Laporan & Export Data</h1>
    <p class="page-subtitle">Statistik lengkap dan export data pendaftar PPDB</p>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-icon stat-primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-number text-primary">{{ $totalPendaftar }}</div>
            <div class="stat-label">Total</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-icon stat-secondary">
                <i class="bi bi-file-text"></i>
            </div>
            <div class="stat-number text-secondary">{{ $draft }}</div>
            <div class="stat-label">Draft</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-icon stat-warning">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-number text-warning">{{ $menunggu }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-icon stat-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-number text-success">{{ $lulus }}</div>
            <div class="stat-label">Lulus</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-icon stat-danger">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-number text-danger">{{ $ditolak }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card">
            <div class="stat-icon stat-info">
                <i class="bi bi-credit-card"></i>
            </div>
            <div class="stat-number text-info">{{ $terbayar }}</div>
            <div class="stat-label">Terbayar</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistik per Jurusan -->
    <div class="col-lg-6 mb-4">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-mortarboard me-2"></i>Pendaftar per Jurusan</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Kuota</th>
                            <th>Pendaftar</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perJurusan as $j)
                        <tr>
                            <td><strong>{{ $j->nama }}</strong></td>
                            <td><span class="badge bg-secondary">{{ $j->kuota }}</span></td>
                            <td><span class="badge bg-primary">{{ $j->total_pendaftar }}</span></td>
                            <td>
                                @php $persen = $j->kuota > 0 ? ($j->total_pendaftar / $j->kuota * 100) : 0; @endphp
                                <span class="badge {{ $persen >= 100 ? 'bg-danger' : ($persen >= 80 ? 'bg-warning' : 'bg-success') }}">
                                    {{ number_format($persen, 1) }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Trend Harian -->
    <div class="col-lg-6 mb-4">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-graph-up me-2"></i>Trend 7 Hari Terakhir</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trendHarian as $trend)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($trend->tanggal)->format('d/m/Y') }}</td>
                            <td><span class="badge bg-info">{{ $trend->total }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Asal Sekolah -->
<div class="row mb-4">
    <div class="col-12">
        <div class="chart-card">
            <h5 class="chart-title"><i class="bi bi-building me-2"></i>Top 10 Asal Sekolah</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Sekolah</th>
                            <th>Kabupaten</th>
                            <th>Jumlah Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asalSekolah as $index => $sekolah)
                        <tr>
                            <td>
                                @if($index == 0)
                                <span class="badge bg-warning">🥇 #{{ $index + 1 }}</span>
                                @elseif($index == 1)
                                <span class="badge bg-secondary">🥈 #{{ $index + 1 }}</span>
                                @elseif($index == 2)
                                <span class="badge bg-warning text-dark">🥉 #{{ $index + 1 }}</span>
                                @else
                                <span class="badge bg-light text-dark">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $sekolah->nama_sekolah }}</strong></td>
                            <td>{{ $sekolah->kabupaten }}</td>
                            <td><span class="badge bg-primary">{{ $sekolah->jumlah }} siswa</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Export Data Section -->
<div class="chart-card">
    <h5 class="chart-title"><i class="bi bi-download me-2"></i>Export Data Pendaftar</h5>
    <form action="{{ route('admin.laporan.export.proses') }}" method="GET" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Jurusan</label>
            <select name="jurusan_id" class="form-select">
                <option value="">Semua Jurusan</option>
                @foreach($jurusan as $j)
                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Gelombang</label>
            <select name="gelombang_id" class="form-select">
                <option value="">Semua Gelombang</option>
                @foreach($gelombang as $g)
                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="DRAFT">Draft</option>
                <option value="SUBMIT">Menunggu</option>
                <option value="ADM_PASS">Lulus Adm</option>
                <option value="ADM_REJECT">Ditolak</option>
                <option value="PAID">Terbayar</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control">
        </div>
        <div class="col-12">
            <div class="btn-group" role="group">
                <button type="submit" name="format" value="excel" class="btn btn-success">
                    <i class="bi bi-file-excel me-1"></i>Export Excel
                </button>
                <button type="submit" name="format" value="pdf" class="btn btn-danger">
                    <i class="bi bi-file-pdf me-1"></i>Export PDF
                </button>
            </div>
        </div>
    </form>
</div>
@endsection