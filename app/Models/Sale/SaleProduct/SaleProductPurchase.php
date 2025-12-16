<?php

namespace App\Models\Sale\SaleProduct;

use App\Services\Sale\SaleProduct\SaleProductPurchase\SaleProductPurchaseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use App\Models\WarehouseRemains\WarehouseRemains;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;


#[ObservedBy([SaleProductPurchaseObserver::class])]
class SaleProductPurchase extends Model
{
    protected $fillable = [
        'id',
        'purchase_id',
        'warehouse_remains_id',
        'shipment_type',
        'sale_id',
        'sale_product_id',
        'deleted_at',
    ];

    protected $with = [
        'warehouseRemains',
        'purchase'
    ];

    public function warehouseRemains(): BelongsTo 
    {
        return $this->belongsTo(WarehouseRemains::class);
    }
    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }

}
