@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-smk">
                <div class="card-header bg-smk-primary text-white">
                    <h4 class="mb-0">Detail Jurusan</h4>
                    <small>SMK Bakti Nusantara 666</small>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <span style="font-size: 4rem;">{{ $jurusan['icon'] }}</span>
                    </div>
                    
                    <h3 class="text-smk-primary text-center">{{ $jurusan['nama'] }}</h3>
                    <p class="text-muted text-center">{{ $jurusan['deskripsi'] }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3 text-center">
                                <h6 class="text-smk-primary">Kuota Tersedia</h6>
                                <p class="h4 text-smk-primary">80-100 siswa</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light p-3 text-center">
                                <h6 class="text-smk-primary">Status Pendaftaran</h6>
                                <p class="h4 text-success">Buka</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        @auth
                            <a href="{{ route('pendaftaran.form') }}" class="btn btn-smk btn-lg w-100 py-3">
                                📝 Daftar Sekarang
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-smk btn-lg w-100 py-3">
                                📝 Daftar Akun untuk Mendaftar
                            </a>
                        @endauth
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2 py-3">
                            ← Kembali ke Beranda
                        </a>
                    </div>

                    <!-- INFO TAMBAHAN -->
                    <div class="mt-5">
                        <h5 class="text-smk-primary">Persyaratan Pendaftaran:</h5>
                        <ul class="list-group">
                            <li class="list-group-item">📄 Fotocopy Ijazah SMP/Sederajat</li>
                            <li class="list-group-item">📄 Fotocopy SKHUN</li>
                            <li class="list-group-item">📄 Fotocopy Kartu Keluarga</li>
                            <li class="list-group-item">📄 Fotocopy Akta Kelahiran</li>
                            <li class="list-group-item">📷 Pas Foto 3x4 (2 lembar)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection