@extends('layouts.dashboard')

@section('content')
<style>
    .page-title { font-family: 'Poppins', sans-serif; font-weight: 700; }
    .table { font-family: 'Inter', sans-serif; font-size: 13px; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="page-title"><i class="bi bi-building me-2"></i>Analisis Asal Sekolah</h4>
            <p class="page-subtitle">Data lengkap pendaftar berdasarkan sekolah asal</p>
        </div>
        <a href="{{ route('kepsek.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Sekolah</th>
                            <th>Kabupaten</th>
                            <th>Jumlah Siswa</th>
                            <th>Rata-rata Nilai</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalSiswa = $asalSekolah->sum('jumlah_siswa');
                        @endphp
                        @foreach($asalSekolah as $index => $sekolah)
                        @php
                            $persentase = $totalSiswa > 0 ? ($sekolah->jumlah_siswa / $totalSiswa * 100) : 0;
                        @endphp
                        <tr>
                            <td>
                                @if($index == 0)
                                <span class="badge bg-warning">🥇 #1</span>
                                @elseif($index == 1)
                                <span class="badge bg-secondary">🥈 #2</span>
                                @elseif($index == 2)
                                <span class="badge bg-info">🥉 #3</span>
                                @else
                                <span class="badge bg-light text-dark">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td><strong>{{ $sekolah->nama_sekolah }}</strong></td>
                            <td>{{ $sekolah->kabupaten }}</td>
                            <td><span class="badge bg-primary">{{ $sekolah->jumlah_siswa }} siswa</span></td>
                            <td><strong class="text-success">{{ number_format($sekolah->rata_nilai, 2) }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress" style="height: 8px; width: 100px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $persentase }}%"></div>
                                    </div>
                                    <small>{{ number_format($persentase, 1) }}%</small>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
