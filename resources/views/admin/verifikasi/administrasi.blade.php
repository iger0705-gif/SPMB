@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-smk">
                <div class="card-header bg-smk-primary text-white">
                    <h5 class="m-0">📋 Verifikasi Administrasi Pendaftar</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftar as $p)
                                    <tr>
                                        <td><strong>{{ $p->no_pendaftaran }}</strong></td>
                                        <td>{{ $p->nama_lengkap }}</td>
                                        <td><span class="badge bg-primary">{{ $p->nama_jurusan }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($p->status == 'SUBMIT')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($p->status == 'ADM_PASS')
                                                <span class="badge bg-success">Lulus</span>
                                            @elseif($p->status == 'ADM_REJECT')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pendaftar.detail', $p->id) }}" class="btn btn-sm btn-info">Detail</a>
                                            @if($p->status == 'SUBMIT')
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal{{ $p->id }}">Verifikasi</button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Verifikasi -->
                                    <div class="modal fade" id="verifikasiModal{{ $p->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.verifikasi.administrasi.update', $p->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Verifikasi Administrasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Nama:</strong> {{ $p->nama_lengkap }}</p>
                                                        <p><strong>No. Pendaftaran:</strong> {{ $p->no_pendaftaran }}</p>
                                                        <hr>
                                                        <div class="mb-3">
                                                            <label class="form-label">Status Verifikasi</label>
                                                            <select name="status" class="form-select" required>
                                                                <option value="ADM_PASS">✅ Lulus Administrasi</option>
                                                                <option value="ADM_REJECT">❌ Tolak</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan</label>
                                                            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan verifikasi (opsional)"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pendaftar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
