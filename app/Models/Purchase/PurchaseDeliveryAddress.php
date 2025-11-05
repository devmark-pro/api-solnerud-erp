<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Warehouse;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseExpense\PurchaseExpense;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;
use App\Models\Purchase\PurchaseReceipt;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
// use App\Observers\PurchaseDeliveryAddressObserver;
use App\Services\Purchase\PurchaseDeliveryAddress\PurchaseDeliveryAddressObserver;


// Адреса доставки
#[ObservedBy([PurchaseDeliveryAddressObserver::class])]
class PurchaseDeliveryAddress extends Model
{
    protected $table = 'purchase_delivery_addresses';

    protected $fillable = [
        'id',
        'address',
        'planned_quantity', // плановое количество
        'actual_quantity', // фактическое количество
        'remaining_quantity', // осталось
        'cost',             // себестоимость
        'warehouse_id',
        'purchase_id',
        'deleted_at',
    ];

    

    protected $with = [
        'warehouse'
    ];

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function warehouse(): BelongsTo 
    {
        return $this->belongsTo(Warehouse::class);
    }

}
