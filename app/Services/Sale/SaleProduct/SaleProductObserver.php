<?php

namespace App\Services\Sale\SaleProduct;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleProduct\Events\ESalePruductShipmentRequest;
use App\Services\Sale\SaleProduct\Events\ESalePruductShippedUpdate;
use App\Models\WarehouseRemains\WarehouseRemains;


class SaleProductObserver
{    
    public function created(SaleProduct $saleProduct): void
    {
       //
    }

    
    public function updating(SaleProduct $saleProduct): void
    {
        if($saleProduct->isDirty('is_request_shipment'))
        {
            $shipmentType = $saleProduct->getAttribute('shipment_type');
            $isRequestShipment = $saleProduct->getAttribute('is_request_shipment');

            if($shipmentType !== 'from_warehouse') return;

            $quantity = (float)$saleProduct->getAttribute('quantity');
            $purchaseIds = $saleProduct->getAttribute('purchase_ids');
            $warehouseId = $saleProduct->getAttribute('warehouse_id');


            $availability = (float)WarehouseRemains::whereIn('purchase_id', $purchaseIds)
                ->where([
                    'warehouse_id' => $warehouseId,
                    'deleted_at' => null
                ])->sum('availability');

            if($isRequestShipment && $quantity > $availability) {
                throw new \Error("Недостаточно товара на складе. Доступно $availability тн.");
            }
        }
    }

    public function updated(SaleProduct $saleProduct): void
    {
        if($saleProduct->isDirty('is_request_shipment'))
        {   
            
            $isRequestShipment = $saleProduct->getAttribute('is_request_shipment');
            $shipmentType = $saleProduct->getAttribute('shipment_type');
            $saleProductId = $saleProduct->getAttribute('id');
            $quantity = $saleProduct->getAttribute('quantity');
            $saleId = $saleProduct->getAttribute('sale_id');
            $purchaseIds = $saleProduct->getAttribute('purchase_ids');
            $purchaseId = $saleProduct->getAttribute('purchase_id');
            $warehouseId = $saleProduct->getAttribute('warehouse_id');


            $data = [
                'sale_product_id' => $saleProductId,
                'quantity' => $quantity,
                'shipment_type' => $shipmentType,
                'sale_id' => $saleId,
                'purchase_id' => $purchaseId,
                'purchase_ids' => $purchaseIds,
                'warehouse_id' => $warehouseId,
                'is_request_shipment' => $isRequestShipment,
            ];
            if($isRequestShipment) {
                ESalePruductShipmentRequest::dispatch($data);
            } else {
                $data['quantity'] = -$quantity;
                ESalePruductShipmentRequest::dispatch($data);
            }
        }
        // if($saleProduct->isDirty('shipped'))
        // {
        //     $saleProductId = $saleProduct->getAttribute('id');
        //     $shipped = $saleProduct->getAttribute('shipped');

        //         // throw new \Error($shipped);
        //         $data = [
        //             'sale_product_id' => $saleProductId,
        //         ];
        //         ESalePruductShippedUpdate::dispatch($data);
        // }
    }

    public function deleted(SaleProduct $saleProduct): void
    {
        //
    }

    public function restored(SaleProduct $saleProduct): void
    {
        //
    }

    public function forceDeleted(SaleProduct $saleProduct): void
    {
        //
    }
}
