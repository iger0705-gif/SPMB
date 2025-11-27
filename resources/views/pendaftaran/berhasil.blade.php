@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="border-radius: 20px; border: none; overflow: hidden;">
                <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #10B981, #059669); border: none;">
                    <h4 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">Pendaftaran Berhasil</h4>
                </div>
                <div class="card-body text-center p-4">
                    <div class="mb-4">
                        <div class="success-icon" style="width: 80px; height: 80px; background: #10B981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    
                    <h3 class="fw-bold mb-3" style="font-family: 'Poppins', sans-serif; color: #10B981;">Data Anda Berhasil Disimpan!</h3>
                    <p class="lead mb-4" style="font-family: 'Inter', sans-serif; color: #4B5563;">Terima kasih telah mendaftar di SMK Bakti Nusantara 666</p>
                    
                    <div class="alert alert-info border-0 rounded-3" style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3B82F6;">
                        <h5 class="fw-semibold mb-3" style="font-family: 'Poppins', sans-serif;">Nomor Pendaftaran Anda:</h5>
                        <h2 class="text-primary fw-bold mb-2" style="font-family: 'Poppins', sans-serif;">{{ $no_pendaftaran }}</h2>
                        <p class="mb-0 text-muted" style="font-family: 'Inter', sans-serif;"><small>Simpan nomor ini untuk keperluan selanjutnya</small></p>
                    </div>

                    <div class="row mt-4 g-3">
                        <div class="col-md-6">
                            <div class="card border-0 p-3 h-100" style="background: #F9FAFB; border-radius: 12px;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-file-upload me-2" style="color: #3B82F6;"></i>
                                    <h6 class="mb-0 fw-semibold" style="font-family: 'Poppins', sans-serif;">Tahap Selanjutnya</h6>
                                </div>
                                <p class="mb-0 text-muted" style="font-family: 'Inter', sans-serif;">Upload berkas persyaratan</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 p-3 h-100" style="background: #F9FAFB; border-radius: 12px;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #F59E0B;"></i>
                                    <h6 class="mb-0 fw-semibold" style="font-family: 'Poppins', sans-serif;">Status</h6>
                                </div>
                                <p class="mb-0 text-warning fw-semibold" style="font-family: 'Inter', sans-serif;">Menunggu Verifikasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3">
                        <a href="{{ route('home') }}" class="btn btn-secondary me-3 px-4 py-2" style="font-family: 'Inter', sans-serif; font-weight: 500; border-radius: 8px;">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2" style="font-family: 'Inter', sans-serif; font-weight: 500; border-radius: 8px; background: #3B82F6; border: none;">
                            <i class="fas fa-tachometer-alt me-2"></i>Lihat Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection