<?php

namespace App\Models\Sale\SaleProduct;

use App\Services\Sale\SaleProduct\SaleProductObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\Nomenclature;
use App\Models\Warehouse;
use App\Models\Counterparty\Counterparty;
use App\Models\Purchase\Purchase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Directory\PackingTypeDirectory;
use App\Models\Directory\DeliveryMethodDirectory;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleProduct\SaleProductPurchase;




#[ObservedBy([SaleProductObserver::class])]
class SaleProduct extends Model
{
    protected $fillable = [
        'id',
        'nomenclature_id',
        'packing_type_id',  // Тип фасовки для клиента
        'is_request_shipment',  // Заявка на отгрузку
        'shipment_type',         // from_warehouse/ from_factory  Со склада / С завода  
        'warehouse_id',     // Адрес отгрузки
        'counterparty_id',
        'quantity',
        'availability',     // Доступно
        'cost',
        'price',
        'summ',     //'= Цена * Количество (тн)
        'summ_nds',
        'nds_rate',
        'nds_rate_id',     
        'is_nds_in_price',
        'profit',   // прибыль '= Сумма - (Себестоимость * Количество (тн))

        'delivery_method_id', // способ доставки
        'delivery_address',  // Адрес доставки
        'delivery_date',    // Срок поставки (скрыто по умолчанию)
        'shipped',           // A Отгружено  (скрыто по умолчанию)
        'remains_ship',       // A Осталось  (скрыто по умолчанию)
        'shipment_summ',   // Сумма отгрузки (скрыто по умолчанию)
        'shipment_summ_nds',   // Сумма ндс отгрузки (скрыто по умолчанию)
        'shipment_is_nds_in_price',
        'shipment_nds_rate',
        'shipment_nds_rate_id',           
        'comment',
        'sale_id',
        'deleted_at',
        'purchases'
    ];

    protected $with = [
        'nomenclature',
        'packingType',
        'deliveryMethod',
        'warehouse',
        'counterparty'
    ];
    protected $appends = [ 
        'purchase_ids',
        'warehouse_remains_ids',
        'warehouse_remains_purchase_ids',
    ];

    public function nomenclature():BelongsTo 
    {
        return $this->belongsTo(Nomenclature::class);
    }

    public function packingType():BelongsTo 
    {
        return $this->belongsTo(PackingTypeDirectory::class);
    }

    
    public function deliveryMethod():BelongsTo 
    {
        return $this->belongsTo(DeliveryMethodDirectory::class);
    }
    
    public function warehouse():BelongsTo 
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function counterparty():BelongsTo 
    {
        return $this->belongsTo(Counterparty::class);
    }

    
    
    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }

    public function getPurchaseIdsAttribute(){
        if($this->shipment_type==="from_factory") {
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_id" => $this->sale_id,
				"sale_product_id" => $this->id,
            ])->select('id', 'purchase_id', 'warehouse_remains_id')
                ->get()->toArray(); 
            $result = array_map(function($item) {
                return  $item['purchase_id'];
            }, $saleProductPurchase);
            return $result;
        }

        return null;
    }
    public function getWarehouseRemainsIdsAttribute(){
        if($this->shipment_type==="from_warehouse") {
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_id" => $this->sale_id,
				"sale_product_id" => $this->id,
            ])
            ->select('id', 'warehouse_remains_id')
            ->get()->toArray();

            $result = array_map(function($item) {
                return $item['warehouse_remains']['id'];
            }, $saleProductPurchase);
            return $result;
        }
        return null;
    }
    public function getWarehouseRemainsPurchaseIdsAttribute(){
        if($this->shipment_type==="from_warehouse") {
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_id" => $this->sale_id,
				"sale_product_id" => $this->id,
            ])
            ->select('id', 'warehouse_remains_id')
            ->get()->toArray();

            $result = array_map(function($item) {
                return $item['warehouse_remains']['purchase_id'];
            }, $saleProductPurchase);
            return $result;
        }
        return null;
    }

}
