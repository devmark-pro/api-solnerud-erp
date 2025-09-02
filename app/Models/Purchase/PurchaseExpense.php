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
        'service_date', // Дата услуги
        'address_id',   // Товар
        'name',         // Наименование 
        'executor',     // Исполнитель
        'rate',         // Ставка
        'quantity',     // Количество
        'summ',         // Сумма
        'summ_nds',     // Сумма НДС
                        // Документы HasMany documents
        'include_in_cost',          // Учет в себес.
        'reimbursement_expenses',   // Возмещ. расходов
        'reimbursement_date',       // Дата возмещения расходов
        'purchase_id',
        'deleted_at',
    ];


    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function address(): BelongsTo 
    {
        return $this->belongsTo(PurchaseDeliveryAddress::class);
    }

/*

    use Illuminate\Database\Eloquent\Relations\HasMany;
    public function _(): HasMany
    {
        return $this->hasMany(_::class);
    }
*/
}
