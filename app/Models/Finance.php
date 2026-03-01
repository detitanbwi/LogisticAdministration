<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Finance extends Model
{
    protected $table = 'finance';

    protected $fillable = [
        'invoice_id',
        'total_tagihan',
        'ditagih_ke',
        'status_tagihan',
        'tanggal_tagih',
        'tgl_transfer',
        'catatan',
        'bap_balik',
    ];

    protected $casts = [
        'total_tagihan' => 'decimal:2',
        'tgl_transfer' => 'date',
        'tanggal_tagih' => 'date',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
