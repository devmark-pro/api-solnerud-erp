<?php

namespace App\Services\Sale\SaleShipment;
use App\Models\Sale\SaleShipment;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;

use Illuminate\Support\Facades\Log;


class SaleShipmentObserver
{    
    public function created(SaleShipment $saleShipment): void
    {
        $shippedQuantity = $saleShipment->getAttribute('shipped_quantity');
            $saleProductId = $saleShipment->getAttribute('sale_product_id');
            $data = [
                'sale_product_id' => $saleProductId,
                'shipped_quantity' => $shippedQuantity,
            ];
            ESaleShipped::dispatch($data);
    }

    public function updated(SaleShipment $saleShipment): void
    {
        if($saleShipment->isDirty('shipped_quantity'))
        {    
            $saleProductId = $saleShipment->getAttribute('sale_product_id');
            $shippedQuantity = $saleShipment->getAttribute('shipped_quantity');
            $lastQuantity = $saleShipment->getAttribute('last_quantity');
            $quantity = $shippedQuantity - $lastQuantity;
            $data = [
                'sale_product_id' => $saleProductId,
                'shipped_quantity' => $quantity,
            ];
            ESaleShipped::dispatch($data);
            $saleShipment->last_quantity=$shippedQuantity;
            $saleShipment->updateQuietly();
        }
    }

    public function deleted(SaleShipment $saleShipment): void
    {
        //
    }

    public function restored(SaleShipment $saleShipment): void
    {
        //
    }

    public function forceDeleted(SaleShipment $saleShipment): void
    {
        //
    }
}
