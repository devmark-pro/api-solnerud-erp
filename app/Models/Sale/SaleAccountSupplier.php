<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sale\Sale;
use App\Models\Directory\PaymentTypeDirectory;

// Счет поставщика
class SaleAccountSupplier extends Model
{

    protected $fillable = [
        'id',
        'payment_type_id',  // Тип оплаты 
        'nds_type',

        'summ',         
        'summ_nds',
        'nds_type',     // Тип НДС  
                        // no_nds  - Без НДС
                        // nds_in_price - НДС включен в цену
                        // nds_not_in_price - НДС не включен в цену
        'nds_rate',
        'nds_rate_id',                
   
        'paid',             // оплачено      
        'remained',         // осталось
        'payment_date',     // срок оплаты
        'sale_id',
        'deleted_at',
    ];

    protected $with = [
        'paymentType'
    ];
    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }
    public function paymentType(): BelongsTo 
    {
        return $this->belongsTo(PaymentTypeDirectory::class);
    }
}

