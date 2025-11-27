<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $jurusanFilter = $request->jurusan_id;
        $gelombangFilter = $request->gelombang_id;
        $statusFilter = $request->status;
        
        // Get data pendaftar dengan koordinat
        $query = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pendaftar.id',
                'pendaftar.no_pendaftaran',
                'pendaftar.status',
                'pendaftar_data_siswa.nama_lengkap',
                'pendaftar_data_siswa.alamat',
                'pendaftar_data_siswa.kabupaten',
                'pendaftar_data_siswa.kecamatan',
                'pendaftar_data_siswa.lat',
                'pendaftar_data_siswa.lng',
                'jurusan.nama as nama_jurusan',
                'jurusan.id as jurusan_id'
            )
            ->whereNotNull('pendaftar_data_siswa.lat')
            ->whereNotNull('pendaftar_data_siswa.lng');
        
        if ($jurusanFilter) {
            $query->where('pendaftar.jurusan_id', $jurusanFilter);
        }
        
        if ($gelombangFilter) {
            $query->where('pendaftar.gelombang_id', $gelombangFilter);
        }
        
        if ($statusFilter) {
            $query->where('pendaftar.status', $statusFilter);
        }
        
        $pendaftar = $query->get();
        
        // Get filter options
        $jurusan = DB::table('jurusan')->get();
        $gelombang = DB::table('gelombang')->get();
        
        // Statistik
        $totalPendaftar = $pendaftar->count();
        $kepadatanTertinggi = DB::table('pendaftar_data_siswa')
            ->select('kecamatan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->first();
        
        return view('peta.index', compact('pendaftar', 'jurusan', 'gelombang', 'totalPendaftar', 'kepadatanTertinggi'));
    }
}
