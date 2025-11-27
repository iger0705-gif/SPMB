@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title mb-2"><i class="bi bi-person-badge me-2"></i>Detail Pendaftar</h4>
            <p class="page-subtitle mb-0">{{ $pendaftar->no_pendaftaran }}</p>
        </div>
        <div class="d-flex gap-2">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-0 py-2">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            <a href="{{ route('admin.pendaftar') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Status Card -->
    <div class="card shadow-sm mb-3" style="border-left: 4px solid #3b82f6;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-3 text-center border-end">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2" 
                         style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                        <i class="bi bi-person" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h6 class="mb-1">{{ $dataSiswa->nama_lengkap ?? 'Belum diisi' }}</h6>
                    <small class="text-muted">{{ $pendaftar->no_pendaftaran }}</small>
                </div>
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; background: rgba(139, 92, 246, 0.1);">
                                    <i class="bi bi-mortarboard" style="font-size: 22px; color: #8b5cf6;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Jurusan Pilihan</small>
                                    <strong style="font-size: 14px;">{{ $pendaftar->nama_jurusan }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; background: rgba(16, 185, 129, 0.1);">
                                    <i class="bi bi-calendar-check" style="font-size: 22px; color: #10b981;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Tanggal Daftar</small>
                                    <strong style="font-size: 14px;">{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; background: rgba(245, 158, 11, 0.1);">
                                    <i class="bi bi-flag" style="font-size: 22px; color: #f59e0b;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 11px;">Status</small>
                                    @if($pendaftar->status == 'SUBMIT')
                                    <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                    @elseif($pendaftar->status == 'ADM_PASS')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Lulus</span>
                                    @elseif($pendaftar->status == 'ADM_REJECT')
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                    @elseif($pendaftar->status == 'PAID')
                                    <span class="badge bg-info"><i class="bi bi-credit-card me-1"></i>Terbayar</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Verifikasi -->
    @if(Auth::user()->isAdmin() || Auth::user()->isVerifikator())
    <div class="card shadow-sm mb-3" style="border-left: 4px solid #f59e0b;">
        <div class="card-header bg-white border-bottom py-2">
            <h6 class="mb-0 fw-bold"><i class="bi bi-clipboard-check me-2" style="color: #f59e0b;"></i>Panel Verifikasi Administrasi</h6>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('admin.verifikasi.administrasi.update', $pendaftar->id) }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold mb-1" style="font-size: 13px;"><i class="bi bi-flag me-1"></i>Status Verifikasi</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="ADM_PASS" {{ $pendaftar->status == 'ADM_PASS' ? 'selected' : '' }}>✓ Lulus Administrasi</option>
                            <option value="ADM_REJECT" {{ $pendaftar->status == 'ADM_REJECT' ? 'selected' : '' }}>✗ Tidak Lulus / Perlu Perbaikan</option>
                            <option value="SUBMIT" {{ $pendaftar->status == 'SUBMIT' ? 'selected' : '' }}>⏱ Menunggu Verifikasi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold mb-1" style="font-size: 13px;"><i class="bi bi-chat-left-text me-1"></i>Catatan Verifikasi</label>
                        <textarea name="catatan" class="form-control form-control-sm" rows="2" placeholder="Berikan catatan untuk pendaftar..."></textarea>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-check-circle me-1"></i>Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="row g-3">
        <!-- Data Siswa -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="mb-0 fw-bold" style="font-size: 14px;"><i class="bi bi-person-circle me-2" style="color: #3b82f6;"></i>Data Siswa</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-sm table-borderless mb-0" style="font-size: 12px;">
                        <tr><td width="45%" class="text-muted py-1">Nama Lengkap</td><td class="fw-semibold py-1">{{ $dataSiswa->nama_lengkap ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">NISN</td><td class="fw-semibold py-1">{{ $dataSiswa->nisn ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">NIK</td><td class="fw-semibold py-1">{{ $dataSiswa->nik ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">TTL</td><td class="fw-semibold py-1">{{ $dataSiswa->tempat_lahir ?? '-' }}, {{ isset($dataSiswa->tanggal_lahir) ? \Carbon\Carbon::parse($dataSiswa->tanggal_lahir)->format('d/m/Y') : '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Jenis Kelamin</td><td class="fw-semibold py-1">{{ $dataSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($dataSiswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td></tr>
                        <tr><td class="text-muted py-1">Agama</td><td class="fw-semibold py-1">{{ $dataSiswa->agama ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Alamat</td><td class="fw-semibold py-1">{{ $dataSiswa->alamat ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">No. HP</td><td class="fw-semibold py-1">{{ $dataSiswa->no_hp ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Email</td><td class="fw-semibold py-1">{{ $dataSiswa->email ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="mb-0 fw-bold" style="font-size: 14px;"><i class="bi bi-people-fill me-2" style="color: #10b981;"></i>Data Orang Tua</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-sm table-borderless mb-0" style="font-size: 12px;">
                        <tr><td width="45%" class="text-muted py-1">Nama Ayah</td><td class="fw-semibold py-1">{{ $dataOrtu->nama_ayah ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Pekerjaan Ayah</td><td class="fw-semibold py-1">{{ $dataOrtu->pekerjaan_ayah ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Nama Ibu</td><td class="fw-semibold py-1">{{ $dataOrtu->nama_ibu ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Pekerjaan Ibu</td><td class="fw-semibold py-1">{{ $dataOrtu->pekerjaan_ibu ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">No. HP Ortu</td><td class="fw-semibold py-1">{{ $dataOrtu->hp_ayah ?? '-' }}</td></tr>
                    </table>
                    <hr class="my-2">
                    <h6 class="mb-2 fw-bold" style="font-size: 13px;"><i class="bi bi-building me-1" style="color: #f59e0b;"></i>Sekolah Asal</h6>
                    <table class="table table-sm table-borderless mb-0" style="font-size: 12px;">
                        <tr><td width="45%" class="text-muted py-1">Asal Sekolah</td><td class="fw-semibold py-1">{{ $dataSekolah->nama_sekolah ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Kabupaten</td><td class="fw-semibold py-1">{{ $dataSekolah->kabupaten ?? '-' }}</td></tr>
                        <tr><td class="text-muted py-1">Nilai Rata-rata</td><td class="fw-semibold py-1">{{ $dataSekolah->nilai_rata ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Dokumen Upload -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-2">
                    <h6 class="mb-0 fw-bold" style="font-size: 14px;"><i class="bi bi-file-earmark-text me-2" style="color: #8b5cf6;"></i>Dokumen Upload</h6>
                </div>
                <div class="card-body p-2">
                    @php
                        $documents = DB::table('documents')->where('pendaftar_id', $pendaftar->id)->get();
                    @endphp
                    @if($documents->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($documents as $doc)
                            <div class="list-group-item px-0 py-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <i class="bi bi-file-earmark-pdf text-danger me-2" style="font-size: 18px;"></i>
                                        <div style="font-size: 12px;">
                                            <div class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $doc->jenis_dokumen)) }}</div>
                                            <small class="text-muted" style="font-size: 10px;">{{ Str::limit(basename($doc->path_file), 25) }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        @if($doc->status == 'pending')
                                        <span class="badge bg-warning" style="font-size: 9px;"><i class="bi bi-clock"></i></span>
                                        @elseif($doc->status == 'verified')
                                        <span class="badge bg-success" style="font-size: 9px;"><i class="bi bi-check"></i></span>
                                        @elseif($doc->status == 'rejected')
                                        <span class="badge bg-danger" style="font-size: 9px;"><i class="bi bi-x"></i></span>
                                        @endif
                                        <a href="{{ asset($doc->path_file) }}" target="_blank" class="btn btn-sm btn-primary" style="padding: 2px 6px; font-size: 10px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0" style="font-size: 12px; padding: 8px;">
                            <i class="bi bi-exclamation-triangle me-1"></i>Belum ada dokumen
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
