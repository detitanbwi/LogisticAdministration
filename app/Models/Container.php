<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Container extends Model
{
    protected $table = 'container';

    protected $fillable = [
        'nomor_container',
        'kapal_id',
        'asal_id',
        'tujuan_id',
        'etd',
        'eta',
        'tipe_kontainer',
        'catatan',
        'catatan_invoicing',
        'catatan_finance',
        'total_pembayaran_manual',
    ];

    protected $casts = [
        'etd' => 'date',
        'eta' => 'date',
        'total_pembayaran_manual' => 'decimal:2',
    ];

    public function kapal(): BelongsTo
    {
        return $this->belongsTo(Kapal::class);
    }

    public function asal(): BelongsTo
    {
        return $this->belongsTo(Tujuan::class, 'asal_id');
    }

    public function tujuan(): BelongsTo
    {
        return $this->belongsTo(Tujuan::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function operationalCosts(): HasMany
    {
        return $this->hasMany(ContainerOperationalCost::class);
    }
}
