<?php

namespace App\Services\WarehouseRemains\WarehouseRemains;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Purchase\Purchase;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\EPurchaseDeliveryAddressCreate;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\EPurchaseDeliveryAddressUpdateCost;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\EPurchaseDeliveryAddressUpdateActualQuantity;
use App\Services\Purchase\PurchaseDeliveryAddress\Events\PurchaseDeliveryAddressDeleteEvent;

use Illuminate\Support\Facades\Log;


class LWarehouseRemainsProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Event::listen(
            EPurchaseDeliveryAddressCreate::class,
            [$this, 'addWarehouseRemains'],
        );

        Event::listen(
            EPurchaseDeliveryAddressUpdateCost::class,
            [$this, 'updateCost'],
        );
        Event::listen(
            EPurchaseDeliveryAddressUpdateActualQuantity::class,
            [$this, 'updateActualQuantity'],
        );

        Event::listen(
            PurchaseDeliveryAddressDeleteEvent::class,
            [$this, 'deleteWarehouseRemains'],
        );
        
    }
    public function addWarehouseRemains(object $event): void
    {     
        try {
  
            if(!array_key_exists('purchase_id', $event->data) || 
                !array_key_exists('warehouse_id', $event->data) ||
                !array_key_exists('purchase_delivery_address_id', $event->data)      
            ) throw new \Exception('LWarehouseRemainsProvider->addWarehouseRemains error');

            $purchaseId = $event->data['purchase_id'];
            $purchase = Purchase::where(['id' => $purchaseId])->first();
            
            //Только если на склад
            if($purchase->purchase_type!=='to_warehouse') return;
           
            $nomenclatureId = $purchase->nomenclature_id;
            $warehouseId = $event->data['warehouse_id'];
            $purchaseDeliveryAddressId = $event->data['purchase_delivery_address_id'];  
            $packingTypeId = $purchase->packing_type_id;
            $price = $purchase->price;
            
            WarehouseRemains::create([
                'purchase_id' => $purchaseId,
                'nomenclature_id' => $nomenclatureId,
                'packing_type_id' => $packingTypeId,
                'warehouse_id' => $warehouseId,
                'purchase_delivery_address_id' => $purchaseDeliveryAddressId,
                'cost' => $price
            ]);
        
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteWarehouseRemains(object $event): void
    {
        try {
            if(!array_key_exists('purchase_delivery_address_id', $event->data))  {   
                throw new \Exception('LWarehouseRemainsProvider->deleteWarehouseRemains error');
            }
            
            $purchaseDeliveryAddressId = $event->data['purchase_delivery_address_id'];
            $model = WarehouseRemains::where([
                'purchase_delivery_address_id'=>$purchaseDeliveryAddressId
            ])->first();
            if(!$model) return;
            $model->update(['deleted_at'=>now()]);
        
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateCost(object $event): void
    {     
        try {
            if(!array_key_exists('cost', $event->data) || 
                !array_key_exists('purchase_delivery_address_id', $event->data)    
            ) throw new \Exception('LWarehouseRemainsProvider->updateCost error');
            $cost = $event->data['cost'];  
            $purchaseDeliveryAddressId = $event->data['purchase_delivery_address_id'];  
            $model = WarehouseRemains::where([
                'purchase_delivery_address_id'=>$purchaseDeliveryAddressId
            ])->first();
            if(!$model) return;
            $model->update(['cost'=>$cost]);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateActualQuantity(object $event): void
    {     
        try {
            if(!array_key_exists('actual_quantity', $event->data) || 
                !array_key_exists('purchase_delivery_address_id', $event->data)    
            ) throw new \Exception('LWarehouseRemainsProvider->updateActualQuantity error'); 
            $actualQuantity = $event->data['actual_quantity'];  
            $purchaseDeliveryAddressId = $event->data['purchase_delivery_address_id'];  
        
            $model = WarehouseRemains::where([
                'purchase_delivery_address_id' => $purchaseDeliveryAddressId
            ])->first();
            if(!$model) return;

            $availability = $actualQuantity - $model->reserve;
            $model->update([
                'actual_quantity' => $actualQuantity,
                'availability' => $availability
            ]);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
}
