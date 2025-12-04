<?php

namespace App\Models\Sale;

use App\Services\Sale\SaleProduct\SaleProductObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use App\Models\Directory\PackingTypeDirectory;
use App\Models\Directory\DeliveryMethodDirectory;
use App\Models\Sale\Sale;


#[ObservedBy([SaleProductObserver::class])]
class SaleProduct extends Model
{
    protected $fillable = [
        'id',
        'packing_type_id',  // Тип фасовки R
        'client_packing_type_id',  // Тип фасовки для клиента
        'shipment',         //  Со склада / С завода  R
        'warehouse_id',     // Адрес отгрузки

        'purchase_id',   
        'quantity',
        'availability',     // Доступно
        'cost',
        'price',
        'summ',     //'= Цена * Количество (тн)
        'summ_nds',
        'nds_type',
        'nds_rate',
        'nds_rate_id',           
        'profit',   // прибыль '= Сумма - (Себестоимость * Количество (тн))

        'delivery_method_id', // способ доставки
        'delivery_date',    // Срок поставки (скрыто по умолчанию)
        'shipped',           //Отгружено (скрыто по умолчанию)
        'remains_ship',       // Осталось (скрыто по умолчанию)
        'shipment_summ',   // Сумма отгрузки (скрыто по умолчанию)
        'shipment_summ_nds',   // Сумма ндс отгрузки (скрыто по умолчанию)
        
        'shipment_nds_rate',
        'shipment_nds_rate_id',           
        
        'sale_id',
        'deleted_at',
    ];


    public function packingType():BelongsTo 
    {
        return $this->belongsTo(PackingTypeDirectory::class);
    }

    public function clientPackingType():BelongsTo 
    {
        return $this->belongsTo(PackingTypeDirectory::class, 'client_packing_type_id');
    }

    public function deliveryMethod():BelongsTo 
    {
        return $this->belongsTo(DeliveryMethodDirectory::class);
    }
    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }

}
