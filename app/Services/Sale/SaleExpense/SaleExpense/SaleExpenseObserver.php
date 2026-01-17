<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpense;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseCreateUpdate;


class SaleExpenseObserver
{    
    public function created(SaleExpense $saleExpense): void
    {
        $cost = $saleExpense->getAttribute('cost');
        $saleProductIds = $saleExpense->getAttribute('sale_product_ids');
                
        ESaleExpenseUpdateCost::dispatch(
            [
                'cost' => $cost,
                'sale_product_ids'=> $saleProductIds
            ]
        );

        $saleId = $saleExpense->getAttribute('sale_id');

        ESaleExpenseCreateUpdate::dispatch([
            'sale_id' => $saleId
        ]);
    }

    public function updated(SaleExpense $saleExpense): void
    {
        if($saleExpense->isDirty('cost') || 
            $saleExpense->isDirty('quantity') ||
            $saleExpense->isDirty('include_in_cost') ||
            $saleExpense->isDirty('deleted_at') 
            ) {
                $data = [
                    'cost' => $saleExpense->getAttribute('cost'),
                    'sale_product_ids'=>$saleExpense->getAttribute('sale_product_ids')
                ];
            ESaleExpenseUpdateCost::dispatch($data);
        }

        $saleId = $saleExpense->getAttribute('sale_id');
        if($saleExpense->isDirty('deleted_at')) {
            ESaleExpenseCreateUpdate::dispatch([
                'sale_id' => $saleId
            ]);
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
