<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    /**
     * Get the invoices for the service.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
