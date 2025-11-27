<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Route based on user role
        switch($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'verifikator_adm':
                return redirect()->route('verifikator.dashboard');
            case 'keuangan':
                return redirect()->route('keuangan.dashboard');
            case 'kepsek':
                return redirect()->route('kepsek.dashboard');
            default:
                // Pendaftar dashboard
                return $this->pendaftarDashboard($user);
        }
    }
    
    private function pendaftarDashboard($user)
    {
        $pendaftar = DB::table('pendaftar')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar.user_id', $user->id)
            ->select('pendaftar.*', 'jurusan.nama as nama_jurusan')
            ->first();

        if (!$pendaftar) {
            return view('dashboard.index', [
                'pendaftar' => null,
                'documents' => collect(),
                'completeness' => 0,
                'verifiedDocs' => 0,
                'pendingDocs' => 0,
                'rejectedDocs' => 0,
                'pembayaran' => null
            ]);
        }

        $documents = Document::where('pendaftar_id', $pendaftar->id)->get();
        
        $requiredDocs = ['ijazah', 'foto', 'kk', 'akta_kelahiran', 'raport'];
        $uploadedDocs = $documents->pluck('jenis_dokumen')->toArray();
        $completeness = (count($uploadedDocs) / count($requiredDocs)) * 100;

        $verifiedDocs = $documents->where('status', 'verified')->count();
        $pendingDocs = $documents->where('status', 'pending')->count();
        $rejectedDocs = $documents->where('status', 'rejected')->count();

        $pembayaran = DB::table('pembayaran')
            ->where('pendaftar_id', $pendaftar->id)
            ->first();

        return view('dashboard.index', compact('pendaftar', 'documents', 'completeness', 'verifiedDocs', 'pendingDocs', 'rejectedDocs', 'pembayaran'));
    }
    
    public function printCard()
    {
        $user = Auth::user();
        
        $pendaftar = DB::table('pendaftar')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->where('pendaftar.user_id', $user->id)
            ->select(
                'pendaftar.*', 
                'jurusan.nama as nama_jurusan',
                'pendaftar_data_siswa.nama_lengkap',
                'pendaftar_data_siswa.nik',
                'pendaftar_data_siswa.tempat_lahir',
                'pendaftar_data_siswa.tanggal_lahir',
                'pendaftar_data_siswa.alamat',
                'pendaftar_data_siswa.no_telepon'
            )
            ->first();
            
        if (!$pendaftar) {
            return redirect()->route('dashboard')->with('error', 'Data pendaftaran tidak ditemukan');
        }
        
        $pdf = Pdf::loadView('dashboard.print-card', compact('pendaftar', 'user'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('kartu-pendaftaran-' . $pendaftar->no_pendaftaran . '.pdf');
    }
}
