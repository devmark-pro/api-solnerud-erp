<?php

namespace App\Models\Expense;

use App\Services\Expense\Expense\ExpenseObserver;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
use App\Models\User\User;
use App\Models\Counterparty\Counterparty;
use App\Models\Directory\TypeFlowDirectory;
use App\Models\Expense\ExpenseDocument;


#[ObservedBy([ExpenseObserver::class])]
class Expense extends Model
{
    protected $fillable = [
        'id',
        'service_date_from', // Дата услуги
        'service_date_to', 
        'warehouse_id',
        'type_flow_id',     // Тип расхода
        'name',         // Наименование 

        'executor_type',    // тип исполнителя
                        //  user - Сотрудник
                        //  counterparty - Контрагент

        'executor_user_id',
        'executor_counterparty_id',
        'rate',         // Ставка  Руб
        'quantity',     // Количество
        'summ',         // Сумма
        'summ_nds',     // Сумма НДС
                        // Документы HasMany documents

        'nds_rate',
        'nds_rate_id',
        'is_nds_in_price',    

        'include_in_cost',          // Учет в себес.


        'reimbursement_expenses',   // Возмещ. расходов
                                    //    'refunded',     // Возмещен
                                    //    'required',     // Требуется   
                                    //    'not_required'  // Не требуется  
        
        'reimbursement_date',       // Дата возмещения
        'deleted_at',
    ];

    protected $with = [
        'typeFlow',
        'warehouse',
        'executorUser',
        'executorCounterparty',
        'documents'
    ];

    public function warehouse(): BelongsTo 
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function typeFlow(): BelongsTo 
    {
        return $this->belongsTo(TypeFlowDirectory::class);
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
        return $this->hasMany(ExpenseDocument::class)->where(['deleted_at'=>null]);
    }
}
