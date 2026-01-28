<?php

namespace App\Services\Expense\Expense;
use App\Models\Expense\Expense;


class ExpenseObserver
{    
    public function created(Expense $expense): void
    {
       //
    }

    public function updated(Expense $expense): void
    {
        //
    }

    public function deleted(Expense $expense): void
    {
        //
    }

    public function restored(Expense $expense): void
    {
        //
    }

    public function forceDeleted(Expense $expense): void
    {
        //
    }
}
