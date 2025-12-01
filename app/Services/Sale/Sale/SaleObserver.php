<?php

namespace App\Services\Sale\Sale;
use App\Models\Sale\Sale;


class SaleObserver
{    
    public function created(Sale $sale): void
    {
       //
    }

    public function updated(Sale $sale): void
    {
        //
    }

    public function deleted(Sale $sale): void
    {
        //
    }

    public function restored(Sale $sale): void
    {
        //
    }

    public function forceDeleted(Sale $sale): void
    {
        //
    }
}
