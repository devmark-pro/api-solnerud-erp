<?php

namespace App\Services\WarehouseRemains\WarehouseRemains;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Purchase\Purchase;
use App\Models\Sale\SaleProduct\SaleProductPurchase;
use App\Services\Sale\SaleProduct\Events\ESalePruductShipmentRequest;
use App\Services\WarehouseRemains\WarehouseRemains\Events\EWarehouseRemainsReserveUpdated;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;


use Illuminate\Support\Facades\Log;


class LSaleProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            ESalePruductShipmentRequest::class,
            [$this, 'addReserve'],
        );

        Event::listen(
            EWarehouseRemainsReserveUpdated::class,
            [$this, 'calculateActualQuantity'],
        );

        Event::listen(
            ESaleShipped::class,
            [$this, 'removeReserve'],
        );
        
    }

    // При добавлении Товара
    public function addReserve(object $event): void
    {     
        try {
            if(!array_key_exists('quantity', $event->data) || 
                !array_key_exists('sale_product_id', $event->data) 
            ) 
            throw new \Exception('LSaleProvider->addReserve error');

            $quantity = $event->data['quantity'];
            $saleProductId = $event->data['sale_product_id'];
            
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_product_id" => $saleProductId,
            ])
            ->select('id', 'warehouse_remains_id')
            ->get()->toArray();
 
            $actualQuantity = array_map(function($item){
                return [
                    'id' => $item['warehouse_remains']['id'],
                    'actual_quantity'=>$item['warehouse_remains']['actual_quantity']
                ];
            }, $saleProductPurchase); 


            array_multisort(array_column($actualQuantity, 'actual_quantity'), SORT_ASC, $actualQuantity);

            $reserve = [];
            $reserveQuantity = $quantity;
            foreach ($actualQuantity as $item){
                if($reserveQuantity > $item['actual_quantity']){
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $item['actual_quantity']
                    ];        
                    $reserveQuantity=$reserveQuantity-$item['actual_quantity'];
                }else{
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $reserveQuantity
                    ];
                    break;
                }
            }


            if(count($reserve)){
                foreach($reserve as $reserveItem){
                    WarehouseRemains::where('id', $reserveItem['id'])
                        ->increment('reserve', $reserveItem['reserve']);

                    WarehouseRemains::where('id', $reserveItem['id'])
                        ->first()->decrement('availability', $reserveItem['reserve']);
                }
            }
    

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // При добавлении Отгрузки
    public function removeReserve(object $event): void
    {     
        try {
            if(!array_key_exists('quantity', $event->data) || 
                !array_key_exists('sale_product_id', $event->data) 
            ) 
            throw new \Exception('LSaleProvider->addReserve error');

            $quantity = $event->data['quantity'];
            $saleProductId = $event->data['sale_product_id'];
            
            $saleProductPurchase = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_product_id" => $saleProductId,
            ])
            ->select('id', 'warehouse_remains_id')
            ->get()->toArray();
 
            $actualQuantity = array_map(function($item){
                return [
                    'id' => $item['warehouse_remains']['id'],
                    'actual_quantity'=>$item['warehouse_remains']['actual_quantity']
                ];
            }, $saleProductPurchase); 


            array_multisort(array_column($actualQuantity, 'actual_quantity'), SORT_ASC, $actualQuantity);

            $reserve = [];
            $reserveQuantity = $quantity;
            foreach ($actualQuantity as $item){
                if($reserveQuantity > $item['actual_quantity']){
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $item['actual_quantity']
                    ];        
                    $reserveQuantity=$reserveQuantity-$item['actual_quantity'];
                }else{
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $reserveQuantity
                    ];
                    break;
                }
            }


            if(count($reserve)){
                foreach($reserve as $reserveItem){
                    WarehouseRemains::where('id', $reserveItem['id'])
                        ->decrement('actual_quantity', $reserveItem['reserve']);

                    WarehouseRemains::where('id', $reserveItem['id'])
                        ->first()->decrement('reserve', $reserveItem['reserve']);
                }
            }
    

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function calculateActualQuantity(object $event): void{
            if(!array_key_exists('id', $event->data) || 
                !array_key_exists('reserve', $event->data) 
            ) 
            throw new \Exception('LSaleProvider->calculateActualQuantity error');

            $id = $event->data['id'];
            $reserve = $event->data['reserve'];

            Log::channel('my')->info('444', [
                'id' => $id,
                'reserve' => $reserve,
            ]);


            // WarehouseRemains::where('id', $id)
            //     ->first()
    
    }
        
}
