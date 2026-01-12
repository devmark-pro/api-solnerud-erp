<?php

namespace App\Models\Client;

use App\Services\Client\ClientWarehouse\ClientWarehouseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[ObservedBy([ClientWarehouseObserver::class])]
class ClientWarehouse extends Model
{
    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'client_id',
        'deleted_at',
    ];

    public function client(): BelongsTo 
    {
        return $this->belongsTo(Client::class);
    }
}
