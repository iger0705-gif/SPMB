<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KepsekController extends Controller
{
    public function dashboard(Request $request)
    {
        $periode = $request->periode ?? 30;
        
        // KPI Utama
        $totalPendaftar = DB::table('pendaftar')->count();
        $targetPendaftar = DB::table('jurusan')->sum('kuota');
        $lulusAdministrasi = DB::table('pendaftar')->where('status', 'ADM_PASS')->count();
        $pembayaranLunas = DB::table('pendaftar')->where('status', 'PAID')->count();
        
        $rasioLulus = $totalPendaftar > 0 ? ($lulusAdministrasi / $totalPendaftar * 100) : 0;
        $konversiPembayaran = $totalPendaftar > 0 ? ($pembayaranLunas / $totalPendaftar * 100) : 0;
        $pencapaianTarget = $targetPendaftar > 0 ? ($totalPendaftar / $targetPendaftar * 100) : 0;
        
        // Tren Pendaftaran Harian
        $trenPendaftaran = DB::table('pendaftar')
            ->select(DB::raw('DATE(tanggal_daftar) as tanggal'), DB::raw('COUNT(*) as total'))
            ->whereDate('tanggal_daftar', '>=', now()->subDays($periode))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
        
        // Pendaftar vs Kuota per Jurusan
        $jurusanData = DB::table('jurusan')
            ->leftJoin('pendaftar', 'jurusan.id', '=', 'pendaftar.jurusan_id')
            ->select(
                'jurusan.nama',
                'jurusan.kuota',
                DB::raw('COUNT(pendaftar.id) as jumlah_pendaftar')
            )
            ->groupBy('jurusan.id', 'jurusan.nama', 'jurusan.kuota')
            ->get();
        
        // Komposisi Asal Sekolah
        $asalSekolah = DB::table('pendaftar_asal_sekolah')
            ->select('nama_sekolah', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_sekolah')
            ->orderBy('jumlah', 'desc')
            ->limit(10)
            ->get();
        
        return view('kepsek.dashboard', compact(
            'totalPendaftar',
            'targetPendaftar',
            'lulusAdministrasi',
            'pembayaranLunas',
            'rasioLulus',
            'konversiPembayaran',
            'pencapaianTarget',
            'trenPendaftaran',
            'jurusanData',
            'asalSekolah',
            'periode'
        ));
    }
    
    public function grafik(Request $request)
    {
        $periode = $request->periode ?? 30;
        
        // Tren Pendaftaran, Lulus Adm, dan Pembayaran
        $trenData = DB::table('pendaftar')
            ->select(
                DB::raw('DATE(tanggal_daftar) as tanggal'),
                DB::raw('COUNT(*) as total_pendaftar'),
                DB::raw('SUM(CASE WHEN status = "ADM_PASS" THEN 1 ELSE 0 END) as lulus_adm'),
                DB::raw('SUM(CASE WHEN status = "PAID" THEN 1 ELSE 0 END) as terbayar')
            )
            ->whereDate('tanggal_daftar', '>=', now()->subDays($periode))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
        
        // Status Pendaftaran
        $statusData = DB::table('pendaftar')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
        
        // Pendaftar per Jurusan
        $jurusanData = DB::table('pendaftar')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select('jurusan.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();
        
        // Pendaftar per Gelombang
        $gelombangData = DB::table('pendaftar')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->select('gelombang.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('gelombang.id', 'gelombang.nama')
            ->get();
        
        return view('kepsek.grafik', compact('trenData', 'statusData', 'jurusanData', 'gelombangData', 'periode'));
    }
    
    public function analisisSekolah()
    {
        $asalSekolah = DB::table('pendaftar_asal_sekolah')
            ->join('pendaftar', 'pendaftar_asal_sekolah.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pendaftar_asal_sekolah.nama_sekolah',
                'pendaftar_asal_sekolah.kabupaten',
                DB::raw('COUNT(*) as jumlah_siswa'),
                DB::raw('AVG(pendaftar_asal_sekolah.nilai_rata) as rata_nilai')
            )
            ->groupBy('pendaftar_asal_sekolah.nama_sekolah', 'pendaftar_asal_sekolah.kabupaten')
            ->orderBy('jumlah_siswa', 'desc')
            ->get();
        
        return view('kepsek.analisis-sekolah', compact('asalSekolah'));
    }
}