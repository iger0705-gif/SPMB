<!DOCTYPE html>
<html>
<head>
    <title>Laporan Lengkap</title>
    <style>
        @media print { @page { margin: 1cm; } }
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 5px 0; font-size: 18px; }
        .header p { margin: 3px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMK BAKTI NUSANTARA 666</h2>
        <p>Jl. Raya Cileunyi No. 666, Bandung, Jawa Barat 40393</p>
        <p>Telp: (022) 7654321 | Email: info@smkbaknus666.sch.id</p>
    </div>

    <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN LENGKAP DATA PENDAFTAR</h3>
    
    <div style="margin-bottom: 20px;">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;">Tanggal Cetak</td>
                <td style="border: none;">: {{ date('d F Y') }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Total Pendaftar</td>
                <td style="border: none;">: {{ $data->count() }} orang</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">No Pendaftaran</th>
                <th width="18%">Nama</th>
                <th width="15%">Email</th>
                <th width="12%">Jurusan</th>
                <th width="10%">Gelombang</th>
                <th width="10%">Status</th>
                <th width="12%">Asal Sekolah</th>
                <th width="8%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->no_pendaftaran }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->jurusan }}</td>
                <td>{{ $row->gelombang }}</td>
                <td>{{ $row->status == 'SUBMIT' ? 'Dikirim' : ($row->status == 'ADM_PASS' ? 'Lulus Administrasi' : ($row->status == 'ADM_REJECT' ? 'Tolak Administrasi' : ($row->status == 'PAID' ? 'Terbayar' : $row->status))) }}</td>
                <td>{{ $row->nama_sekolah ?? '-' }}</td>
                <td>{{ date('d/m/Y', strtotime($row->tanggal_daftar)) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Bandung, {{ date('d F Y') }}</p>
        <p style="margin-top: 60px;">Panitia PPDB</p>
    </div>

    <script>window.print();</script>
</body>
</html>
