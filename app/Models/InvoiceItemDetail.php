<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemDetail extends Model
{
    protected $table = 'invoice_item_details';

    protected $fillable = [
        'invoice_item_id',
        'p',
        'l',
        't',
        'koli',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'decimal:4',
    ];

    public function item()
    {
        return $this->belongsTo(InvoiceItem::class, 'invoice_item_id');
    }
}
