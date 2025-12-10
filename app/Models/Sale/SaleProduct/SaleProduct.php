<?php

namespace App\Models\Sale\SaleProduct;

use App\Services\Sale\SaleProduct\SaleProductObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\Nomenclature;
use App\Models\Warehouse;
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
        // 'client_packing_type_id',          
        'shipment',         // from_warehouse/ from_factory  Со склада / С завода  R
        'warehouse_id',     // Адрес отгрузки
        'counterparty_id',
        'purchase_id',   
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
    ];

    protected $with = [
        'nomenclature',
        'packingType',
        'deliveryMethod',
        'warehouse',
    ];
    protected $appends = [ 
        'purchases',
        // 'shipping_address'
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

    
    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }

    public function getPurchasesAttribute(){
        if($this->shipment==="from_warehouse") {
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_id" => $this->sale_id,
				"sale_product_id" => $this->id,
            ])
            ->select('id', 'warehouse_remains_id', 'quantity')
            ->get()->toArray();

            $result = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'purchase_id' => $item['warehouse_remains']['purchase_id'],
                    'quantity' => $item['quantity'],
                    'warehouse_remains_id' => $item['warehouse_remains_id'],
                    'shipping_address' => [
                        'name' => $item['warehouse_remains']['warehouse']['name'],
                        'address' => $item['warehouse_remains']['warehouse']['address']
                    ]
                ];
            }, $saleProductPurchase);
            return $result;
        }

        if($this->shipment==="from_factory") {
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_id" => $this->sale_id,
				"sale_product_id" => $this->id,
            ])->select('id', 'purchase_id', 'warehouse_remains_id', 'quantity')
            ->get()->toArray();
            
            $result = array_map(function($item) {

                return [
                  'id' => $item['id'],
                    'purchase_id' => $item['purchase_id'],
                    'quantity' => $item['quantity'],
                    'warehouse_remains_id' => $item['warehouse_remains_id'],
                    'shipping_address' => [
                        'name' => $item['purchase']['counterparty']['name'],
                        'address' => $item['purchase']['counterparty']['address']
                    ]
                ];
            
            }, $saleProductPurchase);
            return $result;

        }

        return null;
    }

}
