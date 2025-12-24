<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpense;


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
                'cost' => $saleExpense->getAttribute('cost'),
                'sale_product_ids'=>$saleExpense->getAttribute('sale_product_ids')
            ];
            ESaleExpenseUpdateCost::dispatch($data);
        }
        // if($saleExpense->isDirty('summ')||
        //     $saleExpense->isDirty('quantity')||
        //     $saleExpense->isDirty('nds_rate_id')||
        //     $saleExpense->isDirty('is_nds_in_price')
        //     )
        // {
        //     $data = [
        //         "rate" => $saleExpense->getAttribute('rate'),
        //         "nds_rate_id" => $saleExpense->getAttribute('nds_rate_id'),
        //         "summ" => $saleExpense->getAttribute('summ'),
        //         "summ_nds" => $saleExpense->getAttribute('summ_nds'),
        //         "is_nds_in_price" => $saleExpense->getAttribute('is_nds_in_price'),
        //         "nds_rate" => $saleExpense->getAttribute('nds_rate'),
        //         "quantity" => $saleExpense->getAttribute('quantity'),
        //         'sale_product_ids'=>$saleExpense->getAttribute('sale_product_ids')
        //     ];
        //     ESaleExpense::dispatch($data);
        //     throw new \Error($saleExpense);   
        // }
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
