<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $jurusan = [
            [
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'kuota' => 100,
                'deskripsi' => 'Belajar pemrograman, pengembangan software, aplikasi web dan mobile'
            ],
            [
                'kode' => 'DKV', 
                'nama' => 'Desain Komunikasi Visual',
                'kuota' => 80,
                'deskripsi' => 'Mempelajari desain grafis, ilustrasi, fotografi, dan multimedia'
            ],
            [
                'kode' => 'AK',
                'nama' => 'Akuntansi', 
                'kuota' => 90,
                'deskripsi' => 'Belajar akuntansi, keuangan, perpajakan, dan administrasi bisnis'
            ],
            [
                'kode' => 'ANM',
                'nama' => 'Animasi',
                'kuota' => 70,
                'deskripsi' => 'Membuat animasi 2D/3D, visual effects, dan produksi film'
            ]
        ];

        foreach ($jurusan as $data) {
            Jurusan::create($data);
        }
    }
}