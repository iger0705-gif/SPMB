@extends('layouts.public')

@section('title', 'Tracking Status')

@section('content')
<section class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center mb-5">
                    <h2 class="section-title">Tracking Status Pendaftaran</h2>
                    <p class="section-subtitle">Masukkan nomor pendaftaran untuk melihat status terkini</p>
                </div>
                
                <div class="feature-card">
                    <form action="{{ route('tracking.check') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nomor Pendaftaran</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="no_pendaftaran" class="form-control" 
                                       placeholder="Contoh: PPDB2024-0001" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search me-1"></i>Cek Status
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(isset($pendaftar) && $pendaftar === null)
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Nomor pendaftaran tidak ditemukan. Pastikan nomor yang Anda masukkan benar.
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="bi bi-lightbulb me-2"></i>Tips Pencarian:</h6>
                        <ul class="mb-0">
                            <li>Nomor pendaftaran dapat dilihat di email konfirmasi</li>
                            <li>Format: PPDB2024-XXXX</li>
                            <li>Tracking dapat diakses tanpa login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
