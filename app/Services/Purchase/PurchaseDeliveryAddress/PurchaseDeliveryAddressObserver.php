<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\EPurchaseDeliveryAddressCreate;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\EPurchaseDeliveryAddressUpdateCost;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\EPurchaseDeliveryAddressUpdateActualQuantity;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\PurchaseDeliveryAddressDeleteEvent;


use Illuminate\Support\Facades\Log;


class PurchaseDeliveryAddressObserver
{
    /**
     * Handle the PurchaseDeliveryAddress "created" event.
     */
    public function created(PurchaseDeliveryAddress $purchaseDeliveryAddress): void
    {
        $purchaseId = $purchaseDeliveryAddress->getAttribute('purchase_id');
        $warehouseId = $purchaseDeliveryAddress->getAttribute('warehouse_id');
        $purchaseDeliveryAddressId = $purchaseDeliveryAddress->getAttribute('id');

        EPurchaseDeliveryAddressCreate::dispatch([
            'purchase_id' => $purchaseId,
            'warehouse_id' => $warehouseId,
            'purchase_delivery_address_id' => $purchaseDeliveryAddressId
        ]);
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

        if($purchaseDeliveryAddress->isDirty('actual_quantity'))
        {   
            $purchaseDeliveryAddressId = $purchaseDeliveryAddress->getAttribute('id');
            $actualQuantity = $purchaseDeliveryAddress->getAttribute('actual_quantity');
            EPurchaseDeliveryAddressUpdateActualQuantity::dispatch([
                'actual_quantity' => $actualQuantity,
                'purchase_delivery_address_id' => $purchaseDeliveryAddressId
        
            ]);
        }
        
        if($purchaseDeliveryAddress->isDirty('cost'))
        {   
            $cost = $purchaseDeliveryAddress->getAttribute('cost');
            $purchaseDeliveryAddressId = $purchaseDeliveryAddress->getAttribute('id');
         
            EPurchaseDeliveryAddressUpdateCost::dispatch([
                'cost' => $cost,
                'purchase_delivery_address_id' => $purchaseDeliveryAddressId
            ]);
        }

        if($purchaseDeliveryAddress->isDirty('deleted_at'))
        {   
            $purchaseDeliveryAddressId = $purchaseDeliveryAddress->getAttribute('id');
            PurchaseDeliveryAddressDeleteEvent::dispatch([
                'purchase_delivery_address_id' => $purchaseDeliveryAddressId
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
