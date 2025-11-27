@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="bi bi-cash-coin me-2"></i>Master Biaya Pendaftaran</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i>Tambah Biaya
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Jurusan</th>
                            <th>Gelombang</th>
                            <th>Biaya</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($biaya as $b)
                        <tr>
                            <td><strong>{{ $b->nama_jurusan }}</strong></td>
                            <td><span class="badge bg-secondary">{{ $b->nama_gelombang }}</span></td>
                            <td><span class="text-success fw-bold">Rp {{ number_format($b->biaya, 0, ',', '.') }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editBiaya({{ json_encode($b) }})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.master.biaya.destroy', $b->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada data biaya</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('admin.master.biaya.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Biaya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan_id" class="form-select" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gelombang</label>
                        <select name="gelombang_id" class="form-select" required>
                            <option value="">Pilih Gelombang</option>
                            @foreach($gelombang as $g)
                            <option value="{{ $g->id }}">{{ $g->nama }} - {{ $g->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya</label>
                        <input type="number" name="biaya" class="form-control" placeholder="250000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Biaya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan_id" id="edit_jurusan_id" class="form-select" required>
                            @foreach($jurusan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gelombang</label>
                        <select name="gelombang_id" id="edit_gelombang_id" class="form-select" required>
                            @foreach($gelombang as $g)
                            <option value="{{ $g->id }}">{{ $g->nama }} - {{ $g->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya</label>
                        <input type="number" name="biaya" id="edit_biaya" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function editBiaya(data) {
    document.getElementById('formEdit').action = '/admin/master/biaya/' + data.id;
    document.getElementById('edit_jurusan_id').value = data.jurusan_id;
    document.getElementById('edit_gelombang_id').value = data.gelombang_id;
    document.getElementById('edit_biaya').value = data.biaya;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>
@endsection
