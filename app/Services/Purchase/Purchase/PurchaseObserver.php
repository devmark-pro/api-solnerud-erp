<?php

namespace App\Services\Purchase\Purchase;
use App\Models\Purchase\Purchase;
use App\Services\Purchase\Purchase\EPurchaseExpenseUpdateSumm;
use Illuminate\Support\Facades\Log;

class PurchaseObserver
{
    public function created(Purchase $purchase): void
    {
        //
    }

    public function updated(Purchase $purchase): void
    {

        if($purchase->isDirty('price'))
        {

            EPurchaseUpdatePrice::dispatch(
            [
                'purchase_id' => $purchase->id
            ]);
        }
    }

    public function deleted(Purchase $purchase): void
    {
        //
    }

    public function restored(Purchase $purchase): void
    {
        //
    }

    public function forceDeleted(Purchase $purchase): void
    {
        //
    }
}
