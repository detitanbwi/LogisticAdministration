<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kapal extends Model
{
    protected $table = 'kapal';

    protected $fillable = [
        'nama_kapal',
    ];

    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Invoice::class, Container::class);
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class);
    }
}
