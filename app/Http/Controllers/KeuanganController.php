<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        $totalPembayaran = DB::table('pembayaran')->where('status', 'TERBAYAR')->sum('jumlah');
        $menungguVerifikasi = DB::table('pembayaran')->where('status', 'MENUNGGU_VERIFIKASI')->count();
        $terverifikasiHariIni = DB::table('pembayaran')
            ->where('status', 'TERBAYAR')
            ->whereDate('tanggal_verifikasi', today())
            ->count();
        $ditolak = DB::table('pembayaran')->where('status', 'DITOLAK')->count();

        $pembayaranPerHari = DB::table('pembayaran')
            ->select(DB::raw('DATE(tanggal_verifikasi) as tanggal'), DB::raw('COUNT(*) as total'))
            ->where('status', 'TERBAYAR')
            ->whereDate('tanggal_verifikasi', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $statusPembayaran = DB::table('pembayaran')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('keuangan.dashboard', compact(
            'totalPembayaran',
            'menungguVerifikasi',
            'terverifikasiHariIni',
            'ditolak',
            'pembayaranPerHari',
            'statusPembayaran'
        ));
    }

    public function verifikasi()
    {
        $pembayaran = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pembayaran.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pembayaran.tanggal_upload', 'desc')
            ->get();

        return view('keuangan.verifikasi', compact('pembayaran'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:TERBAYAR,DITOLAK',
            'catatan' => 'nullable|string'
        ]);

        DB::table('pembayaran')->where('id', $id)->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'verifikator_id' => Auth::id(),
            'tanggal_verifikasi' => now(),
            'updated_at' => now()
        ]);

        // Update status pendaftar
        $pembayaran = DB::table('pembayaran')->where('id', $id)->first();
        if ($request->status == 'TERBAYAR') {
            DB::table('pendaftar')->where('id', $pembayaran->pendaftar_id)->update([
                'status' => 'PAID',
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Verifikasi pembayaran berhasil disimpan');
    }

    public function rekap()
    {
        // Data rekap pembayaran
        $rekap = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pembayaran.status', 'TERBAYAR')
            ->select(
                'pembayaran.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pembayaran.tanggal_verifikasi', 'desc')
            ->get();

        $totalPembayaran = $rekap->sum('jumlah');
        
        // Laporan per jurusan
        $laporanJurusan = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pembayaran.status', 'TERBAYAR')
            ->select(
                'jurusan.nama',
                DB::raw('SUM(pembayaran.jumlah) as total_penerimaan'),
                DB::raw('COUNT(*) as jumlah_siswa'),
                DB::raw('AVG(pembayaran.jumlah) as rata_rata')
            )
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();
            
        // Laporan harian 7 hari terakhir
        $laporanHarian = DB::table('pembayaran')
            ->select(DB::raw('DATE(tanggal_verifikasi) as tanggal'), DB::raw('SUM(jumlah) as total'), DB::raw('COUNT(*) as jumlah'))
            ->where('status', 'TERBAYAR')
            ->whereDate('tanggal_verifikasi', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();
            
        // Status pembayaran
        $statusPembayaran = DB::table('pembayaran')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        return view('keuangan.rekap', compact('rekap', 'totalPembayaran', 'laporanJurusan', 'laporanHarian', 'statusPembayaran'));
    }

    public function laporan()
    {
        return view('keuangan.laporan.index');
    }

    public function laporanHarian(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        
        $transaksi = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereDate('pembayaran.tanggal_verifikasi', $tanggal)
            ->where('pembayaran.status', 'TERBAYAR')
            ->select(
                'pembayaran.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pembayaran.tanggal_verifikasi', 'desc')
            ->get();

        $totalPembayaran = $transaksi->sum('jumlah');
        $jumlahTransaksi = $transaksi->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPembayaran / $jumlahTransaksi : 0;

        return view('keuangan.laporan.harian', compact('transaksi', 'totalPembayaran', 'jumlahTransaksi', 'rataRata', 'tanggal'));
    }

    public function laporanPeriode(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? date('Y-m-01');
        $tanggalAkhir = $request->tanggal_akhir ?? date('Y-m-d');
        
        $transaksi = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereBetween('pembayaran.tanggal_verifikasi', [$tanggalMulai, $tanggalAkhir])
            ->where('pembayaran.status', 'TERBAYAR')
            ->select(
                'pembayaran.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pembayaran.tanggal_verifikasi', 'desc')
            ->get();

        $totalPenerimaan = $transaksi->sum('jumlah');
        $transaksiSukses = $transaksi->count();
        $transaksiDitolak = DB::table('pembayaran')
            ->whereBetween('updated_at', [$tanggalMulai, $tanggalAkhir])
            ->where('status', 'DITOLAK')
            ->count();
        $transaksiPending = DB::table('pembayaran')
            ->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])
            ->where('status', 'MENUNGGU_VERIFIKASI')
            ->count();

        $trenHarian = DB::table('pembayaran')
            ->select(DB::raw('DATE(tanggal_verifikasi) as tanggal'), DB::raw('SUM(jumlah) as total'))
            ->whereBetween('tanggal_verifikasi', [$tanggalMulai, $tanggalAkhir])
            ->where('status', 'TERBAYAR')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('keuangan.laporan.periode', compact('transaksi', 'totalPenerimaan', 'transaksiSukses', 'transaksiDitolak', 'transaksiPending', 'trenHarian', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function laporanJurusan(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai ?? date('Y-m-01');
        $tanggalAkhir = $request->tanggal_akhir ?? date('Y-m-d');
        
        $laporanJurusan = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereBetween('pembayaran.tanggal_verifikasi', [$tanggalMulai, $tanggalAkhir])
            ->where('pembayaran.status', 'TERBAYAR')
            ->select(
                'jurusan.nama',
                DB::raw('SUM(pembayaran.jumlah) as total_penerimaan'),
                DB::raw('COUNT(*) as jumlah_siswa'),
                DB::raw('AVG(pembayaran.jumlah) as rata_rata')
            )
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();

        $totalKeseluruhan = $laporanJurusan->sum('total_penerimaan');

        return view('keuangan.laporan.jurusan', compact('laporanJurusan', 'totalKeseluruhan', 'tanggalMulai', 'tanggalAkhir'));
    }

    public function laporanGelombang(Request $request)
    {
        $gelombangId = $request->gelombang_id;
        
        $gelombang = DB::table('gelombang')->get();
        
        if ($gelombangId) {
            $gelombangData = DB::table('gelombang')->where('id', $gelombangId)->first();
            
            $totalPendaftar = DB::table('pendaftar')->where('gelombang_id', $gelombangId)->count();
            $totalTerbayar = DB::table('pembayaran')
                ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
                ->where('pendaftar.gelombang_id', $gelombangId)
                ->where('pembayaran.status', 'TERBAYAR')
                ->count();
            
            $realisasiPenerimaan = DB::table('pembayaran')
                ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
                ->where('pendaftar.gelombang_id', $gelombangId)
                ->where('pembayaran.status', 'TERBAYAR')
                ->sum('pembayaran.jumlah');
            
            $targetPenerimaan = DB::table('biaya_pendaftaran')
                ->join('jurusan', 'biaya_pendaftaran.jurusan_id', '=', 'jurusan.id')
                ->where('biaya_pendaftaran.gelombang_id', $gelombangId)
                ->select(DB::raw('SUM(biaya_pendaftaran.biaya * jurusan.kuota) as target'))
                ->first()->target ?? 0;
            
            $pencapaian = $targetPenerimaan > 0 ? ($realisasiPenerimaan / $targetPenerimaan * 100) : 0;
            
            $sisaHari = \Carbon\Carbon::parse($gelombangData->tgl_selesai)->diffInDays(now(), false);
            $sisaHari = $sisaHari < 0 ? abs($sisaHari) : 0;
            
            $trendPendaftaran = DB::table('pendaftar')
                ->select(DB::raw('DATE(tanggal_daftar) as tanggal'), DB::raw('COUNT(*) as total'))
                ->where('gelombang_id', $gelombangId)
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
            
            return view('keuangan.laporan.gelombang', compact('gelombang', 'gelombangData', 'totalPendaftar', 'totalTerbayar', 'realisasiPenerimaan', 'targetPenerimaan', 'pencapaian', 'sisaHari', 'trendPendaftaran', 'gelombangId'));
        }
        
        return view('keuangan.laporan.gelombang', compact('gelombang'));
    }
}
