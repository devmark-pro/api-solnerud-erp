<?php

namespace App\Services\Sale\SaleProduct;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Sale\SaleProduct\SaleProduct;
use Illuminate\Support\Facades\Log;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpense;


class LSaleProductProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            ESaleShipped::class,
            [$this, 'calculateShipped'],
        );
        Event::listen(
            ESaleExpenseUpdateCost::class,
            [$this, 'calculateCost'],
        );
        Event::listen(
            ESaleExpense::class,
            [$this, 'updateShippedPrice'],
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

        $model = SaleProduct::where('id', $saleProductId)->first();

        $model->increment('shipped', $quantity);
        $model->remains_ship = (float)$model->quantity - (float)$model->shipped ;

        $model->shipment_summ = (float)$model->shipped * (float)$model->price;
        $model->shipment_summ_nds = (float)$model->shipped * (float)$model->summ_nds;
        $model->profit = (float)$model->summ - (
            (float)$model->total_cost * (float)$model->quantity);
        $model->save(); 

    }
    public function calculateCost(object $event): void
    {
        if(!array_key_exists('sale_product_ids', $event->data) || 
            !array_key_exists('cost', $event->data) 
        ) {
            throw new \Exception('LSaleProductProvider->calculateCost error');
        }
            
        $cost = (float)$event->data['cost'];
        $saleProductIds = $event->data['sale_product_ids'];

        $saleProducts = SaleProduct::whereIn('id', $saleProductIds)->get()->toArray();
        $data=[];
        foreach($saleProducts as $item) {
            $data[$item['id']] = $cost + (float)$item['cost'];
        }

        foreach($data as $id => $total) {
            SaleProduct::where('id', $id)->update(['total_cost' => $total]);
        }
    }
    
    public function updateShippedPrice(object $event): void
    {

    }
    
}
