<?php

namespace App\Services\Purchase\PurchaseExpense\PurchaseExpenseAddress;

use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;
use App\Services\Purchase\PurchaseExpense\EPurchaseExpenseUpdateSumm;

use Illuminate\Support\Facades\Log;

            

class PurchaseExpenseAddressObserver
{
    public function created(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        $data = [
            'purchase_id' => $purchaseExpenseAddress['purchase_id'],
            'purchase_expense_id' => $purchaseExpenseAddress['purchase_expense_id'],
        ];      
        EPurchaseExpenseUpdateSumm::dispatch($data);
    }

    public function updated(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        if($purchaseExpenseAddress->isDirty('deleted_at'))
        {
            $data = [
                'purchase_id' => $purchaseExpenseAddress['purchase_id'],
                'purchase_expense_id' => $purchaseExpenseAddress['purchase_expense_id'],
            ];      
            EPurchaseExpenseDeleteAddress::dispatch($data);
        }
    }

    public function deleted(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        //
    }

    public function restored(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        //
    }

    public function forceDeleted(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        //
    }
}
