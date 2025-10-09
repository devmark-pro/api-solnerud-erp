<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;

// Адреса доставки
class PurchaseDeliveryAddress extends Model
{
    protected $table = 'purchase_delivery_addresses';

    protected $fillable = [
        'id',
        'address',
        'planned_quantity', // плановое количество
        'purchase_id',
        'deleted_at',
    ];

    protected $appends = [ 
        'actual_quantity',  // фактическое количество
        'remained',         // осталось
        'cost',             // Себестоимость
    ];


    public function getActualQuantityAttribute() 
    {
        return 'После Покупок';
    }

    public function getRemainedAttribute() 
    {
        return 'После Покупок';
    }

    public function getCostAttribute() 
    {
        return 'После Покупок';
    }

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }

}
