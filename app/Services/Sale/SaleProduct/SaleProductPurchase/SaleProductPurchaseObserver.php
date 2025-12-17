<?php

namespace App\Services\Sale\SaleProduct\SaleProductPurchase;
use App\Models\Sale\SaleProduct\SaleProductPurchase;
use App\Services\Sale\SaleProduct\SaleProductPurchase\Events\ESaleProductPurchaseCreate;
use Illuminate\Support\Facades\Log;
use App\Models\Purchase\Purchase;


class SaleProductPurchaseObserver
{    
    public function created(SaleProductPurchase $saleProductPurchase): void
    {
        ESaleProductPurchaseCreate::dispatch($saleProductPurchase);
    }

    public function updated(SaleProductPurchase $saleProductPurchase): void
    {
        //
    }

    public function deleted(SaleProductPurchase $saleProductPurchase): void
    {
        //
    }

    public function restored(SaleProductPurchase $saleProductPurchase): void
    {
        //
    }

    public function forceDeleted(SaleProductPurchase $saleProductPurchase): void
    {
        //
    }
}
