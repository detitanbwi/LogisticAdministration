<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'tanggal',
        'jenis',
        'transaksi_kategori_id',
        'nominal',
        'keterangan',
        'bank_rekening_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(TransaksiKategori::class, 'transaksi_kategori_id');
    }

    public function rekening()
    {
        return $this->belongsTo(BankRekening::class, 'bank_rekening_id');
    }
}
