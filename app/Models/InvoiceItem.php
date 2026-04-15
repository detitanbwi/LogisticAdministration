<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'jenis_barang',
        'koli',
        'p',
        'l',
        't',
        'jumlah',
        'satuan',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah' => 'decimal:4',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function details()
    {
        return $this->hasMany(InvoiceItemDetail::class, 'invoice_item_id');
    }
}
