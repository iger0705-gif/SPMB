@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-file-earmark-check me-2"></i>Verifikasi Dokumen</h4>
        <p class="page-subtitle">Verifikasi dokumen yang diupload oleh pendaftar</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>No. Pendaftaran</th>
                            <th><i class="bi bi-person me-1"></i>Nama</th>
                            <th><i class="bi bi-mortarboard me-1"></i>Jurusan</th>
                            <th><i class="bi bi-file-earmark me-1"></i>Dokumen</th>
                            <th><i class="bi bi-flag me-1"></i>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $doc->no_pendaftaran }}</span></td>
                            <td><strong>{{ $doc->nama_lengkap }}</strong></td>
                            <td><span class="badge" style="background: #8b5cf6;">{{ $doc->nama_jurusan }}</span></td>
                            <td>
                                @if($doc->jenis_dokumen == 'ijazah')
                                <span class="badge bg-info"><i class="bi bi-file-earmark-text me-1"></i>Ijazah / SKL</span>
                                @elseif($doc->jenis_dokumen == 'foto')
                                <span class="badge bg-primary"><i class="bi bi-image me-1"></i>Pas Foto</span>
                                @elseif($doc->jenis_dokumen == 'kk')
                                <span class="badge bg-success"><i class="bi bi-people me-1"></i>Kartu Keluarga</span>
                                @elseif($doc->jenis_dokumen == 'akta_kelahiran')
                                <span class="badge bg-warning"><i class="bi bi-file-earmark me-1"></i>Akta Kelahiran</span>
                                @elseif($doc->jenis_dokumen == 'raport')
                                <span class="badge bg-danger"><i class="bi bi-journal me-1"></i>Raport</span>
                                @endif
                            </td>
                            <td>
                                @if($doc->status == 'pending')
                                <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                @elseif($doc->status == 'verified')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Terverifikasi</span>
                                @elseif($doc->status == 'rejected')
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ asset($doc->path_file) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($doc->status == 'pending')
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal{{ $doc->id }}">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Verifikasi -->
                        <div class="modal fade" id="verifikasiModal{{ $doc->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.verifikasi.dokumen', $doc->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Verifikasi Dokumen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info">
                                                <strong>{{ $doc->nama_lengkap }}</strong><br>
                                                <small>{{ $doc->no_pendaftaran }}</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold"><i class="bi bi-flag me-1"></i>Status Verifikasi</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="verified">✓ Terima - Dokumen Valid</option>
                                                    <option value="rejected">✗ Tolak - Dokumen Tidak Valid</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold"><i class="bi bi-chat-left-text me-1"></i>Catatan</label>
                                                <textarea name="catatan" class="form-control" rows="3" placeholder="Berikan catatan jika diperlukan..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle me-1"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-1"></i>Simpan Verifikasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada dokumen yang perlu diverifikasi</p>
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
