<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleExpense\SaleExpense;


class SaleExpenseObserver
{    
    public function created(SaleExpense $saleExpense): void
    {
       //
    }

    public function updated(SaleExpense $saleExpense): void
    {
        //
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
