<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Pendaftaran - {{ $pendaftar->no_pendaftaran }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .card { border: 2px solid #0d6efd; border-radius: 10px; padding: 20px; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d6efd; padding-bottom: 15px; }
        .school-name { font-size: 18px; font-weight: bold; color: #0d6efd; margin-bottom: 5px; }
        .card-title { font-size: 16px; color: #666; }
        .info-row { display: flex; margin-bottom: 12px; }
        .info-label { width: 150px; font-weight: bold; }
        .info-value { flex: 1; }
        .status-badge { background: #198754; color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="school-name">SMK BAKTI NUSANTARA 666</div>
            <div class="card-title">KARTU PENDAFTARAN SISWA BARU</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">No. Pendaftaran:</div>
            <div class="info-value"><strong>{{ $pendaftar->no_pendaftaran }}</strong></div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Nama Lengkap:</div>
            <div class="info-value">{{ $pendaftar->nama_lengkap }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">NIK:</div>
            <div class="info-value">{{ $pendaftar->nik }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Tempat, Tgl Lahir:</div>
            <div class="info-value">{{ $pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->format('d/m/Y') }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Alamat:</div>
            <div class="info-value">{{ $pendaftar->alamat }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">No. Telepon:</div>
            <div class="info-value">{{ $pendaftar->no_telepon }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Jurusan Pilihan:</div>
            <div class="info-value">{{ $pendaftar->nama_jurusan }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Tanggal Daftar:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                <span class="status-badge">
                    @if($pendaftar->status == 'SUBMIT') Menunggu Verifikasi
                    @elseif($pendaftar->status == 'ADM_PASS') Lulus Administrasi
                    @elseif($pendaftar->status == 'ADM_REJECT') Ditolak
                    @elseif($pendaftar->status == 'PAID') Terbayar
                    @endif
                </span>
            </div>
        </div>
        
        <div class="footer">
            <p>Kartu ini dicetak pada {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            <p><strong>Simpan kartu ini sebagai bukti pendaftaran</strong></p>
        </div>
    </div>
</body>
</html>