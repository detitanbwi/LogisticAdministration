<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKategori extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
    ];
}
