<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harian - {{ date('d/m/Y', strtotime($tanggal)) }}</title>
    <style>
        @media print { @page { margin: 1cm; } }
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 5px 0; font-size: 18px; }
        .header p { margin: 3px 0; font-size: 11px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
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

    <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN PENDAFTARAN HARIAN</h3>
    
    <div class="info">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;">Tanggal</td>
                <td style="border: none;">: {{ date('d F Y', strtotime($tanggal)) }}</td>
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
                <th width="5%">No</th>
                <th width="20%">No Pendaftaran</th>
                <th width="30%">Nama Lengkap</th>
                <th width="25%">Jurusan</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->no_pendaftaran }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->jurusan }}</td>
                <td>{{ $row->status == 'SUBMIT' ? 'Dikirim' : ($row->status == 'ADM_PASS' ? 'Lulus Administrasi' : ($row->status == 'ADM_REJECT' ? 'Tolak Administrasi' : ($row->status == 'PAID' ? 'Terbayar' : $row->status))) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pendaftar</td>
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
