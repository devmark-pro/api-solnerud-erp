<?php

namespace App\Services\WarehouseRemains\WarehouseRemains;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Purchase\Purchase;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Models\Sale\SaleProduct\SaleProductPurchase;
use App\Services\Sale\SaleProduct\Events\ESalePruductShipmentRequest;
use App\Services\WarehouseRemains\WarehouseRemains\Events\EWarehouseRemainsReserveUpdated;
use App\Services\Sale\SaleShipment\Events\ESaleShipped;


use Illuminate\Support\Facades\Log;


class LWarehouseSaleProvider extends ServiceProvider
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
                !array_key_exists('shipment_type', $event->data) ||
                !array_key_exists('purchase_ids', $event->data) ||    
                !array_key_exists('warehouse_id', $event->data)      
            ) 
            throw new \Exception('LWarehouseSaleProvider->addReserve error');
            

            $shipmentType = $event->data['shipment_type'];
            
            if($shipmentType !== 'from_warehouse') return;

                        
            $quantity = $event->data['quantity'];
            $saleProductId = $event->data['sale_product_id'];
            $purchaseIds = $event->data['purchase_ids'];
            $warehouseId = $event->data['warehouse_id'];

            // Получить актуальное количество нужного товара по складам
            $actualQuantity = WarehouseRemains::whereIn('purchase_id', $purchaseIds)
                ->where([
                    'warehouse_id' => $warehouseId,
                    'deleted_at' => null
                ])
                ->select('id', 'availability')
                ->orderBy('availability', 'asc')
                ->get()
                ->toArray();


            // Вычисление резервов
            $reserve = [];
            $reserveQuantity = $quantity;
            foreach ($actualQuantity as $item){
                if($reserveQuantity > $item['availability']){
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $item['availability']
                    ];        
                    $reserveQuantity = $reserveQuantity - $item['availability'];
                } else {
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $reserveQuantity
                    ];
                    break;
                }
            }
            // Начисление резервов на склад
            if(count($reserve)){
                foreach($reserve as $reserveItem) {
                    $model = WarehouseRemains::where('id', $reserveItem['id'])->first();
                    $model->increment('reserve', $reserveItem['reserve']);
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
            throw new \Exception('LWarehouseSaleProvider->removeReserve error');

            $shipmentType = $event->data['shipment_type'];
            if($shipmentType !== 'from_warehouse') return;
            $quantity = $event->data['quantity'];
            $saleProductId = $event->data['sale_product_id'];
            

            $warehouseId = SaleProduct::where([
                'deleted_at' => null,
                "id" => $saleProductId,
            ])
                ->select('id', 'warehouse_id')
                ->first()->warehouse_id;

            // throw new \Error($warehouseId);

            $purchaseIds = SaleProductPurchase::where([
                'deleted_at' => null,
                "sale_product_id" => $saleProductId,
            ])
                ->select('id', 'purchase_id')
                ->get()
                ->pluck('purchase_id');


            $reserveList = WarehouseRemains::whereIn('purchase_id', $purchaseIds)
                ->where([
                    'warehouse_id' => $warehouseId,
                    'deleted_at' => null
                ])
                ->select('id', 'reserve')
                ->orderBy('reserve', 'asc')
                ->get()
                ->toArray();


            $reserve = [];
            $reserveQuantity = $quantity;

            // Вычисление наличия товара на складах
            foreach ($reserveList as $item){
                if($reserveQuantity > $item['reserve']){
                    $reserve[]=[
                        'id' => $item['id'],
                        'reserve' => $item['reserve']
                    ];        
                    $reserveQuantity = $reserveQuantity-$item['reserve'];
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
   
        
}
