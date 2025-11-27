@extends('layouts.dashboard')

@section('title', 'Form Pendaftaran')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header mb-4">
        <h4 class="page-title" style="font-family: 'Poppins', sans-serif; font-weight: 700;"><i class="bi bi-file-earmark-text me-2"></i>Formulir Pendaftaran PPDB</h4>
        <p class="page-subtitle" style="font-family: 'Inter', sans-serif;">Lengkapi semua data dengan benar dan teliti</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form method="POST" action="{{ route('pendaftaran.store') }}">
                @csrf

                <!-- BAGIAN 1: DATA DIRI LENGKAP -->
                <div class="card shadow-sm mb-3" style="border-left: 4px solid #3b82f6;">
                    <div class="card-header bg-white border-bottom py-2">
                        <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;"><i class="bi bi-person-circle me-2" style="color: #3b82f6;"></i>BAGIAN 1: DATA DIRI LENGKAP</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       name="nama_lengkap" value="{{ old('nama_lengkap') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('nama_lengkap')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Agama <span class="text-danger">*</span></label>
                                <select class="form-select @error('agama') is-invalid @enderror" name="agama" required style="font-family: 'Inter', sans-serif;">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">NISN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                                       name="nisn" value="{{ old('nisn') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('nisn')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                       name="nik" value="{{ old('nik') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('nik')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       name="tempat_lahir" value="{{ old('tempat_lahir') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('tempat_lahir')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('tanggal_lahir')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" required style="font-family: 'Inter', sans-serif;">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">No. HP <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('no_hp') is-invalid @enderror" 
                                       name="no_hp" value="{{ old('no_hp', Auth::user()->phone) }}" required style="font-family: 'Inter', sans-serif;">
                                @error('no_hp')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', Auth::user()->email) }}" required style="font-family: 'Inter', sans-serif;">
                                @error('email')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Jurusan Pilihan <span class="text-danger">*</span></label>
                                <select class="form-select @error('jurusan_id') is-invalid @enderror" name="jurusan_id" required style="font-family: 'Inter', sans-serif;">
                                    <option value="">Pilih Jurusan</option>
                                    @php
                                        $jurusan = DB::table('jurusan')->get();
                                    @endphp
                                    @foreach($jurusan as $j)
                                    <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jurusan_id')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          name="alamat" rows="2" required style="font-family: 'Inter', sans-serif;">{{ old('alamat') }}</textarea>
                                @error('alamat')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: DATA ORANG TUA -->
                <div class="card shadow-sm mb-3" style="border-left: 4px solid #10b981;">
                    <div class="card-header bg-white border-bottom py-2">
                        <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;"><i class="bi bi-people-fill me-2" style="color: #10b981;"></i>BAGIAN 2: DATA ORANG TUA</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Nama Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" 
                                       name="nama_ayah" value="{{ old('nama_ayah') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('nama_ayah')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" 
                                       name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('pekerjaan_ayah')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Nama Ibu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" 
                                       name="nama_ibu" value="{{ old('nama_ibu') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('nama_ibu')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" 
                                       name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('pekerjaan_ibu')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">No. HP Orang Tua <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('no_hp_ortu') is-invalid @enderror" 
                                       name="no_hp_ortu" value="{{ old('no_hp_ortu') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('no_hp_ortu')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Alamat Orang Tua</label>
                                <input type="text" class="form-control @error('alamat_ortu') is-invalid @enderror" 
                                       name="alamat_ortu" value="{{ old('alamat_ortu') }}" placeholder="Kosongkan jika sama dengan alamat siswa" style="font-family: 'Inter', sans-serif;">
                                @error('alamat_ortu')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: DATA SEKOLAH ASAL -->
                <div class="card shadow-sm mb-3" style="border-left: 4px solid #f59e0b;">
                    <div class="card-header bg-white border-bottom py-2">
                        <h6 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;"><i class="bi bi-building me-2" style="color: #f59e0b;"></i>BAGIAN 3: DATA SEKOLAH ASAL</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Nama Sekolah Asal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror" 
                                       name="asal_sekolah" value="{{ old('asal_sekolah') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('asal_sekolah')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Alamat Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('alamat_sekolah') is-invalid @enderror" 
                                       name="alamat_sekolah" value="{{ old('alamat_sekolah') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('alamat_sekolah')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Tahun Lulus <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('tahun_lulus') is-invalid @enderror" 
                                       name="tahun_lulus" value="{{ old('tahun_lulus', date('Y')) }}" min="2000" max="{{ date('Y') }}" required style="font-family: 'Inter', sans-serif;">
                                @error('tahun_lulus')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-family: 'Inter', sans-serif;">Nilai Rata-rata <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('nilai_rata_rata') is-invalid @enderror" 
                                       name="nilai_rata_rata" value="{{ old('nilai_rata_rata') }}" min="0" max="100" required style="font-family: 'Inter', sans-serif;">
                                @error('nilai_rata_rata')<div class="invalid-feedback" style="font-family: 'Inter', sans-serif;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="font-family: 'Inter', sans-serif;">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="font-family: 'Inter', sans-serif;">
                        <i class="bi bi-save me-1"></i>Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection