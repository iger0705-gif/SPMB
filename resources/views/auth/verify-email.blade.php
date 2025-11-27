@extends('layouts.public')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container" style="margin-top: 120px; margin-bottom: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-envelope-check" style="font-size: 4rem; color: #1E40AF;"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Verifikasi Email</h3>
                        <p class="text-muted">Masukkan kode OTP yang telah dikirim ke email Anda</p>
                        @if(session('registration_data'))
                            <p class="text-primary fw-bold">{{ session('registration_data.email') }}</p>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('verify.email.post') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kode OTP</label>
                            <input type="text" 
                                   name="otp" 
                                   class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                                   placeholder="000000"
                                   maxlength="6"
                                   style="letter-spacing: 8px; font-size: 24px; font-weight: bold; border-radius: 15px;"
                                   required
                                   autofocus>
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan 6 digit kode yang dikirim ke email Anda</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius: 15px; font-size: 16px;">
                            <i class="bi bi-check-circle me-2"></i>Verifikasi Email
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-2">Tidak menerima kode?</p>
                        <form method="POST" action="{{ route('verify.email.resend') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-arrow-clockwise me-1"></i>Kirim Ulang OTP
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-4 pt-3" style="border-top: 1px solid #e9ecef;">
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto format OTP input
document.querySelector('input[name="otp"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Auto submit when 6 digits entered
document.querySelector('input[name="otp"]').addEventListener('input', function(e) {
    if (this.value.length === 6) {
        setTimeout(() => {
            this.form.submit();
        }, 500);
    }
});
</script>
@endsection