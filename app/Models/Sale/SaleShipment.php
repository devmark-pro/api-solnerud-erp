<?php

namespace App\Models\Sale;

use App\Services\Sale\SaleShipment\SaleShipmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sale\Sale;
use App\Models\User\User;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Models\Sale\SaleProduct\SaleProductPurchase;



#[ObservedBy([SaleShipmentObserver::class])]
class SaleShipment extends Model
{
    protected $fillable = [
        'id',
        'shipment_date',    // Дата отгрузки
        'file',
        'file_number',
        'file_date',
        'sale_product_id',      // Товар
        'sale_product_purchase_id',
        'shipped_quantity',          // Отгружено
        "transport",
        'user_id',          // Ответственный
        'sale_id',
        'deleted_at',
      ];

    protected $hidden = [
        'file'
    ];
    
    protected $appends = [
        'is_file_added',
    ];

    protected $with = [
        'saleProduct',
        'saleProductPurchase'
    ];

    public function saleProduct(): BelongsTo 
    {
        return $this->belongsTo(SaleProduct::class);
    }

    public function saleProductPurchase(): BelongsTo 
    {
        return $this->belongsTo(SaleProductPurchase::class);
    }

    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }

    
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function getIsFileAddedAttribute() 
    {
        return (bool)$this->file;
    }

}
