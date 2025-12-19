<?php

namespace App\Models\WarehouseRemains;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nomenclature;
use App\Models\Warehouse;
use App\Models\Purchase\Purchase;
use App\Models\Directory\PackingTypeDirectory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Services\WarehouseRemains\WarehouseRemains\WarehouseRemainsObserver;


#[ObservedBy([WarehouseRemainsObserver::class])]
class WarehouseRemains extends Model
{
    protected $fillable = [
        'id',
        'nomenclature_id',
        'purchase_id',
        'packing_type_id',     // Тип фасовки
        'warehouse_id',
        'actual_quantity',  // Наличие       
        'reserve',          // Резрв
        'availability',     // Доступно
        'cost',             // Себестоимость
        'purchase_delivery_address_id',
        'deleted_at',
    ];
    protected $with= [
        'nomenclature',
        'packingType',
        'warehouse',
        'purchase'
    ];

    
    public function nomenclature():BelongsTo 
    {
        return $this->belongsTo(Nomenclature::class);
    }
    public function packingType():BelongsTo 
    {
        return $this->belongsTo(PackingTypeDirectory::class);
    }
    public function warehouse():BelongsTo 
    {
        return $this->belongsTo(Warehouse::class);
    }

    
    public function purchase():BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
}

