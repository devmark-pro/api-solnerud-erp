<?php

namespace App\Services\Sale\SaleProduct;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Sale\SaleProduct\SaleProductPurchase;
use App\Models\Sale\SaleProduct\SaleProduct;

use Illuminate\Support\Facades\Log;

use App\Services\Sale\SaleProduct\SaleProductPurchase\Events\ESaleProductPurchaseCreate;


class LSaleProductProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            ESaleProductPurchaseCreate::class,
            [$this, 'calculateQuantity'],
        );
    }
    public function calculateQuantity(object $event): void
    {
        // $warehouseRemainsId = $event->data['warehouse_remains_id'];
        // $saleProductId = $event->data['sale_product_id'];

        // $model = SaleProduct::where(['id'=>$saleProductId])->first();
        // $quantity = 0;
        
        // $quantity = SaleProductPurchase::where([
        //     'deleted_at' => null,
        //     'sale_product_id' => $saleProductId
        // ])->groupBy('sale_product_id')
        //     ->selectRaw('sum(quantity) as summ_quantity')
        //     ->first()->summ_quantity;
        
        // $model->quantity = $quantity;
        // $model->summ = $quantity * $model->price;
        // $model->save();
    }
}
