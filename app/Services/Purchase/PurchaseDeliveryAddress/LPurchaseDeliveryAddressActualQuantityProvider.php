<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Services\Purchase\PurchaseReceipt\EPurchaseReceiptUpdateQuantity;


class LPurchaseDeliveryAddressActualQuantityProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(
            EPurchaseReceiptUpdateQuantity::class,
            [
                $this, 'calculateActualQuantity',
            ],
        );

    }
    // Подсчет количества
    public function calculateActualQuantity(object $event): void
    {
                
        $actualQuantity = PurchaseReceipt::where([
            'purchase_id' => $event->data['purchase_id'],
            'address_id' => $event->data['address_id'],
            'deleted_at' => null,
        ])->sum('quantity');

        $deliveryAddress = PurchaseDeliveryAddress::where([
            'id' => $event->data['address_id'],
            'deleted_at' => null,
        ]);

        $plannedQuantity = $deliveryAddress->first()->planned_quantity;

        $deliveryAddress->update([
            'actual_quantity' => $actualQuantity,
            'remaining_quantity' => $plannedQuantity - $actualQuantity
        ]);
    }
}
