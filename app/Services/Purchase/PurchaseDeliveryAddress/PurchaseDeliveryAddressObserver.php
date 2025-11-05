<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\PurchaseDeliveryAddress;

use Illuminate\Support\Facades\Log;

            

class PurchaseDeliveryAddressObserver
{
    /**
     * Handle the PurchaseDeliveryAddress "created" event.
     */
    public function created(PurchaseDeliveryAddress $purchaseDeliveryAddress): void
    {
        //
    }

    /**
     * Handle the PurchaseDeliveryAddress "updated" event.
     */
    public function updated(PurchaseDeliveryAddress $purchaseDeliveryAddress): void
    {
     
        if($purchaseDeliveryAddress->isDirty('planned_quantity'))
        {   
            $purchaseId = $purchaseDeliveryAddress->getAttribute('purchase_id');
            PurchaseDeliveryAddressUpdateActualQuantityEvent::dispatch([
                'purchase_id' => $purchaseId
            ]);
        }
    }

    /**
     * Handle the PurchaseDeliveryAddress "deleted" event.
     */
    public function deleted(PurchaseDeliveryAddress $purchaseDeliveryAddress): void
    {
        //
    }

    /**
     * Handle the PurchaseDeliveryAddress "restored" event.
     */
    public function restored(PurchaseDeliveryAddress $purchaseDeliveryAddress): void
    {
        //
    }

    /**
     * Handle the PurchaseDeliveryAddress "force deleted" event.
     */
    public function forceDeleted(PurchaseDeliveryAddress $purchaseDeliveryAddress): void
    {
        //
    }
}
