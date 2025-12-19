<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sale\Sale;
use App\Models\User\User;

// Счет фактура
class SaleInvoice extends Model
{
    protected $fillable = [
        'id',
        'number',
        'date',
        'summ',
        'summ_nds',
        'is_nds_in_price',       
                        // no_nds  - Без НДС
                        // nds_in_price - НДС включен в цену
                        // nds_not_in_price - НДС не включен в цену
        'nds_rate',
        'nds_rate_id',                
      
        'user_id',
        'file',
        'sale_id',
        'deleted_at',
    ];

    protected $hidden = [
        'file'
    ];
    
    protected $appends = [
        'is_file_added',
    ];
    

    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function getIsFileAddedAttribute() 
    {
        return (bool)$this->file;
    }

}


