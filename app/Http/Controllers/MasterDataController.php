<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    // Jurusan
    public function jurusan()
    {
        $jurusan = DB::table('jurusan')->orderBy('nama')->get();
        return view('admin.master.jurusan', compact('jurusan'));
    }

    public function jurusanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:jurusan',
            'kuota' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string'
        ]);

        DB::table('jurusan')->insert([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'kuota' => $request->kuota,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function jurusanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:jurusan,kode,'.$id,
            'kuota' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string'
        ]);

        DB::table('jurusan')->where('id', $id)->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'kuota' => $request->kuota,
            'deskripsi' => $request->deskripsi,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Jurusan berhasil diupdate');
    }

    public function jurusanDestroy($id)
    {
        DB::table('jurusan')->where('id', $id)->delete();
        return back()->with('success', 'Jurusan berhasil dihapus');
    }

    // Gelombang
    public function gelombang()
    {
        $gelombang = DB::table('gelombang')->orderBy('tahun', 'desc')->get();
        return view('admin.master.gelombang', compact('gelombang'));
    }

    public function gelombangStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tahun' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'biaya_daftar' => 'required|integer|min:0'
        ]);

        DB::table('gelombang')->insert([
            'nama' => $request->nama,
            'tahun' => $request->tahun,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'biaya_daftar' => $request->biaya_daftar,
            'aktif' => $request->has('aktif'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Gelombang berhasil ditambahkan');
    }

    public function gelombangUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tahun' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'biaya_daftar' => 'required|integer|min:0'
        ]);

        DB::table('gelombang')->where('id', $id)->update([
            'nama' => $request->nama,
            'tahun' => $request->tahun,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'biaya_daftar' => $request->biaya_daftar,
            'aktif' => $request->has('aktif'),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Gelombang berhasil diupdate');
    }

    public function gelombangDestroy($id)
    {
        DB::table('gelombang')->where('id', $id)->delete();
        return back()->with('success', 'Gelombang berhasil dihapus');
    }

    // Biaya
    public function biaya()
    {
        $biaya = DB::table('biaya_pendaftaran')
            ->join('jurusan', 'biaya_pendaftaran.jurusan_id', '=', 'jurusan.id')
            ->join('gelombang', 'biaya_pendaftaran.gelombang_id', '=', 'gelombang.id')
            ->select('biaya_pendaftaran.*', 'jurusan.nama as nama_jurusan', 'gelombang.nama as nama_gelombang')
            ->get();
        
        $jurusan = DB::table('jurusan')->get();
        $gelombang = DB::table('gelombang')->get();
        
        return view('admin.master.biaya', compact('biaya', 'jurusan', 'gelombang'));
    }

    public function biayaStore(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'gelombang_id' => 'required|exists:gelombang,id',
            'biaya' => 'required|integer|min:0'
        ]);

        DB::table('biaya_pendaftaran')->insert([
            'jurusan_id' => $request->jurusan_id,
            'gelombang_id' => $request->gelombang_id,
            'biaya' => $request->biaya,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Biaya berhasil ditambahkan');
    }

    public function biayaUpdate(Request $request, $id)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'gelombang_id' => 'required|exists:gelombang,id',
            'biaya' => 'required|integer|min:0'
        ]);

        DB::table('biaya_pendaftaran')->where('id', $id)->update([
            'jurusan_id' => $request->jurusan_id,
            'gelombang_id' => $request->gelombang_id,
            'biaya' => $request->biaya,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Biaya berhasil diupdate');
    }

    public function biayaDestroy($id)
    {
        DB::table('biaya_pendaftaran')->where('id', $id)->delete();
        return back()->with('success', 'Biaya berhasil dihapus');
    }
}
