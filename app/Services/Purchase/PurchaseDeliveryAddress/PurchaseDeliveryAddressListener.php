<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseDeliveryAddress;

use Illuminate\Support\Facades\Log;


class PurchaseDeliveryAddressListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function updateQuantuty(object $event): void
    {
        $actualQuantity = PurchaseReceipt::where([
            'purchase_id' => $event->data['purchase_id'],
            'address_id' => $event->data['address_id']
        ])->sum('quantity');

        $deliveryAddress = PurchaseDeliveryAddress::where([
            'id' => $event->data['address_id']
        ]);

        $plannedQuantity = $deliveryAddress->first()->planned_quantity;

        $deliveryAddress->update([
            'actual_quantity' => $actualQuantity,
            'remaining_quantity' => $plannedQuantity - $actualQuantity
        ]);
    }
}
