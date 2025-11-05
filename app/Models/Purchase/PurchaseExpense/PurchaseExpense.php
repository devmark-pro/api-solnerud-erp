<?php

namespace App\Models\Purchase\PurchaseExpense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\User\User;
use App\Models\Counterparty\Counterparty;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseDocument;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseObserver;



#[ObservedBy([PurchaseExpenseObserver::class])]
class PurchaseExpense extends Model
{
    protected $fillable = [
        'id',
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
        
        'nds_type',     // Тип НДС  
                        // no_nds  - Без НДС
                        // nds_in_price - НДС включен в цену
                        // nds_not_in_price - НДС не включен в цену

        'nds_rate_id',                
        'reimbursement_date',       // Дата возмещения расходов
        'purchase_id',
        'deleted_at',
    ];
    
    protected $with = [
        'addresses',
        'executorCounterparty',
        'executorUser',
        'documents'
    ];
   


    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
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
        return $this->hasMany(PurchaseExpenseDocument::class)->where(['deleted_at'=>null]);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(PurchaseExpenseAddress::class)->where(['deleted_at'=>null]);
    }
}
