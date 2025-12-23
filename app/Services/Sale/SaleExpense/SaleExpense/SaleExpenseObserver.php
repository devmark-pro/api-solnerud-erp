<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;


class SaleExpenseObserver
{    
    public function created(SaleExpense $saleExpense): void
    {
       //
    }

    public function updated(SaleExpense $saleExpense): void
    {
        //
        if($saleExpense->isDirty('cost')) {
            $data = [
                'cost'=> $saleExpense->getAttribute('cost'),
                'sale_product_ids'=>$saleExpense->getAttribute('sale_product_ids')
            ];
            ESaleExpenseUpdateCost::dispatch($data);
        }
    }

    public function deleted(SaleExpense $saleExpense): void
    {
        //
    }

    public function restored(SaleExpense $saleExpense): void
    {
        //
    }

    public function forceDeleted(SaleExpense $saleExpense): void
    {
        //
    }
}
