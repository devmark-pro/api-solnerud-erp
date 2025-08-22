<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase;


class DeliveryAddress extends Model
{
    protected $table = 'delivery_addresses';

    protected $fillable = [
        'id',
        'address',
        'planned_quantity', // плановое количество
        'actual_quantity',  // фактическое количество
        'remained',         // осталось
        'cost',             // себестоимость
        'purchase_id',
        'deleted_at',
    ];

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }

}
