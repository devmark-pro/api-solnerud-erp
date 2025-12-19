<?php

namespace App\Services\Sale\SaleProduct;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Sale\SaleProduct\SaleProduct;
use Illuminate\Support\Facades\Log;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;

class LSaleProductProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            ESaleShipped::class,
            [$this, 'calculateShipped'],
        );
    }

    public function calculateShipped(object $event): void
    {
        if(!array_key_exists('sale_product_id', $event->data) || 
                !array_key_exists('quantity', $event->data) 
            ) 
            throw new \Exception('LSaleProductProvider->calculateShipped error');

        $saleProductId = $event->data['sale_product_id'];
        $quantity = $event->data['quantity'];


        SaleProduct::where('id', $saleProductId)
                ->increment('shipped', $quantity);

        SaleProduct::where('id', $saleProductId)
                ->decrement('remains_ship', $quantity);
               

    }

}
