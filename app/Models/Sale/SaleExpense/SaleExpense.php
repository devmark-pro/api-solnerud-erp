<?php

namespace App\Models\Sale\SaleExpense;

use App\Services\Sale\SaleExpense\SaleExpense\SaleExpenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\Counterparty\Counterparty;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleDeliveryAddress;
use App\Models\Sale\SaleExpense\SaleExpenseDocument;
use App\Models\Sale\SaleExpense\SaleExpenseAddress;

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

        'executor_user_id',
        'executor_counterparty_id',

        'reimbursement_expenses',   // Возмещ. расходов
                                    //    'refunded',     // Возмещен
                                    //    'required',     // Требуется   
                                    //    'not_required'  // Не требуется  
        
        'nds_rate',
        'nds_rate_id',
        'is_nds_in_price',    
        'reimbursement_date',       // Дата возмещения расходов
        'sale_id',
        'deleted_at',
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

    public function addresses(): HasMany
    {
        return $this->hasMany(SaleExpenseAddress::class)->where(['deleted_at'=>null]);
    }

}

