<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VerifikatorController extends Controller
{
    public function dashboard()
    {
        // Statistik untuk verifikator
        $tugasHariIni = DB::table('pendaftar')->where('status', 'SUBMIT')->count();
        $sudahDiverifikasi = DB::table('pendaftar')
            ->whereIn('status', ['ADM_PASS', 'ADM_REJECT'])
            ->count();
        $perluPerbaikan = DB::table('pendaftar')->where('status', 'ADM_REJECT')->count();
        
        // Notifikasi pendaftar yang upload ulang
        $uploadUlang = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar.status', 'ADM_REJECT')
            ->select(
                'pendaftar.id',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan',
                'pendaftar.updated_at'
            )
            ->orderBy('pendaftar.updated_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('verifikator.dashboard', compact(
            'tugasHariIni',
            'sudahDiverifikasi',
            'perluPerbaikan',
            'uploadUlang'
        ));
    }
    
    public function daftarPendaftar()
    {
        $pendaftar = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->whereIn('pendaftar.status', ['SUBMIT', 'ADM_REJECT'])
            ->select(
                'pendaftar.id',
                'pendaftar.no_pendaftaran',
                'pendaftar.tanggal_daftar',
                'pendaftar.status',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pendaftar.tanggal_daftar', 'desc')
            ->get();
        
        return view('verifikator.daftar', compact('pendaftar'));
    }
    
    public function logVerifikasi()
    {
        $logs = DB::table('log_verifikasi')
            ->join('pendaftar', 'log_verifikasi.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('users', 'log_verifikasi.verifikator_id', '=', 'users.id')
            ->select(
                'log_verifikasi.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'users.name as verifikator_name'
            )
            ->orderBy('log_verifikasi.created_at', 'desc')
            ->get();
        
        return view('verifikator.log', compact('logs'));
    }
}