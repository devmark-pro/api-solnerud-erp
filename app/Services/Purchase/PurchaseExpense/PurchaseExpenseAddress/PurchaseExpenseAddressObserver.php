<?php

namespace App\Services\Purchase\PurchaseExpense\PurchaseExpenseAddress;

use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;
use Illuminate\Support\Facades\Log;

// use App\Services\Purchase\PurchaseExpenseAddress\EPurchaseExpenseUpdateSumm;
            

class PurchaseExpenseAddressObserver
{
    public function created(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        //
    }

    public function updated(PurchaseExpenseAddress $purchaseExpenseAddress): void
    {
        
        // if($purchaseExpenseAddress->isDirty('summ') ||
        //     $purchaseExpenseAddress->isDirty('deleted_at'))
        // {
        //     $addressIds = $purchaseExpenseAddress->getAttribute('addresses')->pluck('address_id')->toArray();
        //     $data = [
        //         'purchase_id' => $purchaseExpenseAddress['purchase_id'],
        //         'purchase_expense_id' => $purchaseExpenseAddress['purchase_expense_id'],
        //         'addresses' => $addressIds
        //     ];      
        //     EPurchaseExpenseUpdateSumm::dispatch($data);
        // }
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
