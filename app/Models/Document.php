<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'pendaftar_id',
        'jenis_dokumen',
        'nama_file',
        'path_file',
        'ukuran_file',
        'status',
        'catatan'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
