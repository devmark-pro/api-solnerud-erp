<?php

namespace App\Models\Counterparty;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\Counterparty\CounterpartyWarehouse\CounterpartyWarehouseObserver;

#[ObservedBy([CounterpartyWarehouseObserver::class])]
class CounterpartyWarehouse extends Model
{
    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'counterparty_id',
        'deleted_at',
    ];
    
    public function counterparty(): BelongsTo 
    {
        return $this->belongsTo(Counterparty::class);
    }
}

