<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
    ];

    public function invoicesAsPengirim(): HasMany
    {
        return $this->hasMany(Invoice::class, 'pengirim_id');
    }

    public function invoicesAsPenerima(): HasMany
    {
        return $this->hasMany(Invoice::class, 'penerima_id');
    }
}
