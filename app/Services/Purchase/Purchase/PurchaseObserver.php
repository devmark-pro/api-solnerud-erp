<?php

namespace App\Services\Purchase\Purchase;
use App\Models\Purchase\Purchase;
use Illuminate\Support\Facades\Log;
use App\Services\Purchase\Purchase\Events\EPurchaseDelete;
use App\Services\Purchase\Purchase\Events\EPurchaseUpdatePrice;
use App\Services\Purchase\Purchase\Events\EPurchaseUpdatePackingType;
use App\Services\Purchase\Purchase\Events\EPurchaseUpdateNomenclature;

class PurchaseObserver
{
    public function created(Purchase $purchase): void
    {
        
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

        if($purchase->isDirty('nomenclature_id'))
        {
            EPurchaseUpdateNomenclature::dispatch(
            [
                'purchase_id' => $purchase->id,
                'nomenclature_id' => $purchase->nomenclature_id,
            ]);
        }
            
        if( $purchase->isDirty('packing_type_id'))
        {
            EPurchaseUpdatePackingType::dispatch(
            [
                'purchase_id' => $purchase->id,
                'packing_type_id' => $purchase->packing_type_id
            ]);
        }
        if( $purchase->isDirty('deleted_at'))
        {
            EPurchaseDelete::dispatch(
            [
                'purchase_id' => $purchase->id,
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
