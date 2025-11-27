@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-smk">
                <div class="card-body">
                    <h2 class="mb-1">🔍 Dashboard Verifikasi</h2>
                    <p class="text-muted mb-0">Monitoring & Verifikasi Pendaftaran</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-smk border-start border-primary border-4">
                <div class="card-body">
                    <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Pendaftar</div>
                    <div class="h5 mb-0 fw-bold">{{ $totalPendaftar }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-smk border-start border-warning border-4">
                <div class="card-body">
                    <div class="text-xs fw-bold text-warning text-uppercase mb-1">Menunggu Verifikasi</div>
                    <div class="h5 mb-0 fw-bold">{{ $menungguVerifikasi }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-smk border-start border-success border-4">
                <div class="card-body">
                    <div class="text-xs fw-bold text-success text-uppercase mb-1">Lulus Verifikasi</div>
                    <div class="h5 mb-0 fw-bold">{{ $lulusVerifikasi }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-smk border-start border-danger border-4">
                <div class="card-body">
                    <div class="text-xs fw-bold text-danger text-uppercase mb-1">Ditolak</div>
                    <div class="h5 mb-0 fw-bold">{{ $ditolak }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-smk">
                <div class="card-body text-center">
                    <h6 class="text-warning">📄 Dokumen Pending</h6>
                    <h3 class="fw-bold">{{ $dokumenPending }}</h3>
                    <a href="{{ route('admin.verifikasi.dokumen.index') }}" class="btn btn-warning btn-sm">Verifikasi</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-smk">
                <div class="card-body text-center">
                    <h6 class="text-success">✅ Dokumen Verified</h6>
                    <h3 class="fw-bold">{{ $dokumenVerified }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-smk">
                <div class="card-body text-center">
                    <h6 class="text-danger">❌ Dokumen Rejected</h6>
                    <h3 class="fw-bold">{{ $dokumenRejected }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-smk">
                <div class="card-header bg-light">
                    <h6 class="m-0">⚡ Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.verifikasi.administrasi') }}" class="btn btn-primary w-100 mb-2">
                                📋 Verifikasi Administrasi
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.verifikasi.dokumen.index') }}" class="btn btn-warning w-100 mb-2">
                                📁 Verifikasi Dokumen
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.pendaftar') }}" class="btn btn-info w-100 mb-2">
                                👥 Daftar Pendaftar
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100 mb-2">
                                📊 Dashboard Utama
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Verifications -->
    <div class="row">
        <div class="col-12">
            <div class="card card-smk">
                <div class="card-header bg-light">
                    <h6 class="m-0">📜 Riwayat Verifikasi Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama</th>
                                    <th>Jenis Verifikasi</th>
                                    <th>Status</th>
                                    <th>Verifikator</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentVerifications as $ver)
                                    <tr>
                                        <td>{{ $ver->no_pendaftaran }}</td>
                                        <td>{{ $ver->nama_lengkap }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($ver->jenis_verifikasi) }}</span>
                                        </td>
                                        <td>
                                            @if($ver->status == 'diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif($ver->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($ver->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $ver->verifikator_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ver->tanggal_verifikasi)->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada riwayat verifikasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
