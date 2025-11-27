@extends('layouts.dashboard')

@section('title', 'Upload Dokumen')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title" style="font-family: 'Poppins', sans-serif; font-weight: 700;"><i class="fas fa-file-upload me-2"></i>Upload Berkas Pendaftaran</h4>
        <p class="page-subtitle" style="font-family: 'Inter', sans-serif;">Upload semua dokumen yang diperlukan untuk verifikasi</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Alert Messages -->
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

            <!-- Informasi Dokumen -->
            <div class="card shadow-sm mb-4 border-0" style="border-radius: 16px;">
                <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #3B82F6, #1E40AF); border-radius: 16px 16px 0 0;">
                    <h6 class="mb-0 text-white fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-list-check me-2"></i>Dokumen yang Harus Diupload
                    </h6>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0" style="font-family: 'Inter', sans-serif;">
                        <li class="mb-2"><i class="fas fa-file-pdf me-2 text-danger"></i>Ijazah / Surat Keterangan Lulus (PDF/JPG, max 2MB)</li>
                        <li class="mb-2"><i class="fas fa-image me-2 text-primary"></i>Pas Foto 3x4 (JPG/PNG, max 2MB)</li>
                        <li class="mb-2"><i class="fas fa-id-card me-2 text-success"></i>Kartu Keluarga (PDF/JPG, max 2MB)</li>
                        <li class="mb-2"><i class="fas fa-certificate me-2 text-warning"></i>Akta Kelahiran (PDF/JPG, max 2MB)</li>
                        <li class="mb-0"><i class="fas fa-book me-2 text-info"></i>Raport Semester Terakhir (PDF/JPG, max 2MB)</li>
                    </ul>
                </div>
            </div>

            <!-- Status Info -->
            @if($pendaftar->status == 'DRAFT')
                <div class="alert alert-info border-0 rounded-3 mb-4" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6;">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    <strong style="font-family: 'Poppins', sans-serif;">Silakan upload semua dokumen yang diperlukan</strong>
                    <p class="mb-0 mt-2" style="font-family: 'Inter', sans-serif;">Setelah semua dokumen diupload, Anda bisa submit untuk verifikasi.</p>
                </div>
            @elseif($pendaftar->status == 'SUBMIT')
                <div class="alert alert-success border-0 rounded-3 mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981;">
                    <i class="fas fa-check-circle me-2 text-success"></i>
                    <strong style="font-family: 'Poppins', sans-serif;">Dokumen sudah disubmit untuk verifikasi!</strong>
                    <p class="mb-0 mt-2" style="font-family: 'Inter', sans-serif;">Anda masih bisa mengupload atau mengganti dokumen jika diperlukan.</p>
                </div>
            @elseif($pendaftar->status == 'ADM_PASS')
                <div class="alert alert-success border-0 rounded-3 mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981;">
                    <i class="fas fa-check-circle me-2 text-success"></i>
                    <strong style="font-family: 'Poppins', sans-serif;">Dokumen sudah diverifikasi dan diterima!</strong>
                </div>
            @elseif($pendaftar->status == 'ADM_REJECT')
                <div class="alert alert-warning border-0 rounded-3 mb-4" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                    <strong style="font-family: 'Poppins', sans-serif;">Dokumen perlu diperbaiki!</strong>
                    <p class="mb-0 mt-2" style="font-family: 'Inter', sans-serif;">Silakan upload ulang dokumen yang diperlukan.</p>
                </div>
            @endif

            @if($documents->where('status', 'rejected')->count() > 0)
                <div class="alert alert-warning border-0 rounded-3 mb-4" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                    <strong style="font-family: 'Poppins', sans-serif;">Ada dokumen yang ditolak!</strong> 
                    <span style="font-family: 'Inter', sans-serif;">Silakan upload ulang dokumen yang ditolak.</span>
                </div>
            @endif

            <!-- Form Upload -->
            <div class="card shadow-sm mb-4 border-0" style="border-radius: 16px; border-left: 4px solid #10B981;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-cloud-upload-alt me-2" style="color: #10B981;"></i>Upload Dokumen
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('dokumen.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Jenis Dokumen</label>
                                <select name="jenis_dokumen" class="form-select" required style="font-family: 'Inter', sans-serif;">
                                    <option value="">Pilih Jenis Dokumen</option>
                                    <option value="ijazah">Ijazah / SKL</option>
                                    <option value="foto">Pas Foto 3x4</option>
                                    <option value="kk">Kartu Keluarga</option>
                                    <option value="akta_kelahiran">Akta Kelahiran</option>
                                    <option value="raport">Raport</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Pilih File</label>
                                <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required style="font-family: 'Inter', sans-serif;">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 py-2" style="font-family: 'Inter', sans-serif; font-weight: 500; border-radius: 8px; background: #10B981; border: none;">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>Upload
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Dokumen -->
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-folder-open me-2"></i>Dokumen yang Sudah Diupload
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: #F9FAFB;">
                                <tr>
                                    <th style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem;">Jenis Dokumen</th>
                                    <th style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem;">Nama File</th>
                                    <th style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem;">Ukuran</th>
                                    <th style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem;">Status</th>
                                    <th style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 0.9rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td style="font-family: 'Inter', sans-serif;">
                                            @if($doc->jenis_dokumen == 'ijazah') Ijazah / SKL
                                            @elseif($doc->jenis_dokumen == 'foto') Pas Foto
                                            @elseif($doc->jenis_dokumen == 'kk') Kartu Keluarga
                                            @elseif($doc->jenis_dokumen == 'akta_kelahiran') Akta Kelahiran
                                            @elseif($doc->jenis_dokumen == 'raport') Raport
                                            @endif
                                        </td>
                                        <td style="font-family: 'Inter', sans-serif;">{{ $doc->nama_file }}</td>
                                        <td style="font-family: 'Inter', sans-serif;">{{ number_format($doc->ukuran_file / 1024, 2) }} KB</td>
                                        <td>
                                            @if($doc->status == 'pending')
                                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(245, 158, 11, 0.1); color: #D97706; font-family: 'Inter', sans-serif; font-weight: 500;">Menunggu Verifikasi</span>
                                            @elseif($doc->status == 'verified')
                                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(16, 185, 129, 0.1); color: #059669; font-family: 'Inter', sans-serif; font-weight: 500;">Terverifikasi</span>
                                            @elseif($doc->status == 'rejected')
                                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(239, 68, 68, 0.1); color: #DC2626; font-family: 'Inter', sans-serif; font-weight: 500;">Ditolak</span>
                                            @endif
                                            @if($doc->catatan)
                                                <br><small class="text-muted" style="font-family: 'Inter', sans-serif;">{{ $doc->catatan }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ asset($doc->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1" style="font-family: 'Inter', sans-serif; border-radius: 6px;">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                            @if($doc->status != 'verified' && $pendaftar->status != 'SUBMIT')
                                                <form action="{{ route('dokumen.delete', $doc->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus dokumen ini?')" style="font-family: 'Inter', sans-serif; border-radius: 6px;">
                                                        <i class="fas fa-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4" style="font-family: 'Inter', sans-serif; color: #6B7280;">
                                            <i class="fas fa-folder-open fa-2x mb-3 d-block text-muted"></i>
                                            Belum ada dokumen yang diupload
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(count($missingDocs) > 0)
                        <div class="alert alert-warning border-0 rounded-3 mt-4" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B;">
                            <strong style="font-family: 'Poppins', sans-serif;">Dokumen yang belum diupload:</strong>
                            <ul class="mb-0 mt-2" style="font-family: 'Inter', sans-serif;">
                                @foreach($missingDocs as $missing)
                                    <li>
                                        @if($missing == 'ijazah') Ijazah / SKL
                                        @elseif($missing == 'foto') Pas Foto
                                        @elseif($missing == 'kk') Kartu Keluarga
                                        @elseif($missing == 'akta_kelahiran') Akta Kelahiran
                                        @elseif($missing == 'raport') Raport
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-success border-0 rounded-3 mt-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981;">
                            <i class="fas fa-check-circle me-2 text-success"></i>
                            <strong style="font-family: 'Poppins', sans-serif;">Semua dokumen sudah diupload!</strong>
                        </div>
                        
                        <div class="text-center mt-4">
                            <form action="{{ route('dokumen.submit') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #10B981, #059669); color: white; font-family: 'Poppins', sans-serif; font-weight: 600; padding: 12px 32px; border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: all 0.3s ease;" 
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.4)'" 
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(16, 185, 129, 0.3)'">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Dokumen untuk Verifikasi
                                </button>
                                <p class="text-muted mt-3" style="font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                                    <i class="fas fa-info-circle me-1"></i>Setelah submit, Anda masih bisa mengupload ulang jika diperlukan
                                </p>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection