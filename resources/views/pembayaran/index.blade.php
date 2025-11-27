@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title" style="font-family: 'Poppins', sans-serif; font-weight: 700;"><i class="fas fa-credit-card me-2"></i>Pembayaran Pendaftaran</h4>
        <p class="page-subtitle" style="font-family: 'Inter', sans-serif;">Informasi biaya dan upload bukti pembayaran</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981;">
        <i class="fas fa-check-circle me-2 text-success"></i>
        <span style="font-family: 'Inter', sans-serif;">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger border-0 rounded-3 mb-4" style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #EF4444;">
        <i class="fas fa-exclamation-circle me-2 text-danger"></i>
        <span style="font-family: 'Inter', sans-serif;">{{ session('error') }}</span>
    </div>
    @endif

    <div class="row g-4">
        <!-- Panel 1: Informasi Biaya -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100 border-0" style="border-radius: 16px; border-left: 4px solid #3B82F6;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-info-circle me-2" style="color: #3B82F6;"></i>Informasi Biaya Pendaftaran
                    </h6>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="40%" class="text-muted" style="font-family: 'Inter', sans-serif;">Jurusan yang Dipilih</td>
                            <td class="fw-bold" style="font-family: 'Inter', sans-serif;">{{ $pendaftar->nama_jurusan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" style="font-family: 'Inter', sans-serif;">Gelombang</td>
                            <td class="fw-bold" style="font-family: 'Inter', sans-serif;">{{ $pendaftar->nama_gelombang }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" style="font-family: 'Inter', sans-serif;">No. Pendaftaran</td>
                            <td><span class="badge rounded-pill px-3 py-2" style="background: rgba(107, 114, 128, 0.1); color: #374151; font-family: 'Inter', sans-serif; font-weight: 500;">{{ $pendaftar->no_pendaftaran }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr style="border-color: #E5E7EB;"></td>
                        </tr>
                        <tr>
                            <td class="text-muted" style="font-family: 'Inter', sans-serif; font-size: 1.1rem;">Total Biaya Pendaftaran</td>
                            <td class="fw-bold text-primary" style="font-family: 'Poppins', sans-serif; font-size: 1.5rem;">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Panel 2: Instruksi Pembayaran -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100 border-0" style="border-radius: 16px; border-left: 4px solid #10B981;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-university me-2" style="color: #10B981;"></i>Instruksi Pembayaran
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 rounded-3 mb-3" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6;">
                        <strong style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-star me-1"></i>Metode Transfer Bank (Recommended)
                        </strong>
                    </div>
                    <p class="mb-3" style="font-family: 'Inter', sans-serif;"><strong>Silakan transfer ke rekening berikut:</strong></p>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="35%" style="font-family: 'Inter', sans-serif;">Bank</td>
                            <td style="font-family: 'Inter', sans-serif;"><strong>BCA</strong></td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Inter', sans-serif;">No. Rekening</td>
                            <td style="font-family: 'Inter', sans-serif;"><strong>123-456-7890</strong></td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Inter', sans-serif;">Atas Nama</td>
                            <td style="font-family: 'Inter', sans-serif;"><strong>Panitia PPDB SMK</strong></td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Inter', sans-serif;">Jumlah</td>
                            <td style="font-family: 'Inter', sans-serif;"><strong>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Inter', sans-serif;">Kode Unik</td>
                            <td style="font-family: 'Inter', sans-serif;"><strong class="text-danger">{{ substr($pendaftar->no_pendaftaran, -3) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr style="border-color: #E5E7EB;"></td>
                        </tr>
                        <tr>
                            <td class="text-primary" style="font-family: 'Inter', sans-serif; font-size: 1.1rem;">Total Transfer</td>
                            <td class="text-primary" style="font-family: 'Poppins', sans-serif; font-size: 1.3rem;"><strong>Rp {{ number_format($pembayaran->jumlah + (int)substr($pendaftar->no_pendaftaran, -3), 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                    <div class="alert alert-warning border-0 rounded-3 mt-3 mb-0" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                        <small style="font-family: 'Inter', sans-serif;">
                            <i class="fas fa-exclamation-triangle me-1"></i>Pastikan transfer sesuai dengan total + kode unik untuk mempercepat verifikasi
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 3: Upload Bukti Bayar -->
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 16px; border-left: 4px solid #F59E0B;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-cloud-upload-alt me-2" style="color: #F59E0B;"></i>Upload Bukti Pembayaran
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if($pembayaran->status == 'BELUM_BAYAR')
                    <div class="alert alert-warning border-0 rounded-3 mb-4" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                        <i class="fas fa-exclamation-circle me-2 text-warning"></i>
                        <strong style="font-family: 'Poppins', sans-serif;">Status Pembayaran: BELUM BAYAR</strong>
                    </div>
                    <form action="{{ route('pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Pilih File Bukti Transfer</label>
                            <input type="file" name="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required style="font-family: 'Inter', sans-serif;">
                            <small class="text-muted" style="font-family: 'Inter', sans-serif;">Format: JPG, PNG, PDF (Maks. 2MB)</small>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 py-2" style="font-family: 'Inter', sans-serif; font-weight: 500; border-radius: 8px; background: #3B82F6; border: none;">
                            <i class="fas fa-cloud-upload-alt me-2"></i>UPLOAD BUKTI BAYAR
                        </button>
                    </form>

                    @elseif($pembayaran->status == 'MENUNGGU_VERIFIKASI')
                    <div class="alert alert-info border-0 rounded-3 mb-4" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6;">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        <strong style="font-family: 'Poppins', sans-serif;">Status Pembayaran: MENUNGGU VERIFIKASI</strong>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="mb-2" style="font-family: 'Inter', sans-serif;"><strong>Bukti bayar telah diupload pada:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_upload)->format('d/m/Y H:i') }}</p>
                            <p class="mb-3" style="font-family: 'Inter', sans-serif;"><strong>File:</strong> {{ basename($pembayaran->bukti_bayar) }}</p>
                            <a href="{{ asset($pembayaran->bukti_bayar) }}" target="_blank" class="btn btn-outline-primary me-2" style="font-family: 'Inter', sans-serif; border-radius: 6px;">
                                <i class="fas fa-eye me-1"></i>Lihat Bukti
                            </a>
                            <form action="{{ route('pembayaran.hapus') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin hapus dan upload ulang?')" style="font-family: 'Inter', sans-serif; border-radius: 6px;">
                                    <i class="fas fa-trash me-1"></i>Hapus & Upload Ulang
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="alert alert-warning border-0 rounded-3 mb-0" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                                <small style="font-family: 'Inter', sans-serif;">
                                    <i class="fas fa-info-circle me-1"></i>Tim keuangan akan memverifikasi dalam 1x24 jam
                                </small>
                            </div>
                        </div>
                    </div>

                    @elseif($pembayaran->status == 'TERBAYAR')
                    <div class="alert alert-success border-0 rounded-3 mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981;">
                        <i class="fas fa-check-circle me-2 text-success"></i>
                        <strong style="font-family: 'Poppins', sans-serif;">Status Pembayaran: TERBAYAR / LUNAS</strong>
                    </div>
                    <p class="mb-2" style="font-family: 'Inter', sans-serif;"><strong>Diverifikasi pada:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_verifikasi)->format('d/m/Y H:i') }}</p>
                    <p class="mb-3" style="font-family: 'Inter', sans-serif;"><strong>Bukti bayar:</strong> <a href="{{ asset($pembayaran->bukti_bayar) }}" target="_blank" class="text-primary">Lihat File</a></p>
                    <div class="alert alert-info border-0 rounded-3 mt-3" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6;">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        <span style="font-family: 'Inter', sans-serif;">Pembayaran Anda telah dikonfirmasi. Silakan lanjutkan ke tahap berikutnya.</span>
                    </div>

                    @elseif($pembayaran->status == 'DITOLAK')
                    <div class="alert alert-danger border-0 rounded-3 mb-4" style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #EF4444;">
                        <i class="fas fa-times-circle me-2 text-danger"></i>
                        <strong style="font-family: 'Poppins', sans-serif;">Status Pembayaran: DITOLAK</strong>
                    </div>
                    <div class="alert alert-warning border-0 rounded-3 mb-4" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                        <strong style="font-family: 'Poppins', sans-serif;">Alasan Penolakan:</strong><br>
                        <span style="font-family: 'Inter', sans-serif;">{{ $pembayaran->catatan ?? 'Tidak ada catatan' }}</span>
                    </div>
                    <p class="mb-3" style="font-family: 'Inter', sans-serif;">Silakan upload ulang bukti pembayaran yang sesuai:</p>
                    <form action="{{ route('pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Pilih File Bukti Transfer</label>
                            <input type="file" name="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required style="font-family: 'Inter', sans-serif;">
                            <small class="text-muted" style="font-family: 'Inter', sans-serif;">Format: JPG, PNG, PDF (Maks. 2MB)</small>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 py-2" style="font-family: 'Inter', sans-serif; font-weight: 500; border-radius: 8px; background: #3B82F6; border: none;">
                            <i class="fas fa-cloud-upload-alt me-2"></i>UPLOAD ULANG BUKTI BAYAR
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection