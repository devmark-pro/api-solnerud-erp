<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Directory\StatusPurchaseDirectory;
use App\Models\Directory\PurchaseTypeDirectory;
use App\Models\Directory\PackingTypeDirectory;
use App\Models\Directory\DeliveryMethodDirectory;
use App\Models\Counterparty;
use App\Models\Nomenclature;
use App\Models\Client;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\PurchaseInvoice;
use App\Models\Purchase\PurchaseAccountSupplier;
use App\Models\Purchase\PurchaseExpenses;
use App\Models\Purchase\PurchaseDocument;

// Покупки
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
        'price',            // цена за тонну
        'count_plan',       // количество план
                            // адрес отгрузки
        'comment', 
        'created_at',
        'deleted_at',
    ];

    protected $appends = [ 
        'count',        //  Количество  = "Кол-во план" и  "Кол-во факт" из карточки покупки
        'summ',         //  Сумма поступлений = "Сумма поступлений" из карточки покупки
        'summ_nds'      //  Сумма НДС 
    ];


    public function getCountAttribute() 
    {
        return '= "Кол-во план" и  "Кол-во факт" из карточки покупки' ;
    }
    public function getSummAttribute() 
    {
        return '= "Сумма поступлений" из карточки покупки';
    }
    public function getSummNdsAttribute() 
    {
        return  '= "Сумма НДС" из карточки покупки';
    }
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
    public function deliveryAddress(): HasMany
    {
        return $this->hasMany(PurchaseDeliveryAddress::class);
    }
    public function invoice(): HasMany
    {
        return $this->hasMany(PurchaseInvoice::class);
    }
    public function accountSupplier(): HasMany
    {
        return $this->hasMany(PurchaseAccountSupplier::class);
    }
    public function receipts(): HasMany
    {
        return $this->hasMany(PurchaseReceipt::class);
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(PurchaseExpenses::class);
    }
    public function document(): HasMany
    {
        return $this->hasMany(PurchaseDocument::class);
    }
}
