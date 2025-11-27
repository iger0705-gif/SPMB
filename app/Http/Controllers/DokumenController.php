<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DokumenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendaftar = DB::table('pendaftar')->where('user_id', $user->id)->first();

        if (!$pendaftar) {
            return redirect()->route('pendaftaran.form')->with('error', 'Silakan lengkapi pendaftaran terlebih dahulu');
        }

        $documents = Document::where('pendaftar_id', $pendaftar->id)->get();

        $requiredDocs = ['ijazah', 'foto', 'kk', 'akta_kelahiran', 'raport'];
        $uploadedDocs = $documents->pluck('jenis_dokumen')->toArray();
        $missingDocs = array_diff($requiredDocs, $uploadedDocs);

        return view('dokumen.index', compact('documents', 'pendaftar', 'missingDocs'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:ijazah,foto,kk,akta_kelahiran,raport',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();
        $pendaftar = DB::table('pendaftar')->where('user_id', $user->id)->first();

        if (!$pendaftar) {
            return back()->with('error', 'Pendaftaran tidak ditemukan');
        }

        // Cek apakah dokumen sudah ada
        $existingDoc = Document::where('pendaftar_id', $pendaftar->id)
            ->where('jenis_dokumen', $request->jenis_dokumen)
            ->first();

        if ($existingDoc) {
            // Hapus file lama
            if (file_exists(public_path($existingDoc->path_file))) {
                unlink(public_path($existingDoc->path_file));
            }
            $existingDoc->delete();
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $request->jenis_dokumen . '_' . $pendaftar->no_pendaftaran . '.' . $file->getClientOriginalExtension();
        $filePath = 'uploads/documents/' . $fileName;
        
        $fileSize = $file->getSize();
        $originalName = $file->getClientOriginalName();
        
        $file->move(public_path('uploads/documents'), $fileName);

        Document::create([
            'pendaftar_id' => $pendaftar->id,
            'jenis_dokumen' => $request->jenis_dokumen,
            'nama_file' => $originalName,
            'path_file' => $filePath,
            'ukuran_file' => $fileSize,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);
        
        // Hapus file
        if (file_exists(public_path($document->path_file))) {
            unlink(public_path($document->path_file));
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus');
    }

    public function submit()
    {
        $user = Auth::user();
        $pendaftar = DB::table('pendaftar')->where('user_id', $user->id)->first();

        if (!$pendaftar) {
            return back()->with('error', 'Pendaftaran tidak ditemukan');
        }

        $documents = Document::where('pendaftar_id', $pendaftar->id)->get();
        $requiredDocs = ['ijazah', 'foto', 'kk', 'akta_kelahiran', 'raport'];
        $uploadedDocs = $documents->pluck('jenis_dokumen')->toArray();
        
        if (count($uploadedDocs) < count($requiredDocs)) {
            return back()->with('error', 'Semua dokumen harus diupload sebelum submit!');
        }

        // Update status pendaftar menjadi submitted
        DB::table('pendaftar')->where('id', $pendaftar->id)->update([
            'status' => 'SUBMIT'
        ]);

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil disubmit untuk verifikasi!');
    }
}
