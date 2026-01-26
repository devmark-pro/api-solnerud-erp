<?php

namespace App\Services\Sale\SaleShipment;
use App\Models\Sale\SaleShipment;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;
use App\Services\Sale\SaleShipment\Events\ESaleShippmentCreateUpdate;


class SaleShipmentObserver
{    
    public function created(SaleShipment $saleShipment): void
    {
        $saleShipmentArr = $saleShipment;
        $shippedQuantity = $saleShipment->getAttribute('shipped_quantity');
        $saleProductId = $saleShipment->getAttribute('sale_product_id');
        
        $saleProduct = SaleProduct::select('shipment_type')
            ->where('id', $saleProductId)
            ->first()
            ->toArray();

        if(array_key_exists('shipment_type', $saleProduct)) {
            $shipmentType = $saleProduct['shipment_type'];            
            $data = [
                'sale_product_id' => $saleProductId,
                'quantity' => $shippedQuantity,
                'shipment_type' => $shipmentType

            ];
            ESaleShipped::dispatch($data);
        }
        
        $saleId = $saleShipment->getAttribute('sale_id');
        ESaleShippmentCreateUpdate::dispatch([
            'sale_id' => $saleId,
        ]);
    }

    public function updated(SaleShipment $saleShipment): void
    {
        $saleShipmentArr = $saleShipment->toArray();

        if(
            array_key_exists('sale_product', $saleShipmentArr) &&
            array_key_exists('shipment_type', $saleShipmentArr['sale_product']
        )) {

            $shipmentType = $saleShipmentArr['sale_product']['shipment_type'];

            if($saleShipment->isDirty('shipped_quantity'))
            {
                $saleProductId = $saleShipment->getAttribute('sale_product_id');
                $shippedQuantity = $saleShipment->getAttribute('shipped_quantity');
                $lastQuantity = $saleShipment->getAttribute('last_quantity');
                $saleShipment->last_quantity = $shippedQuantity;
                
                $quantity = $shippedQuantity - $lastQuantity;

                $data = [
                    'sale_product_id' => $saleProductId,
                    'quantity' => $quantity,
                    'shipment_type' => $shipmentType
                ];
                ESaleShipped::dispatch($data);

                $saleShipment->updateQuietly();
                
            }
        }

        if($saleShipment->isDirty('sale_product_id'))
        {
            $saleId = $saleShipment->getAttribute('sale_id');
            ESaleShippmentCreateUpdate::dispatch([
                'sale_id' => $saleId,
            ]);
        }

        if($saleShipment->isDirty('deleted_at'))
        {
            $deletedAt = $saleShipment->getAttribute('deleted_at');
            if($deletedAt!==null) {
                $saleProductId = $saleShipment->getAttribute('sale_product_id');
                $shippedQuantity = $saleShipment->getAttribute('shipped_quantity');
                $data = [
                    'sale_product_id' => $saleProductId,
                    'quantity' => -$shippedQuantity,
                    'shipment_type' => $shipmentType
                ];
                ESaleShipped::dispatch($data);
                $saleShipment->last_quantity = null;
                $saleShipment->updateQuietly();
            }
            $saleProductId = $saleShipment->getAttribute('sale_product_id');

            $saleId = $saleShipment->getAttribute('sale_id');
            ESaleShippmentCreateUpdate::dispatch([
                'sale_id' => $saleId,
            ]);
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
