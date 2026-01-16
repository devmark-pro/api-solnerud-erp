<?php

namespace App\Services\Sale\SaleProduct;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Sale\SaleShipment;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Models\Sale\SaleExpense\SaleExpenseProduct;

use App\Services\Sale\SaleShipment\Events\ESaleShipped;
use App\Models\Sale\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpense;

use Illuminate\Support\Facades\Log;
// use App\Services\Sale\SaleProduct\Events\ESalePruductUpdateQuantity;


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
    }

    public function calculateShipped(object $event): void
    {
        if(!array_key_exists('sale_product_id', $event->data)) 
        throw new \Exception('LSaleProductProvider->calculateShipped error');

        $saleProductId = $event->data['sale_product_id'];

        $totalShipped = SaleShipment::where(
            [   
                'deleted_at' => null,
                'sale_product_id'=>$saleProductId
            ])->sum('shipped_quantity');
        

        $model = SaleProduct::where('id', $saleProductId)->first();

        $model->shipped = $totalShipped;

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

        
        $saleExpenseProduct = SaleExpenseProduct::whereIn('sale_product_id',$saleProductIds)
            ->select('sale_product_id','sale_expense_id')
            ->get();

        $saleExpense = [];
        foreach($saleExpenseProduct as $item){
            $saleExpense[$item['sale_product_id']][] = $item['sale_expense_id'];
        }
        // Себестоимость расходов
        $costSumm = [];
        foreach($saleExpense as $key => $item){
            $costSumm[$key] = SaleExpense::whereIn('id', $item)->sum('cost');
        }

        $saleProducts = SaleProduct::select('id', 'cost')->whereIn('id', $saleProductIds)->get()->toArray();
                
        $data = [];        
        foreach($saleProducts as $item) {
            $data[$item['id']] = $costSumm[$item['id']] + (float)$item['cost'];
        }

        foreach($data as $id => $total) {
            SaleProduct::where('id', $id)->update(['total_cost' => $total]);
        }
    }
    
    
}
