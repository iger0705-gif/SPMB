@extends('layouts.public')

@section('title', 'Status Pendaftaran')

@section('content')
<section class="content-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Status Pendaftaran</h2>
            <p class="section-subtitle">Pantau perkembangan pendaftaran Anda secara real-time</p>
        </div>
        <div class="row">
        <div class="col-12">
            <div class="chart-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="chart-title mb-0"><i class="bi bi-clipboard-check me-2"></i>Status Pendaftaran - {{ $pendaftar->no_pendaftaran }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Informasi Pendaftar</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>Nama</strong></td>
                                    <td>{{ $pendaftar->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. Pendaftaran</strong></td>
                                    <td><span class="badge bg-primary">{{ $pendaftar->no_pendaftaran }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Jurusan</strong></td>
                                    <td>{{ $pendaftar->nama_jurusan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Daftar</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Status Saat Ini</h6>
                            <div class="text-center p-4">
                                @if($pendaftar->status == 'SUBMIT')
                                    <div class="mb-3">
                                        <span class="badge bg-warning" style="font-size: 1.5rem; padding: 1rem;">
                                            ⏳ Menunggu Verifikasi
                                        </span>
                                    </div>
                                    <p class="text-muted">Pendaftaran Anda sedang dalam proses verifikasi oleh panitia</p>
                                @elseif($pendaftar->status == 'ADM_PASS')
                                    <div class="mb-3">
                                        <span class="badge bg-success" style="font-size: 1.5rem; padding: 1rem;">
                                            ✅ Lulus Administrasi
                                        </span>
                                    </div>
                                    <p class="text-muted">Selamat! Anda telah lulus verifikasi administrasi</p>
                                @elseif($pendaftar->status == 'ADM_REJECT')
                                    <div class="mb-3">
                                        <span class="badge bg-danger" style="font-size: 1.5rem; padding: 1rem;">
                                            ❌ Ditolak
                                        </span>
                                    </div>
                                    <p class="text-muted">Mohon maaf, pendaftaran Anda tidak memenuhi syarat</p>
                                @elseif($pendaftar->status == 'PAID')
                                    <div class="mb-3">
                                        <span class="badge bg-info" style="font-size: 1.5rem; padding: 1rem;">
                                            💰 Terbayar
                                        </span>
                                    </div>
                                    <p class="text-muted">Pembayaran telah dikonfirmasi</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="chart-card mb-4">
                <h6 class="chart-title"><i class="bi bi-clock-history me-2"></i>Timeline Verifikasi</h6>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>✅ Pendaftaran Berhasil</h6>
                                <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @foreach($verifications as $ver)
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $ver->status == 'diterima' ? 'bg-success' : 'bg-danger' }}"></div>
                                <div class="timeline-content">
                                    <h6>
                                        @if($ver->status == 'diterima') ✅ @else ❌ @endif
                                        {{ ucfirst($ver->jenis_verifikasi) }} - {{ ucfirst($ver->status) }}
                                    </h6>
                                    <p class="text-muted mb-1">{{ \Carbon\Carbon::parse($ver->tanggal_verifikasi)->format('d/m/Y H:i') }}</p>
                                    @if($ver->catatan)
                                        <p class="mb-0"><small>Catatan: {{ $ver->catatan }}</small></p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Status Dokumen -->
            <div class="chart-card">
                <h6 class="chart-title"><i class="bi bi-folder-check me-2"></i>Status Dokumen</h6>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis Dokumen</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td>
                                            @if($doc->jenis_dokumen == 'ijazah') Ijazah / SKL
                                            @elseif($doc->jenis_dokumen == 'foto') Pas Foto
                                            @elseif($doc->jenis_dokumen == 'kk') Kartu Keluarga
                                            @elseif($doc->jenis_dokumen == 'akta_kelahiran') Akta Kelahiran
                                            @elseif($doc->jenis_dokumen == 'raport') Raport
                                            @endif
                                        </td>
                                        <td>
                                            @if($doc->status == 'pending')
                                                <span class="badge bg-warning">⏳ Menunggu</span>
                                            @elseif($doc->status == 'verified')
                                                <span class="badge bg-success">✅ Terverifikasi</span>
                                            @elseif($doc->status == 'rejected')
                                                <span class="badge bg-danger">❌ Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $doc->catatan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada dokumen yang diupload</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    padding-bottom: 20px;
}
.timeline-item:before {
    content: '';
    position: absolute;
    left: -23px;
    top: 10px;
    bottom: -10px;
    width: 2px;
    background: #dee2e6;
}
.timeline-item:last-child:before {
    display: none;
}
.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 3px solid white;
}
.timeline-content {
    padding-left: 10px;
}
</style>
@endpush
@endsection
