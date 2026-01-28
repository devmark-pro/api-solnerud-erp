<?php

namespace App\Services\Expense\ExpenseDocument;
use App\Models\Expense\ExpenseDocument;


class ExpenseDocumentObserver
{    
    public function created(ExpenseDocument $expenseDocument): void
    {
       //
    }

    public function updated(ExpenseDocument $expenseDocument): void
    {
        //
    }

    public function deleted(ExpenseDocument $expenseDocument): void
    {
        //
    }

    public function restored(ExpenseDocument $expenseDocument): void
    {
        //
    }

    public function forceDeleted(ExpenseDocument $expenseDocument): void
    {
        //
    }
}
