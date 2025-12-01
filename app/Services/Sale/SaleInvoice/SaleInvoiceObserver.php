<?php

namespace App\Services\Sale\SaleInvoice;
use App\Models\Sale\SaleInvoice;


class SaleInvoiceObserver
{    
    public function created(SaleInvoice $saleInvoice): void
    {
       //
    }

    public function updated(SaleInvoice $saleInvoice): void
    {
        //
    }

    public function deleted(SaleInvoice $saleInvoice): void
    {
        //
    }

    public function restored(SaleInvoice $saleInvoice): void
    {
        //
    }

    public function forceDeleted(SaleInvoice $saleInvoice): void
    {
        //
    }
}
