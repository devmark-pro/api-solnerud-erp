<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseReceipt;
use App\Models\Purchase\PurchaseDeliveryAddress;
use App\Services\Purchase\PurchaseReceipt\EPurchaseReceiptUpdateQuantity;
use App\Services\Purchase\PurchaseReceipt\EPurchaseReceiptUpdateAddress;

use Illuminate\Support\Facades\Log;


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

        Event::listen(
            EPurchaseReceiptUpdateAddress::class,
            [
                $this, 'calculateAllActualQuantity',
            ],
        );

    }
    // Подсчет количества
    public function calculateActualQuantity(object $event): void
    {
         if(!array_key_exists('purchase_id', $event->data) || 
         !array_key_exists('address_id', $event->data)) return;
       
           
        $purchaseId = $event->data['purchase_id'];
        $addressId = $event->data['address_id'];

        $actualQuantity = PurchaseReceipt::where([
            'purchase_id' => $purchaseId,
            'address_id' => $addressId,
            'deleted_at' => null,
        ])->sum('quantity');

        $deliveryAddress = PurchaseDeliveryAddress::where([
            'id' => $addressId,
            'deleted_at' => null,
        ]);

        $plannedQuantity = $deliveryAddress->first()->planned_quantity;

        $deliveryAddress->update([
            'actual_quantity' => $actualQuantity,
            'remaining_quantity' => $plannedQuantity - $actualQuantity
        ]);
    }

    public function calculateAllActualQuantity(object $event): void
    {
        if(!array_key_exists('purchase_id', $event->data)) return;
        
        $purchaseId = $event->data['purchase_id'];

        $actualQuantityArray = PurchaseReceipt::where([
            'purchase_id' => $purchaseId,
            'deleted_at' => null,
        ])->groupBy('address_id')
            ->selectRaw('sum(quantity) as sum, address_id')
            ->pluck("sum", "address_id")
            ->toArray();

        $deliveryAddress = PurchaseDeliveryAddress::where([
            'purchase_id' => $purchaseId,
            'deleted_at' => null,
        ])->pluck('planned_quantity', 'id');

        foreach($deliveryAddress as $addresId => $plannedQuantity){
            $actualQuantity = 0;
            if(array_key_exists($addresId ,$actualQuantityArray)) {
                $actualQuantity = $actualQuantityArray[$addresId];
            }
            PurchaseDeliveryAddress::where('id', $addresId)
                ->update([
                    'actual_quantity' => $actualQuantity,
                    'remaining_quantity' => $plannedQuantity - $actualQuantity
                ]);
        }
    }
}
