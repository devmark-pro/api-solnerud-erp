<?php

namespace App\Services\Purchase\Purchase;
use App\Models\Purchase\Purchase;
use Illuminate\Support\Facades\Log;
// use App\Services\Purchase\Purchase\Events\EPurchaseCreateToWarehouse;

class PurchaseObserver
{
    public function created(Purchase $purchase): void
    {
        // if($purchase->purchase_type==='to_warehouse') 
        // {
        //     EPurchaseCreateToWarehouse::dispatch([
        //         'purchase_id' => $purchase->id,
        //         'nomenclature_id' => $purchase->nomenclature_id,
        //         'packing_type_id' => $purchase->packing_type_id,
        //     ]);
        // }
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
