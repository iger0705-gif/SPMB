<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Verification;
use App\Models\Document;

class VerifikasiController extends Controller
{
    public function dashboard()
    {
        $totalPendaftar = DB::table('pendaftar')->count();
        $menungguVerifikasi = DB::table('pendaftar')->where('status', 'SUBMIT')->count();
        $lulusVerifikasi = DB::table('pendaftar')->where('status', 'ADM_PASS')->count();
        $ditolak = DB::table('pendaftar')->where('status', 'ADM_REJECT')->count();

        $dokumenPending = DB::table('documents')->where('status', 'pending')->count();
        $dokumenVerified = DB::table('documents')->where('status', 'verified')->count();
        $dokumenRejected = DB::table('documents')->where('status', 'rejected')->count();

        $recentVerifications = DB::table('verifications')
            ->join('pendaftar', 'verifications.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('users', 'verifications.verifikator_id', '=', 'users.id')
            ->select(
                'verifications.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'users.name as verifikator_name'
            )
            ->orderBy('verifications.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.verifikasi.dashboard', compact(
            'totalPendaftar',
            'menungguVerifikasi',
            'lulusVerifikasi',
            'ditolak',
            'dokumenPending',
            'dokumenVerified',
            'dokumenRejected',
            'recentVerifications'
        ));
    }

    public function administrasi()
    {
        $pendaftar = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pendaftar.*',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pendaftar.tanggal_daftar', 'desc')
            ->get();

        return view('admin.verifikasi.administrasi', compact('pendaftar'));
    }

    public function updateAdministrasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ADM_PASS,ADM_REJECT,SUBMIT',
            'catatan' => 'nullable|string'
        ]);

        // Get status sebelum
        $pendaftar = DB::table('pendaftar')->where('id', $id)->first();
        $statusSebelum = $pendaftar->status;

        // Update status pendaftar
        DB::table('pendaftar')->where('id', $id)->update([
            'status' => DB::raw("'" . $request->status . "'"),
            'updated_at' => DB::raw("'" . now() . "'")
        ]);

        // Simpan log verifikasi
        DB::table('log_verifikasi')->insert([
            'pendaftar_id' => $id,
            'verifikator_id' => Auth::id(),
            'status_sebelum' => DB::raw("'" . $statusSebelum . "'"),
            'status_sesudah' => DB::raw("'" . $request->status . "'"),
            'catatan' => $request->catatan,
            'created_at' => DB::raw("'" . now() . "'"),
            'updated_at' => DB::raw("'" . now() . "'")
        ]);

        return back()->with('success', 'Verifikasi administrasi berhasil disimpan');
    }

    public function tracking($noPendaftaran)
    {
        $pendaftar = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pendaftar.no_pendaftaran', $noPendaftaran)
            ->select(
                'pendaftar.*',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->first();

        if (!$pendaftar) {
            return view('tracking.index', ['pendaftar' => null]);
        }

        $documents = Document::where('pendaftar_id', $pendaftar->id)->get();
        
        $verifications = Verification::where('pendaftar_id', $pendaftar->id)
            ->with('verifikator')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tracking.detail', compact('pendaftar', 'documents', 'verifications'));
    }
}
