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
            $shipmentType = $saleProduct->getAttribute('shipment_type');

            if($isRequestShipment && $shipmentType==='from_warehouse'){
                $data = [
                    'sale_product_id' => $saleProduct->getAttribute('id'),
                    'quantity' => $saleProduct->getAttribute('quantity'),
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
