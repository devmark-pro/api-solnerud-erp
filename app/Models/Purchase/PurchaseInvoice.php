<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;
use App\Models\User\User;

// Счет фактура
class PurchaseInvoice extends Model
{
    protected $fillable = [
        'id',
        'number',
        'date',
        'summ',
        'summ_nds',
        'nds_type',     // Тип НДС  
                        // no_nds  - Без НДС
                        // nds_in_price - НДС включен в цену
                        // nds_not_in_price - НДС не включен в цену
        'nds_rate',
        'nds_rate_id',                
      
        'user_id',
        'file',
        'purchase_id',
        'deleted_at',
    ];

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

}

