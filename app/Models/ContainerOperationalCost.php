<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContainerOperationalCost extends Model
{
    protected $table = 'container_operational_costs';

    protected $fillable = [
        'container_id',
        'komponen',
        'nominal',
        'tanggal_transfer',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal_transfer' => 'date',
    ];

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }
}
