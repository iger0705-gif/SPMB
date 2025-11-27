<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;

    protected $table = 'gelombang';
    protected $fillable = ['nama', 'tahun', 'tgl_mulai', 'tgl_selesai', 'biaya_daftar', 'aktif'];

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }
}