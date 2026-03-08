<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceAdditionalFee extends Model
{
    public $timestamps = false;
    protected $fillable = ['invoice_id', 'nama', 'harga'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
