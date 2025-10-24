<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Warehouse;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseExpense\PurchaseExpense;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;
use App\Models\Purchase\PurchaseReceipt;


// Адреса доставки
class PurchaseDeliveryAddress extends Model
{
    protected $table = 'purchase_delivery_addresses';

    protected $fillable = [
        'id',
        'address',
        'planned_quantity', // плановое количество
        'warehouse_id',
        'purchase_id',
        'deleted_at',
    ];

    protected $appends = [ 
        'actual_quantity',  // фактическое количество
        'remained',         // осталось
        'cost',             // Себестоимость
    ];

    protected $with = [
        'warehouse'
    ];

    public function getActualQuantityAttribute() 
    {
        return PurchaseReceipt::where([
            'purchase_id' => $this->purchase_id,
            'address_id' => $this->id    
        ])->sum('quantity');
    }

    public function getRemainedAttribute() 
    {
        $actualQuantity = $this->getActualQuantityAttribute();
        return $this->planned_quantity - $actualQuantity;
    }

    public function getCostAttribute() 
    {
        // цена за тонну
        $price = Purchase::where([
            'id' => $this->purchase_id,
        ])->sum('price');
        
        $addressTotalQuantity = PurchaseReceipt::where([
            'purchase_id' => $this->purchase_id,
        ])->sum('quantity');

        

        // $expense = PurchaseExpense::where([
        //     'purchase_id' => $this->purchase_id,
        //     'include_in_cost' => true,
        //     // 'address_id' => $this->id,
        //     ])->whereIn([
        //         'addresses.' =>$this->id
        //     ])
        //     ->sum('summ');

        $expense =  PurchaseExpenseAddress::join('purchase_expenses', 
                    'purchase_expense_addresses.purchase_expense_id',
                    '=', 
                    'purchase_expenses.id'
                )->where([
                    'purchase_expenses.include_in_cost' => true,
                    'purchase_expense_addresses.address_id' => $this->id,
                    'purchase_expense_addresses.purchase_id' => $this->purchase_id,
                ])  
        ->sum('summ');

    
        $count = PurchaseReceipt::where([
            'purchase_id' => $this->purchase_id,
            'address_id' => $this->id
        ])->sum('quantity');
        
        if($addressTotalQuantity===0){
            return 0;
        }
        return round($price + ($expense/$addressTotalQuantity)*($count/$addressTotalQuantity), 2);
    }

    public function purchase(): BelongsTo 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function warehouse(): BelongsTo 
    {
        return $this->belongsTo(Warehouse::class);
    }

}
