<?php

namespace App\Models\Purchase\PurchaseExpense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User\User;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseExpense;
use App\Models\Purchase\PurchaseDeliveryAddress;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseAddress\PurchaseExpenseAddressObserver;



#[ObservedBy([PurchaseExpenseAddressObserver::class])]
class PurchaseExpenseAddress extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'purchase_id',
        'purchase_expense_id',
        'address_id',
        'deleted_at',
    ];

    protected $with = [
        'address'
    ];

    public function purchaseExpense(): BelongsTo 
    {
        return $this->belongsTo(PurchaseExpense::class);
    }
    
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo 
    {
        return $this->belongsTo(PurchaseDeliveryAddress::class);
    }

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
}

