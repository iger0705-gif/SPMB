@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-people-fill me-2"></i>Monitoring Pendaftar</h4>
        <p class="page-subtitle">Daftar semua pendaftar PPDB dengan filter dan pencarian</p>
    </div>

    <!-- Filter & Search -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-funnel me-1"></i>Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="SUBMIT">Menunggu Verifikasi</option>
                        <option value="ADM_PASS">Lulus Administrasi</option>
                        <option value="ADM_REJECT">Ditolak</option>
                        <option value="PAID">Terbayar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-mortarboard me-1"></i>Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-search me-1"></i>Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama / No. Pendaftaran">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #3b82f6 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 48px; height: 48px; background: rgba(59, 130, 246, 0.1);">
                                <i class="bi bi-people" style="font-size: 24px; color: #3b82f6;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Total Pendaftar</div>
                            <div class="h4 mb-0 fw-bold">{{ $pendaftar->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #f59e0b !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 48px; height: 48px; background: rgba(245, 158, 11, 0.1);">
                                <i class="bi bi-clock" style="font-size: 24px; color: #f59e0b;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Menunggu</div>
                            <div class="h4 mb-0 fw-bold">{{ $pendaftar->where('status', 'SUBMIT')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #10b981 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.1);">
                                <i class="bi bi-check-circle" style="font-size: 24px; color: #10b981;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Lulus Adm</div>
                            <div class="h4 mb-0 fw-bold">{{ $pendaftar->where('status', 'ADM_PASS')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #8b5cf6 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1);">
                                <i class="bi bi-credit-card" style="font-size: 24px; color: #8b5cf6;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Terbayar</div>
                            <div class="h4 mb-0 fw-bold">{{ $pendaftar->where('status', 'PAID')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pendaftar -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>No. Pendaftaran</th>
                            <th><i class="bi bi-person me-1"></i>Nama Lengkap</th>
                            <th><i class="bi bi-mortarboard me-1"></i>Jurusan</th>
                            <th><i class="bi bi-calendar me-1"></i>Tanggal Daftar</th>
                            <th><i class="bi bi-flag me-1"></i>Status</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $p)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $p->no_pendaftaran }}</span></td>
                            <td><strong>{{ $p->nama_lengkap }}</strong></td>
                            <td><span class="badge" style="background: #8b5cf6;">{{ $p->nama_jurusan }}</span></td>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d/m/Y H:i') }}</small></td>
                            <td>
                                @if($p->status == 'SUBMIT')
                                <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                @elseif($p->status == 'ADM_PASS')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Lulus</span>
                                @elseif($p->status == 'ADM_REJECT')
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                @elseif($p->status == 'PAID')
                                <span class="badge bg-info"><i class="bi bi-credit-card me-1"></i>Terbayar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftar.detail', $p->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada data pendaftar</p>
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
