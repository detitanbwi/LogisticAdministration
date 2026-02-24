<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangPiutang extends Model
{
    use HasFactory;

    protected $table = 'hutang_piutang';

    protected $fillable = [
        'kode',
        'jenis',
        'tanggal',
        'keterangan',
        'nominal',
    ];
}
