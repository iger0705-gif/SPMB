@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .page-subtitle { font-family: 'Inter', sans-serif; }
    .table { font-family: 'Inter', sans-serif; font-size: 13px; }
    .modal-title { font-family: 'Poppins', sans-serif; font-weight: 600; }
    .form-label { font-family: 'Inter', sans-serif; font-weight: 600; font-size: 13px; }
    .btn { font-family: 'Inter', sans-serif; font-weight: 500; }
    .card { border-radius: 12px; border: 1px solid #e2e8f0; }
    .modal-content { border-radius: 12px; }
    .form-check-label { font-family: 'Inter', sans-serif; font-size: 14px; }
</style>
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-check-circle me-2"></i>Verifikasi Pembayaran</h4>
        <p class="page-subtitle">Daftar pembayaran yang perlu diverifikasi</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="MENUNGGU_VERIFIKASI">Menunggu Verifikasi</option>
                        <option value="TERBAYAR">Terbayar</option>
                        <option value="DITOLAK">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-4">
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

    <!-- Tabel Pembayaran -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Calon Siswa</th>
                            <th>Jurusan</th>
                            <th>Jumlah</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaran as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-secondary">{{ $p->no_pendaftaran }}</span></td>
                            <td><strong>{{ $p->nama_lengkap }}</strong></td>
                            <td>{{ $p->nama_jurusan }}</td>
                            <td><strong class="text-success">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</strong></td>
                            <td><small class="text-muted">{{ $p->tanggal_upload ? \Carbon\Carbon::parse($p->tanggal_upload)->format('d/m/Y H:i') : '-' }}</small></td>
                            <td>
                                @if($p->status == 'BELUM_BAYAR')
                                <span class="badge bg-secondary">Belum Bayar</span>
                                @elseif($p->status == 'MENUNGGU_VERIFIKASI')
                                <span class="badge bg-warning">Menunggu</span>
                                @elseif($p->status == 'TERBAYAR')
                                <span class="badge bg-success">Terbayar</span>
                                @elseif($p->status == 'DITOLAK')
                                <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($p->bukti_bayar)
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalVerifikasi{{ $p->id }}">
                                    <i class="bi bi-eye me-1"></i>Verifikasi
                                </button>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Verifikasi -->
                        @if($p->bukti_bayar)
                        <div class="modal fade" id="modalVerifikasi{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2 text-primary"></i>Verifikasi Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-4 mb-4">
                                            <!-- Data Pendaftar -->
                                            <div class="col-md-5">
                                                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                    <div class="card-body p-4">
                                                        <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;"><i class="bi bi-person-circle me-2"></i>Data Pendaftar</h6>
                                                        <div class="mb-3">
                                                            <small class="opacity-75 d-block mb-1">Nama Lengkap</small>
                                                            <h5 class="mb-0 fw-bold">{{ $p->nama_lengkap }}</h5>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <small class="opacity-75 d-block mb-1">No. Pendaftaran</small>
                                                                <div class="badge bg-white text-dark px-3 py-2">{{ $p->no_pendaftaran }}</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="opacity-75 d-block mb-1">Jurusan</small>
                                                                <strong>{{ $p->nama_jurusan }}</strong>
                                                            </div>
                                                        </div>
                                                        <hr class="my-3 opacity-25">
                                                        <div>
                                                            <small class="opacity-75 d-block mb-1">Nominal Seharusnya</small>
                                                            <h3 class="mb-0 fw-bold">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Bukti Pembayaran -->
                                            <div class="col-md-7">
                                                <div class="card border-0 shadow-sm h-100">
                                                    <div class="card-body p-4">
                                                        <h6 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif;"><i class="bi bi-image me-2 text-primary"></i>Bukti Pembayaran</h6>
                                                        <div class="text-center">
                                                            @if(pathinfo($p->bukti_bayar, PATHINFO_EXTENSION) == 'pdf')
                                                            <div class="p-5 bg-light rounded">
                                                                <i class="bi bi-file-pdf text-danger" style="font-size: 80px;"></i>
                                                                <p class="mt-3 mb-0 text-muted">File PDF</p>
                                                            </div>
                                                            @else
                                                            <img src="{{ asset($p->bukti_bayar) }}" class="img-fluid rounded shadow" style="max-height: 350px; border: 3px solid #e2e8f0;">
                                                            @endif
                                                            <div class="mt-3 d-flex gap-2 justify-content-center">
                                                                <a href="{{ asset($p->bukti_bayar) }}" target="_blank" class="btn btn-outline-primary">
                                                                    <i class="bi bi-eye me-2"></i>Lihat Full
                                                                </a>
                                                                <a href="{{ asset($p->bukti_bayar) }}" download="bukti_bayar_{{ $p->no_pendaftaran }}.{{ pathinfo($p->bukti_bayar, PATHINFO_EXTENSION) }}" class="btn btn-success">
                                                                    <i class="bi bi-download me-2"></i>Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card border-0 shadow-sm" style="background: #f8fafc;">
                                            <div class="card-body p-4">
                                                <form action="{{ route('keuangan.verifikasi.update', $p->id) }}" method="POST">
                                                    @csrf
                                                    <h6 class="fw-bold mb-4" style="font-family: 'Poppins', sans-serif;"><i class="bi bi-clipboard-check me-2 text-primary"></i>Aksi Verifikasi</h6>
                                                    
                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <label class="form-label"><i class="bi bi-flag-fill me-2"></i>Status Verifikasi</label>
                                                            <div class="card border-0 shadow-sm mb-3">
                                                                <div class="card-body p-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="status" value="TERBAYAR" id="terbayar{{ $p->id }}" required>
                                                                        <label class="form-check-label w-100" for="terbayar{{ $p->id }}" style="cursor: pointer;">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                                                                    <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <strong class="d-block">TERBAYAR</strong>
                                                                                    <small class="text-muted">Pembayaran valid dan sesuai</small>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card border-0 shadow-sm">
                                                                <div class="card-body p-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="status" value="DITOLAK" id="ditolak{{ $p->id }}">
                                                                        <label class="form-check-label w-100" for="ditolak{{ $p->id }}" style="cursor: pointer;">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-3">
                                                                                    <i class="bi bi-x-circle-fill text-danger" style="font-size: 24px;"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <strong class="d-block">DITOLAK</strong>
                                                                                    <small class="text-muted">Pembayaran tidak valid</small>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <label class="form-label"><i class="bi bi-chat-left-text-fill me-2"></i>Catatan Verifikasi</label>
                                                            <textarea name="catatan" class="form-control" rows="7" placeholder="Berikan catatan jika pembayaran ditolak...&#10;Contoh: Nominal transfer tidak sesuai" style="resize: none;"></textarea>
                                                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Catatan akan dikirim ke calon siswa</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <hr class="my-4">
                                                    
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="min-width: 120px;">
                                                            <i class="bi bi-x-lg me-2"></i>Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-primary px-4" style="min-width: 200px;">
                                                            <i class="bi bi-check-circle-fill me-2"></i>PROSES VERIFIKASI
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada data pembayaran</p>
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
