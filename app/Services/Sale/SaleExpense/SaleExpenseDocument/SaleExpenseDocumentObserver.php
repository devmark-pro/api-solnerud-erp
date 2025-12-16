<?php

namespace App\Services\Sale\SaleExpense\SaleExpenseDocument;
use App\Models\Sale\SaleExpense\SaleExpenseDocument;


class SaleExpenseDocumentObserver
{    
    public function created(SaleExpenseDocument $saleExpenseDocument): void
    {
       //
    }

    public function updated(SaleExpenseDocument $saleExpenseDocument): void
    {
        //
    }

    public function deleted(SaleExpenseDocument $saleExpenseDocument): void
    {
        //
    }

    public function restored(SaleExpenseDocument $saleExpenseDocument): void
    {
        //
    }

    public function forceDeleted(SaleExpenseDocument $saleExpenseDocument): void
    {
        //
    }
}
