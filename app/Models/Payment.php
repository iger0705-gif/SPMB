<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'pendaftar_id',
        'no_pembayaran',
        'jumlah',
        'jenis_pembayaran',
        'status',
        'bukti_pembayaran',
        'tanggal_bayar',
        'catatan'
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
