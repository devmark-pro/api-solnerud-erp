<?php

namespace App\Models\Sale;

use App\Services\Sale\Sale\SaleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Counterparty\Counterparty;
use App\Models\Client\Client;
use App\Models\Directory\StatusSaleDirectory;
use App\Models\Sale\SaleProduct\SaleProduct;


#[ObservedBy([SaleObserver::class])]
class Sale extends Model
{
     protected $fillable = [
        'id',
        'status_sale_id',       // Статус в названии товара (в шапке)
        'counterparty_id',      // Юридическое лицо
        'summ',         // Итоговая сумма
        'summ_nds',     //Сумма НДС
        'quantity',     //Количество
        'client_id',    //Покупатель
        'comment',
        'created_at',
        'deleted_at',
    ];

    protected $with = [
        'client',
        'counterparty',
        'statusSale',
        'products'
    ];


    public function statusSale():BelongsTo 
    {
        return $this->belongsTo(StatusSaleDirectory::class);
    }
    public function counterparty(): BelongsTo 
    {
        return $this->belongsTo(Counterparty::class);
    }

    public function client(): BelongsTo 
    {
        return $this->belongsTo(Client::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(SaleProduct::class)->where('deleted_at', null);
    }
}
