<?php

namespace App\Services\Sale\SaleShipment;
use App\Models\Sale\SaleShipment;


class SaleShipmentObserver
{    
    public function created(SaleShipment $saleShipment): void
    {
       //
    }

    public function updated(SaleShipment $saleShipment): void
    {
        //
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
