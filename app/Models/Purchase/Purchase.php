<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Directory\StatusPurchaseDirectory;
use App\Models\Directory\PurchaseTypeDirectory;
use App\Models\Directory\PackingTypeDirectory;
use App\Models\Directory\DeliveryMethodDirectory;
use App\Models\Counterparty\Counterparty;
use App\Models\Nomenclature;
use App\Models\Client\Client;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\PurchaseInvoice;
use App\Models\Purchase\PurchaseAccountSupplier;
use App\Models\Purchase\PurchaseExpenses;
use App\Models\Purchase\PurchaseDocument;
use App\Models\Purchase\PurchaseReceipt;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Services\Purchase\Purchase\PurchaseObserver;

use Illuminate\Support\Facades\Log;





// Покупки

#[ObservedBy([PurchaseObserver::class])]
class Purchase extends Model
{
    protected $fillable = [
        'id',
        'status_purchase_id',
        'purchase_type',    //
        'counterparty_id',  //Поставщик
        'nomenclature_id',  //Продукт
        'client_id',
        'packing_type_id',  // Тип фасовки
        'delivery_method_id', // способ доставки
        'price',            // цена за тонну
        'count_plan',       // количество план
                            // адрес отгрузки

        'quantity',
        'count',
        'nds_type',
        'nds_rate_id',
        'summ',
        'summ_nds',
        'comment', 
 
        'created_at',
        'deleted_at',
    ];

    public function statusPurchase():BelongsTo 
    {
        return $this->belongsTo(StatusPurchaseDirectory::class);
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
