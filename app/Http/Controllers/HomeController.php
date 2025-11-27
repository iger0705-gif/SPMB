<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::where('aktif', true)->get();
        
        // Statistik real dari database
        $totalPendaftar = DB::table('pendaftar')->count();
        $terverifikasi = DB::table('pendaftar')->where('status', 'ADM_PASS')->count();
        $sudahBayar = DB::table('pendaftar')->where('status', 'PAID')->count();
        $diterima = DB::table('pendaftar')->where('status', 'ACCEPTED')->count();
        
        // Gelombang aktif
        $gelombangAktif = DB::table('gelombang')->where('aktif', true)->first();
        
        // Total kuota tersedia
        $totalKuota = DB::table('jurusan')->where('aktif', true)->sum('kuota');
        $totalTerisi = DB::table('pendaftar')->count();
        $totalKuotaTersisa = $totalKuota - $totalTerisi;
        
        // Hitung progress percentage
        $progressPercentage = 0;
        if ($gelombangAktif) {
            $startDate = strtotime($gelombangAktif->tgl_mulai);
            $endDate = strtotime($gelombangAktif->tgl_selesai);
            $currentDate = time();
            
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $totalDuration = $endDate - $startDate;
                $elapsed = $currentDate - $startDate;
                $progressPercentage = ($elapsed / $totalDuration) * 100;
            } elseif ($currentDate > $endDate) {
                $progressPercentage = 100;
            }
        }
        
        return view('home', compact('jurusan', 'totalPendaftar', 'terverifikasi', 'sudahBayar', 'diterima', 'gelombangAktif', 'progressPercentage', 'totalKuota', 'totalKuotaTersisa'));
    }

    public function showJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('jurusan.detail', compact('jurusan'));
    }
}