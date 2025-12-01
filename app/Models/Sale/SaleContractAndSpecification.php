<?php

namespace App\Models\Sale;

use App\Services\Sale\SaleContractAndSpecification\SaleContractAndSpecificationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sale\Sale;
use App\Models\User\User;

#[ObservedBy([SaleContractAndSpecificationObserver::class])]
class SaleContractAndSpecification extends Model
{
    protected $fillable = [
        'id',
        'number',
        'contract_type', //Договор / Спецификация R
        'summ',
        'summ_nds',
        'nds_type',     // Тип НДС  
                        // no_nds  - Без НДС
                        // nds_in_price - НДС включен в цену
                        // nds_not_in_price - НДС не включен в цену
        'file',
        'sale_id',
        'user_id',
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
