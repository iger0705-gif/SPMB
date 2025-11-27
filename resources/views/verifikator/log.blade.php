@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title"><i class="bi bi-journal-text me-2"></i>Log Verifikasi</h4>
        <p class="page-subtitle">Riwayat semua aksi verifikasi yang dilakukan</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-calendar me-1"></i>Tanggal</th>
                            <th><i class="bi bi-hash me-1"></i>No. Pendaftaran</th>
                            <th><i class="bi bi-person me-1"></i>Nama Pendaftar</th>
                            <th><i class="bi bi-arrow-left-right me-1"></i>Status</th>
                            <th><i class="bi bi-chat-left-text me-1"></i>Catatan</th>
                            <th><i class="bi bi-person-badge me-1"></i>Verifikator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</small></td>
                            <td><span class="badge bg-secondary">{{ $log->no_pendaftaran }}</span></td>
                            <td><strong>{{ $log->nama_lengkap }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($log->status_sebelum == 'SUBMIT')
                                    <span class="badge bg-warning">Menunggu</span>
                                    @elseif($log->status_sebelum == 'ADM_PASS')
                                    <span class="badge bg-success">Lulus</span>
                                    @elseif($log->status_sebelum == 'ADM_REJECT')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                    
                                    <i class="bi bi-arrow-right"></i>
                                    
                                    @if($log->status_sesudah == 'SUBMIT')
                                    <span class="badge bg-warning">Menunggu</span>
                                    @elseif($log->status_sesudah == 'ADM_PASS')
                                    <span class="badge bg-success">Lulus</span>
                                    @elseif($log->status_sesudah == 'ADM_REJECT')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </div>
                            </td>
                            <td><small>{{ $log->catatan ?? '-' }}</small></td>
                            <td><small class="text-muted">{{ $log->verifikator_name }}</small></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada log verifikasi</p>
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
