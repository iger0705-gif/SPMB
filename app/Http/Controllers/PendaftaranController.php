<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    public function form()
{
    $gelombang = DB::table('gelombang')->where('aktif', true)->first();
    return view('pendaftaran.form', compact('gelombang'));
}

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:120',
            'agama' => 'required|string',
            'nisn' => 'required|string|max:20',
            'nik' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:60',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email',
            'jurusan_id' => 'required|exists:jurusan,id',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'no_hp_ortu' => 'required|string',
            'alamat_ortu' => 'nullable|string',
            'asal_sekolah' => 'required|string',
            'alamat_sekolah' => 'required|string',
            'tahun_lulus' => 'required|integer',
            'nilai_rata_rata' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // Generate nomor pendaftaran
            $noPendaftaran = 'PPDB-' . date('Y') . '-' . Str::random(6);
            
            // Get gelombang aktif
            $gelombang = DB::table('gelombang')->where('aktif', true)->first();

            // Simpan data pendaftar utama
            $pendaftar = DB::table('pendaftar')->insertGetId([
                'user_id' => auth()->id(),
                'tanggal_daftar' => now(),
                'no_pendaftaran' => $noPendaftaran,
                'gelombang_id' => $gelombang->id,
                'jurusan_id' => $validated['jurusan_id'],
                'status' => 'DRAFT',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan data siswa
            DB::table('pendaftar_data_siswa')->insert([
                'pendaftar_id' => $pendaftar,
                'nik' => $validated['nik'],
                'nisn' => $validated['nisn'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'agama' => $validated['agama'],
                'alamat' => $validated['alamat'],
                'provinsi' => '-',
                'kabupaten' => '-',
                'kecamatan' => '-',
                'no_telepon' => $validated['no_hp'],
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Simpan data orang tua
            DB::table('pendaftar_data_ortu')->insert([
                'pendaftar_id' => $pendaftar,
                'nama_ayah' => $validated['nama_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'hp_ayah' => $validated['no_hp_ortu'],
                'nama_ibu' => $validated['nama_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Simpan data sekolah
            DB::table('pendaftar_asal_sekolah')->insert([
                'pendaftar_id' => $pendaftar,
                'nama_sekolah' => $validated['asal_sekolah'],
                'kabupaten' => $validated['alamat_sekolah'],
                'nilai_rata' => $validated['nilai_rata_rata'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('pendaftaran.berhasil')->with([
                'success' => 'Pendaftaran berhasil!',
                'no_pendaftaran' => $noPendaftaran
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function berhasil()
    {
        if (!session('success')) {
            return redirect()->route('pendaftaran.form');
        }

        return view('pendaftaran.berhasil', [
            'no_pendaftaran' => session('no_pendaftaran')
        ]);
    }
}