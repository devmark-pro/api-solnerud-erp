<?php

namespace App\Services\Sale\SaleProduct;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleProduct\Events\ESalePruductShipmentRequest;


class SaleProductObserver
{    
    public function created(SaleProduct $saleProduct): void
    {
       //
    }

    public function updated(SaleProduct $saleProduct): void
    {
        if($saleProduct->isDirty('is_request_shipment'))
        {   
            
            $isRequestShipment = $saleProduct->getAttribute('is_request_shipment');
            
            if($isRequestShipment){
                $shipmentType = $saleProduct->getAttribute('shipment_type');
                $saleProductId = $saleProduct->getAttribute('id');
                $quantity = $saleProduct->getAttribute('quantity');
                $saleId = $saleProduct->getAttribute('sale_id');

                
                $data = [
                    'sale_product_id' => $saleProductId,
                    'quantity' => $quantity,
                    'shipment_type' => $shipmentType,
                    'sale_id' => $saleId
                ];
                ESalePruductShipmentRequest::dispatch($data);
            }
        }
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
