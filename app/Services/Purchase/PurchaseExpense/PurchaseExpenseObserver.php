<?php

namespace App\Services\Purchase\PurchaseExpense;
use App\Models\Purchase\PurchaseExpense\PurchaseExpense;
use Illuminate\Support\Facades\Log;
// use App\Services\Purchase\PurchaseExpense\EPurchaseExpenseUpdateSumm;
            

class PurchaseExpenseObserver
{
    public function created(PurchaseExpense $purchaseExpense): void
    {
        
        $data = [
            'purchase_id' => $purchaseExpense['purchase_id'],
            'purchase_expense_id' => $purchaseExpense['id'],
        ];
          
        EPurchaseExpenseCreate::dispatch($data);
       
    }

    public function updated(PurchaseExpense $purchaseExpense): void
    {
        
        if($purchaseExpense->isDirty('summ')){
            $data = [
                'purchase_id' => $purchaseExpense['purchase_id'],
                'purchase_expense_id' => $purchaseExpense['id'],
            ];      
            
            EPurchaseExpenseUpdateSumm::dispatch($data);
        }
        if($purchaseExpense->isDirty('deleted_at'))
        {
            $data = [
                'purchase_id' => $purchaseExpense['purchase_id'],
                'purchase_expense_id' => $purchaseExpense['id'],
            ];
          
            EPurchaseExpenseDelete::dispatch($data);
        }
    }

    public function deleted(PurchaseExpense $purchaseExpense): void
    {
        //
    }

    public function restored(PurchaseExpense $purchaseExpense): void
    {
        //
    }

    public function forceDeleted(PurchaseExpense $purchaseExpense): void
    {
        //
    }
}
