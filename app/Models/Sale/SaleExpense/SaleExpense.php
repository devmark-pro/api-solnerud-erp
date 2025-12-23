<?php

namespace App\Models\Sale\SaleExpense;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleDeliveryAddress;
use App\Models\Counterparty\Counterparty;
use App\Models\Sale\SaleExpense\SaleExpenseDocument;
use App\Services\Sale\SaleExpense\SaleExpense\SaleExpenseObserver;
use App\Models\Sale\SaleExpense\SaleExpenseProduct;

#[ObservedBy([SaleExpenseObserver::class])]
class SaleExpense extends Model
{
    protected $fillable = [
        'id',
        'date',
        'sale_product_id',
        'service_date_from', // Дата услуги
        'service_date_to', 
        'name',         // Наименование 
        'rate',         // Ставка  Руб
        'quantity',     // Количество
        'summ',         // Сумма
        'summ_nds',     // Сумма НДС
                        // Документы HasMany documents
        'include_in_cost',          // Учет в себес.

        'executor_type',    // тип исполнителя
                        //  user - Сотрудник
                        //  counterparty - Контрагент

        'cost',                
        'nds_rate',
        'is_nds_in_price',
        'executor_user_id',
        'executor_counterparty_id',
        'nds_rate_id',

        'reimbursement_expenses',   // Возмещ. расходов
                                    //    'refunded',     // Возмещен
                                    //    'required',     // Требуется   
                                    //    'not_required'  // Не требуется  
        
        
        'reimbursement_date',       // Дата возмещения расходов
        'sale_id',
        'deleted_at',
    ];

    protected $with = [
        'documents',
        'executorCounterparty',
        'executorUser',
    ];


    protected $appends = [ 
        'sale_product_ids',
    ];

    
    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }

    public function executorUser(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
    public function executorCounterparty(): BelongsTo 
    {
        return $this->belongsTo(Counterparty::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SaleExpenseDocument::class)->where(['deleted_at'=>null]);
    }

    public function getSaleProductIdsAttribute(){
        return SaleExpenseProduct::where([
            "deleted_at" => null,
            "sale_id" => $this->sale_id,
			"sale_expense_id" => $this->id,
        ])->select('id', 'sale_product_id')
        ->get()
        ->pluck('sale_product_id');             
    }
}

