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
            ESaleShipped::class,
            [$this, 'removeReserve'],
        );

        // Event::listen(
        //     EWarehouseRemainsReserveUpdated::class,
        //     [$this, 'calculateActualQuantity'],
        // );
        
    }

    // При добавлении Товара
    public function addReserve(object $event): void
    {     
        try {
            if(!array_key_exists('quantity', $event->data) || 
                !array_key_exists('sale_product_id', $event->data) ||
                !array_key_exists('shipment_type', $event->data) 
            ) 
            throw new \Exception('LSaleProvider->addReserve error');
            

            $shipmentType = $event->data['shipment_type'];
            
            if($shipmentType !== 'from_warehouse') return;

                        
            $quantity = $event->data['quantity'];
            $saleProductId = $event->data['sale_product_id'];
            
            $saleProductPurchase = SaleProductPurchase::where([
                "deleted_at" => null,
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
                foreach($reserve as $reserveItem) {
                    $model = WarehouseRemains::where('id', $reserveItem['id'])->first();

                    $model->increment('reserve', $reserveItem['reserve']);
                    // $model->decrement('availability', $reserveItem['reserve']);
                    $actualQuantity = $model->actual_quantity;
                    $reserve = $model->reserve;
                    $model->availability = $actualQuantity - $reserve;
                    $model->save();
                    
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
                !array_key_exists('sale_product_id', $event->data) ||
                !array_key_exists('shipment_type', $event->data) 
            ) 
            throw new \Exception('LSaleProvider->removeReserve error');

            $shipmentType = $event->data['shipment_type'];
            if($shipmentType !== 'from_warehouse') return;
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

            // Вычисление наличия товара на складах
            foreach ($actualQuantity as $item){
                if($reserveQuantity > $item['actual_quantity']){
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $item['actual_quantity']
                    ];        
                    $reserveQuantity = $reserveQuantity-$item['actual_quantity'];
                } else {
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $reserveQuantity
                    ];
                    break;
                }
            }


            if(count($reserve)) {
                foreach($reserve as $reserveItem) {
                    $model = WarehouseRemains::where('id', $reserveItem['id'])->first();
                    $model->decrement('actual_quantity', $reserveItem['reserve']);
                    $model->decrement('reserve', $reserveItem['reserve']);
                    $model->save();
                }
            }
    

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    // public function calculateActualQuantity(object $event): void{
    //         if(!array_key_exists('id', $event->data) || 
    //             !array_key_exists('reserve', $event->data) 
    //         ) 
    //         throw new \Exception('LSaleProvider->calculateActualQuantity error');

    //         $id = $event->data['id'];
    //         $reserve = $event->data['reserve'];

    //         

    //         // WarehouseRemains::where('id', $id)
    //         //     ->first()
    
    // }
        
}
