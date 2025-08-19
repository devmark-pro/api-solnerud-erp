<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Directory\StatusPurchaseDirectory;
use App\Models\Directory\PurchaseTypeDirectory;
use App\Models\Directory\PackingTypeDirectory;
use App\Models\Directory\DeliveryMethodDirectory;
use App\Models\Counterparty;
use App\Models\Nomenclature;
use App\Models\Client;

  
class Purchase extends Model
{
    protected $fillable = [
        'id',
        'status_purchase_id',
        'purchase_type_id',
        'counterparty_id',  //Поставщик
        'nomenclature_id',  //Продукт
        'client_id',
        'packing_type_id',  // Тип фасовки
        'delivery_method_id', // способ доставки
        'price',            //цена за тонну
        'count_plan',       //количество план
                            //адрес отгрузки
        'comment', 
        'created_at',
        'deleted_at',
    ];

    public function statusPurchase():BelongsTo 
    {
        return $this->belongsTo(StatusPurchaseDirectory::class);
    }
    public function purchaseType():BelongsTo 
    {
        return $this->belongsTo(PurchaseTypeDirectory::class);
    }
    public function counterparty():BelongsTo 
    {
        return $this->belongsTo(Counterparty::class);
    }
    public function nomenclature():BelongsTo 
    {
        return $this->belongsTo(Nomenclature::class);
    }
    public function client():BelongsTo 
    {
        return $this->belongsTo(Client::class);
    }
    public function packingType():BelongsTo 
    {
        return $this->belongsTo(PackingTypeDirectory::class);
    }
    public function deliveryMethod():BelongsTo 
    {
        return $this->belongsTo(DeliveryMethodDirectory::class);
    }
}
