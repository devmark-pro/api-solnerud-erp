<?php

namespace App\Services\Sale\SaleExpense\SaleExpenseProduct;
use App\Models\Sale\SaleExpense\SaleExpenseProduct;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseCreateUpdate;


class SaleExpenseProductObserver
{    
    public function created(SaleExpenseProduct $saleExpenseProduct): void
    {
        $saleId = $saleExpenseProduct->getAttribute('sale_id');
        ESaleExpenseCreateUpdate::dispatch([
            'sale_id' => $saleId
        ]);
    }

    public function updated(SaleExpenseProduct $saleExpenseProduct): void
    {
        $saleId = $saleExpenseProduct->getAttribute('sale_id');
        ESaleExpenseCreateUpdate::dispatch([
            'sale_id' => $saleId
        ]);
    }

    public function deleted(SaleExpenseProduct $saleExpenseProduct): void
    {
        //
    }

    public function restored(SaleExpenseProduct $saleExpenseProduct): void
    {
        //
    }

    public function forceDeleted(SaleExpenseProduct $saleExpenseProduct): void
    {
        //
    }
}
