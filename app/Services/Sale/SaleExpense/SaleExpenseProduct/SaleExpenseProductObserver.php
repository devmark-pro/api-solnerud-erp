<?php

namespace App\Services\Sale\SaleExpense\SaleExpenseProduct;
use App\Models\Sale\SaleExpense\SaleExpenseProduct;


class SaleExpenseProductObserver
{    
    public function created(SaleExpenseProduct $saleExpenseProduct): void
    {
       //
    }

    public function updated(SaleExpenseProduct $saleExpenseProduct): void
    {
        //
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
