<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GelombangSeeder extends Seeder
{
    public function run()
    {
        DB::table('gelombang')->insert([
            [
                'nama' => 'Gelombang 1',
                'tahun' => 2024,
                'tgl_mulai' => '2024-01-01',
                'tgl_selesai' => '2024-12-31',
                'biaya_daftar' => 250000,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}