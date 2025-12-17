<?php

namespace App\Models\Sale\SaleExpense;

use App\Services\Sale\SaleExpense\SaleExpenseProduct\SaleExpenseProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale\Sale;
use App\Models\Sale\SaleExpense;
use App\Models\Sale\SaleDeliveryAddress;
use App\Services\Sale\SaleExpense\SaleExpenseAddress\SaleExpenseAddressObserver;


#[ObservedBy([SaleExpenseProductObserver::class])]
class SaleExpenseProduct extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'sale_id',
        'sale_expense_id',
        'sale_product_id',
        'deleted_at',
    ];
    

    public function saleExpense(): BelongsTo 
    {
        return $this->belongsTo(SaleExpense::class);
    }
    
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo 
    {
        return $this->belongsTo(SaleDeliveryAddress::class);
    }

    public function sale(): BelongsTo 
    {
        return $this->belongsTo(Sale::class);
    }


}
