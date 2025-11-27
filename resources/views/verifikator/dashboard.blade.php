@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard Verifikasi</h4>
        <p class="page-subtitle">Ringkasan tugas verifikasi administrasi</p>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $tugasHariIni }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $sudahDiverifikasi }}</div>
                <div class="stat-label">Sudah Diverifikasi</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $perluPerbaikan }}</div>
                <div class="stat-label">Perlu Perbaikan</div>
            </div>
        </div>
    </div>

    <!-- Notifikasi Upload Ulang -->
    <div class="chart-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="chart-title mb-0"><i class="bi bi-bell me-2"></i>Notifikasi Upload Ulang</h5>
            <a href="{{ route('verifikator.daftar') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-list-check me-1"></i>Lihat Semua
            </a>
        </div>
        
        @if($uploadUlang->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Lengkap</th>
                        <th>Jurusan</th>
                        <th>Waktu Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploadUlang as $p)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $p->no_pendaftaran }}</span></td>
                        <td><strong>{{ $p->nama_lengkap }}</strong></td>
                        <td>{{ $p->nama_jurusan }}</td>
                        <td><small class="text-muted">{{ \Carbon\Carbon::parse($p->updated_at)->diffForHumans() }}</small></td>
                        <td>
                            <a href="{{ route('admin.pendaftar.detail', $p->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>Verifikasi
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info mb-0">
            <i class="bi bi-info-circle me-2"></i>Tidak ada notifikasi upload ulang saat ini
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-4">
                    <i class="bi bi-list-check text-primary" style="font-size: 48px;"></i>
                    <h5 class="mt-3 mb-2">Daftar Pendaftar</h5>
                    <p class="text-muted mb-3">Lihat semua pendaftar yang perlu diverifikasi</p>
                    <a href="{{ route('verifikator.daftar') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right me-1"></i>Buka Daftar
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-4">
                    <i class="bi bi-journal-text text-success" style="font-size: 48px;"></i>
                    <h5 class="mt-3 mb-2">Log Verifikasi</h5>
                    <p class="text-muted mb-3">Riwayat semua aksi verifikasi yang dilakukan</p>
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-arrow-right me-1"></i>Lihat Log
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
