<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'no_invoice',
        'kapal_id',
        'asal_id',
        'tujuan_id',
        'pengirim_id',
        'penerima_id',
        'up',
        'etd',
        'eta',
        'tgl_masuk',
        'container_id',
        'metode',
        'tipe_kontainer',
        'layanan',
        'status_pembayaran',
        'pkp_status',
        'terima_barang',
        'catatan_muntahan',
    ];

    protected $casts = [
        'etd' => 'date',
        'eta' => 'date',
        'tgl_masuk' => 'date',
        'terima_barang' => 'date',
    ];

    public function kapal(): BelongsTo
    {
        return $this->belongsTo(Kapal::class);
    }

    public function tujuan(): BelongsTo
    {
        return $this->belongsTo(Tujuan::class);
    }

    public function asal(): BelongsTo
    {
        return $this->belongsTo(Tujuan::class, 'asal_id');
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'pengirim_id');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'penerima_id');
    }

    public function upDetail(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'up');
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class, 'container_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function finance(): HasOne
    {
        return $this->hasOne(Finance::class);
    }
}
