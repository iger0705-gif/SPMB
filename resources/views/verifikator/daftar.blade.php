@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-list-check me-2"></i>Daftar Pendaftar</h4>
        <p class="page-subtitle">Pendaftar yang perlu dan sudah diverifikasi</p>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="SUBMIT">Menunggu Verifikasi</option>
                        <option value="ADM_REJECT">Perlu Perbaikan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cari</label>
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

    <!-- Tabel Pendaftar -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th>Jurusan</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $p)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $p->no_pendaftaran }}</span></td>
                            <td><strong>{{ $p->nama_lengkap }}</strong></td>
                            <td>{{ $p->nama_jurusan }}</td>
                            <td>{{ date('d/m/Y', strtotime($p->tanggal_daftar)) }}</td>
                            <td>
                                @if($p->status == 'SUBMIT')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($p->status == 'ADM_REJECT')
                                <span class="badge bg-danger">Perlu Perbaikan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftar.detail', $p->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>Verifikasi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada pendaftar yang perlu diverifikasi
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
