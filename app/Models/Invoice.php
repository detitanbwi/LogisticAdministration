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
        'pengirim_id',
        'penerima_id',
        'up',
        'tgl_masuk',
        'container_id',
        'metode',
        'layanan_id',
        'tujuan_daerah_id',
        'status_pembayaran',
        'pkp_status',
        'terima_barang',
        'catatan_muntahan',
        'tanda_terima',
        'show_stamp',
    ];

    protected $casts = [
        'tgl_masuk' => 'date',
        'terima_barang' => 'date',
        'show_stamp' => 'boolean',
    ];



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

    public function additionalFees(): HasMany
    {
        return $this->hasMany(InvoiceAdditionalFee::class);
    }

    public function finance(): HasOne
    {
        return $this->hasOne(Finance::class);
    }

    public function tujuanDaerah(): BelongsTo
    {
        return $this->belongsTo(TujuanDaerah::class, 'tujuan_daerah_id');
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
