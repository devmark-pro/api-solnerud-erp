<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;


class PurchaseDeliveryAddress extends Model
{
    protected $table = 'purchase_delivery_addresses';

    protected $fillable = [
        'id',
        'address',
        'planned_quantity', // плановое количество
        'actual_quantity',  // фактическое количество
        'remained',         // осталось
        'purchase_id',
        'deleted_at',
    ];

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }

}
