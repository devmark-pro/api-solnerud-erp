<?php

namespace App\Models\Sale\SaleProduct;

use App\Services\Sale\SaleProduct\SaleProductObserver;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\Client\ClientWarehouse;
use App\Models\Counterparty\CounterpartyWarehouse;


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

        // 'purchase_id',
        'purchase_address_id',
        'total_cost',
        
        'price',
        'summ',     //'= Цена * Количество (тн)
        'summ_nds',
        'nds_rate',
        'nds_rate_id',     
        'is_nds_in_price',
        'profit',   // прибыль '= Сумма - (Себестоимость * Количество (тн))
        'address_id',   // Адрес

        'delivery_method_id', // способ доставки
        // 'delivery_address',  //__ Адрес доставки
        'client_warehouse_id',
        'delivery_date',    // Срок поставки (скрыто по умолчанию)
        'shipped',           // Отгружено  (скрыто по умолчанию)
        'remains_ship',       // Осталось  (скрыто по умолчанию)
        'shipment_summ',   // Сумма отгрузки (скрыто по умолчанию)
        'shipment_summ_nds',   // Сумма ндс отгрузки (скрыто по умолчанию)
        'shipment_is_nds_in_price',
        'shipment_nds_rate',
        'shipment_nds_rate_id',
        'counterparty_warehouse_id',
        'comment',
        'sale_id',
        'cost_formula',
        'profit_formula',
        'is_updatable',
        'deleted_at',
        'purchases'
    ];

    protected $with = [
        'nomenclature',
        'packingType',
        'deliveryMethod',
        'warehouse',
        'counterparty',
        'purchaseAddress',
        'clientWarehouse',
        'counterpartyWarehouse'
    ];
    protected $appends = [ 
        'purchase_ids',
        // 'warehouse_remains_ids',
        // 'warehouse_remains_purchase_ids',
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

    public function purchaseAddress(): BelongsTo 
    {
        return $this->belongsTo(PurchaseDeliveryAddress::class);
    }

    public function counterpartyWarehouse(): BelongsTo 
    {
        return $this->belongsTo(CounterpartyWarehouse::class);
    }
    public function clientWarehouse(): BelongsTo 
    {
        return $this->belongsTo(ClientWarehouse::class);
    }
    
    public function getPurchaseIdsAttribute(){
        return SaleProductPurchase::where([
            "deleted_at" => null,
            "sale_id" => $this->sale_id,
			"sale_product_id" => $this->id,
        ])
        ->select('id', 'purchase_id')
        ->get()->pluck('purchase_id');
    }
}
