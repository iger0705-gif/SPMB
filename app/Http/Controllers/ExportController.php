<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function laporanStatistik(Request $request)
    {
        // Data statistik lengkap
        $totalPendaftar = DB::table('pendaftar')->count();
        $draft = DB::table('pendaftar')->where('status', 'DRAFT')->count();
        $menunggu = DB::table('pendaftar')->where('status', 'SUBMIT')->count();
        $lulus = DB::table('pendaftar')->whereIn('status', ['ADM_PASS', 'PAID'])->count();
        $ditolak = DB::table('pendaftar')->where('status', 'ADM_REJECT')->count();
        $terbayar = DB::table('pendaftar')->where('status', 'PAID')->count();
        
        // Statistik per jurusan
        $perJurusan = DB::table('pendaftar')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select('jurusan.nama', 'jurusan.kuota', DB::raw('COUNT(*) as total_pendaftar'))
            ->groupBy('jurusan.id', 'jurusan.nama', 'jurusan.kuota')
            ->get();
        
        // Trend pendaftaran 7 hari terakhir
        $trendHarian = DB::table('pendaftar')
            ->select(DB::raw('DATE(tanggal_daftar) as tanggal'), DB::raw('COUNT(*) as total'))
            ->whereDate('tanggal_daftar', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Top asal sekolah
        $asalSekolah = DB::table('pendaftar_asal_sekolah')
            ->join('pendaftar', 'pendaftar_asal_sekolah.pendaftar_id', '=', 'pendaftar.id')
            ->select('pendaftar_asal_sekolah.nama_sekolah', 'pendaftar_asal_sekolah.kabupaten', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('pendaftar_asal_sekolah.nama_sekolah', 'pendaftar_asal_sekolah.kabupaten')
            ->orderBy('jumlah', 'desc')
            ->limit(10)
            ->get();
        
        // Data untuk export
        $jurusan = DB::table('jurusan')->get();
        $gelombang = DB::table('gelombang')->get();
        
        return view('admin.laporan.compact', compact(
            'totalPendaftar', 'draft', 'menunggu', 'lulus', 'ditolak', 'terbayar',
            'perJurusan', 'trendHarian', 'asalSekolah', 'jurusan', 'gelombang'
        ));
    }
    
    public function exportData(Request $request)
    {
        $jurusan = DB::table('jurusan')->get();
        $gelombang = DB::table('gelombang')->get();
        return view('admin.laporan.export', compact('jurusan', 'gelombang'));
    }
    
    public function prosesExport(Request $request)
    {
        $format = $request->format;
        $query = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->leftJoin('pendaftar_asal_sekolah', 'pendaftar.id', '=', 'pendaftar_asal_sekolah.pendaftar_id')
            ->select('pendaftar.no_pendaftaran', 'users.name', 'users.email', 'jurusan.nama as jurusan', 'gelombang.nama as gelombang', 'pendaftar.status', 'pendaftar_asal_sekolah.nama_sekolah', 'pendaftar.tanggal_daftar');
        
        if ($request->jurusan_id) $query->where('pendaftar.jurusan_id', $request->jurusan_id);
        if ($request->gelombang_id) $query->where('pendaftar.gelombang_id', $request->gelombang_id);
        if ($request->status) $query->where('pendaftar.status', $request->status);
        if ($request->tanggal_mulai && $request->tanggal_akhir) $query->whereBetween('pendaftar.tanggal_daftar', [$request->tanggal_mulai, $request->tanggal_akhir]);
        
        $data = $query->get();
        
        if ($format == 'excel') {
            return $this->exportExcel($data);
        } else {
            return $this->exportPdf($data, $request);
        }
    }
    
    private function exportExcel($data)
    {
        $filename = 'data_pendaftar_' . date('YmdHis') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="' . $filename . '"'];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Pendaftaran', 'Nama', 'Email', 'Jurusan', 'Gelombang', 'Status', 'Asal Sekolah', 'Tanggal Daftar']);
            foreach ($data as $row) {
                $status = $row->status;
                if ($status == 'SUBMIT') $status = 'Dikirim';
                elseif ($status == 'ADM_PASS') $status = 'Lulus Administrasi';
                elseif ($status == 'ADM_REJECT') $status = 'Tolak Administrasi';
                elseif ($status == 'PAID') $status = 'Terbayar';
                
                fputcsv($file, [
                    $row->no_pendaftaran,
                    $row->name,
                    $row->email,
                    $row->jurusan,
                    $row->gelombang,
                    $status,
                    $row->nama_sekolah ?? '-',
                    date('d/m/Y', strtotime($row->tanggal_daftar))
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    

    
    private function exportPdf($data, $request)
    {
        $html = '<html><head><style>body{font-family:Arial;font-size:10px;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:5px;text-align:left;}th{background:#3b82f6;color:white;}</style></head><body>';
        $html .= '<h2 style="text-align:center;">Data Pendaftar PPDB SMK Bakti Nusantara 666</h2>';
        $html .= '<p style="text-align:center;">Tanggal Export: ' . date('d/m/Y H:i') . '</p>';
        $html .= '<table><thead><tr><th>No</th><th>No Pendaftaran</th><th>Nama</th><th>Jurusan</th><th>Gelombang</th><th>Status</th><th>Asal Sekolah</th><th>Tanggal</th></tr></thead><tbody>';
        
        $no = 1;
        foreach ($data as $row) {
            $status = $row->status;
            if ($status == 'SUBMIT') $status = 'Dikirim';
            elseif ($status == 'ADM_PASS') $status = 'Lulus Administrasi';
            elseif ($status == 'ADM_REJECT') $status = 'Tolak Administrasi';
            elseif ($status == 'PAID') $status = 'Terbayar';
            
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . $row->no_pendaftaran . '</td>';
            $html .= '<td>' . $row->name . '</td>';
            $html .= '<td>' . $row->jurusan . '</td>';
            $html .= '<td>' . $row->gelombang . '</td>';
            $html .= '<td>' . $status . '</td>';
            $html .= '<td>' . ($row->nama_sekolah ?? '-') . '</td>';
            $html .= '<td>' . date('d/m/Y', strtotime($row->tanggal_daftar)) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></body></html>';
        
        return response($html)->header('Content-Type', 'text/html');
    }
    
    public function cetakLaporan(Request $request)
    {
        $jurusan = DB::table('jurusan')->get();
        $gelombang = DB::table('gelombang')->get();
        return view('admin.laporan.cetak', compact('jurusan', 'gelombang'));
    }
    
    public function prosesCetak(Request $request)
    {
        $jenis = $request->jenis;
        
        if ($jenis == 'harian') {
            return $this->cetakHarian($request);
        } elseif ($jenis == 'mingguan') {
            return $this->cetakMingguan($request);
        } elseif ($jenis == 'bulanan') {
            return $this->cetakBulanan($request);
        } elseif ($jenis == 'jurusan') {
            return $this->cetakJurusan($request);
        } elseif ($jenis == 'gelombang') {
            return $this->cetakGelombang($request);
        } else {
            return $this->cetakLengkap($request);
        }
    }
    
    private function cetakHarian($request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $data = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereDate('pendaftar.tanggal_daftar', $tanggal)
            ->select('pendaftar.no_pendaftaran', 'users.name', 'jurusan.nama as jurusan', 'pendaftar.status')
            ->get();
        
        return view('admin.laporan.cetak_harian', compact('data', 'tanggal'));
    }
    
    private function cetakMingguan($request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? date('Y-m-d', strtotime('-7 days'));
        $tanggalAkhir = $request->tanggal_akhir ?? date('Y-m-d');
        
        $data = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereBetween('pendaftar.tanggal_daftar', [$tanggalMulai, $tanggalAkhir])
            ->select('pendaftar.no_pendaftaran', 'users.name', 'jurusan.nama as jurusan', 'pendaftar.status', 'pendaftar.tanggal_daftar')
            ->get();
        
        return view('admin.laporan.cetak_periode', compact('data', 'tanggalMulai', 'tanggalAkhir'));
    }
    
    private function cetakBulanan($request)
    {
        $bulan = $request->bulan ?? date('Y-m');
        $data = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereRaw('DATE_FORMAT(pendaftar.tanggal_daftar, "%Y-%m") = ?', [$bulan])
            ->select('pendaftar.no_pendaftaran', 'users.name', 'jurusan.nama as jurusan', 'pendaftar.status', 'pendaftar.tanggal_daftar')
            ->get();
        
        return view('admin.laporan.cetak_bulanan', compact('data', 'bulan'));
    }
    
    private function cetakJurusan($request)
    {
        $jurusanId = $request->jurusan_id;
        $jurusan = DB::table('jurusan')->find($jurusanId);
        $data = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->where('pendaftar.jurusan_id', $jurusanId)
            ->select('pendaftar.no_pendaftaran', 'users.name', 'pendaftar.status', 'pendaftar.tanggal_daftar')
            ->get();
        
        return view('admin.laporan.cetak_jurusan', compact('data', 'jurusan'));
    }
    
    private function cetakGelombang($request)
    {
        $gelombangId = $request->gelombang_id;
        $gelombang = DB::table('gelombang')->find($gelombangId);
        $data = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar.gelombang_id', $gelombangId)
            ->select('pendaftar.no_pendaftaran', 'users.name', 'jurusan.nama as jurusan', 'pendaftar.status', 'pendaftar.tanggal_daftar')
            ->get();
        
        return view('admin.laporan.cetak_gelombang', compact('data', 'gelombang'));
    }
    
    private function cetakLengkap($request)
    {
        $data = DB::table('pendaftar')
            ->join('users', 'pendaftar.user_id', '=', 'users.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->leftJoin('pendaftar_asal_sekolah', 'pendaftar.id', '=', 'pendaftar_asal_sekolah.pendaftar_id')
            ->select('pendaftar.no_pendaftaran', 'users.name', 'users.email', 'jurusan.nama as jurusan', 'gelombang.nama as gelombang', 'pendaftar.status', 'pendaftar_asal_sekolah.nama_sekolah', 'pendaftar.tanggal_daftar')
            ->get();
        
        return view('admin.laporan.cetak_lengkap', compact('data'));
    }
}
