<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseDeliveryAddress;


class PurchaseExpense extends Model
{
    protected $fillable = [
        'id',
        'service_date_from', // Дата услуги
        'service_date_to', 
        'address_id',   // Товар
        'name',         // Наименование 
        // 'executor',     // Исполнитель
        'rate',         // Ставка  Руб
        'quantity',     // Количество
        'summ',         // Сумма
        'summ_nds',     // Сумма НДС
                        // Документы HasMany documents
        'include_in_cost',          // Учет в себес.

        'executor_type',    // user | counterparty
        'executor_user_id',
        'executor_counterparty_id',

        'reimbursement_expenses',   // Возмещ. расходов
                                    //    'refunded',     // Возмещен
                                    //    'required',     // Требуется   
                                    //    'not_required'  // Не требуется  
              
        'reimbursement_date',       // Дата возмещения расходов
        'purchase_id',
        'deleted_at',
    ];

    protected $with=[
        'address'
    ];
   


    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function address(): BelongsTo 
    {
        return $this->belongsTo(PurchaseDeliveryAddress::class);
    }

}
