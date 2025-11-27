<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total pendaftar
        $totalPendaftar = DB::table('pendaftar')->count();

        // Status pendaftaran
        $menungguVerifikasi = DB::table('pendaftar')->where('status', 'SUBMIT')->count();
        $lulusAdministrasi = DB::table('pendaftar')->whereIn('status', ['ADM_PASS', 'PAID'])->count();
        $terbayar = DB::table('pendaftar')->where('status', 'PAID')->count();
        $ditolak = DB::table('pendaftar')->where('status', 'ADM_REJECT')->count();
        $draft = DB::table('pendaftar')->where('status', 'DRAFT')->count();

        // Pendaftar per jurusan
        $pendaftarPerJurusan = DB::table('pendaftar')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select('jurusan.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('jurusan.id', 'jurusan.nama')
            ->get();

        // Status pendaftaran breakdown
        $statusPendaftaran = DB::table('pendaftar')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Data pendaftar terbaru
        $pendaftarTerbaru = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pendaftar.id',
                'pendaftar.no_pendaftaran',
                'pendaftar.tanggal_daftar',
                'pendaftar.status',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('pendaftar.tanggal_daftar', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPendaftar',
            'menungguVerifikasi',
            'lulusAdministrasi',
            'terbayar',
            'ditolak',
            'draft',
            'pendaftarPerJurusan',
            'statusPendaftaran',
            'pendaftarTerbaru'
        ));
    }

    public function pendaftar(Request $request)
    {
        $query = DB::table('pendaftar')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pendaftar.id',
                'pendaftar.no_pendaftaran',
                'pendaftar.tanggal_daftar',
                'pendaftar.status',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            );
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('pendaftar.status', $request->status);
        }
        
        $pendaftar = $query->orderBy('pendaftar.tanggal_daftar', 'desc')->get();

        return view('admin.pendaftar.index', compact('pendaftar'));
    }

    public function pendaftarDetail($id)
    {
        $pendaftar = DB::table('pendaftar')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'pendaftar.*',
                'jurusan.nama as nama_jurusan'
            )
            ->where('pendaftar.id', $id)
            ->first();

        if (!$pendaftar) {
            abort(404, 'Pendaftar tidak ditemukan');
        }

        $dataSiswa = DB::table('pendaftar_data_siswa')
            ->where('pendaftar_id', $id)
            ->first();

        if (!$dataSiswa) {
            $dataSiswa = (object)[
                'nama_lengkap' => 'Data belum tersedia',
                'nisn' => '-',
                'nik' => '-',
                'tempat_lahir' => '-',
                'tanggal_lahir' => date('Y-m-d'),
                'jenis_kelamin' => '-',
                'agama' => '-',
                'alamat' => '-',
                'no_hp' => '-',
                'email' => '-'
            ];
        }

        $dataOrtu = DB::table('pendaftar_data_ortu')
            ->where('pendaftar_id', $id)
            ->first();

        if (!$dataOrtu) {
            $dataOrtu = (object)[
                'nama_ayah' => 'Data belum tersedia',
                'pekerjaan_ayah' => '-',
                'nama_ibu' => 'Data belum tersedia',
                'pekerjaan_ibu' => '-',
                'hp_ayah' => '-'
            ];
        }

        $dataSekolah = DB::table('pendaftar_asal_sekolah')
            ->where('pendaftar_id', $id)
            ->first();

        if (!$dataSekolah) {
            $dataSekolah = (object)[
                'nama_sekolah' => 'Data belum tersedia',
                'kabupaten' => '-',
                'nilai_rata' => '-'
            ];
        }

        return view('admin.pendaftar.detail', compact('pendaftar', 'dataSiswa', 'dataOrtu', 'dataSekolah'));
    }

    public function verifikasiDokumen()
    {
        $documents = DB::table('documents')
            ->join('pendaftar', 'documents.pendaftar_id', '=', 'pendaftar.id')
            ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->select(
                'documents.*',
                'pendaftar.no_pendaftaran',
                'pendaftar_data_siswa.nama_lengkap',
                'jurusan.nama as nama_jurusan'
            )
            ->orderBy('documents.created_at', 'desc')
            ->get();

        return view('admin.verifikasi.dokumen', compact('documents'));
    }

    public function verifikasiDokumenUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string'
        ]);

        $document = Document::findOrFail($id);
        $document->status = $request->status;
        $document->catatan = $request->catatan;
        $document->save();

        return back()->with('success', 'Dokumen berhasil diverifikasi');
    }
}