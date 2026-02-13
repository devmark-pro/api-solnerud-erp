<?php

namespace App\Services\Sale\SaleProduct;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Directory\Nds\NdsService;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Services\Sale\SaleProduct\SaleProductPurchase\SaleProductPurchaseService;
use App\Models\Purchase\PurchaseDeliveryAddress;

use Illuminate\Support\Facades\Log;

class SaleProductService
{
     public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 10;
            $filter=[];
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = SaleProduct::where(['deleted_at' => null]);
               // ->with([])
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'LIKE', "%$find%");
            }

            if(array_key_exists('filter', $requestAll) 
               && (is_array($requestAll['filter']))
            ) 
            {
                $filter = $requestAll['filter']; 
                if(array_key_exists('whereIn', $filter)) {
                    $whereIn = $filter['whereIn'];
                    if(array_key_exists('key', $whereIn) && 
                        array_key_exists('data', $whereIn)) {
                        $key = $whereIn['key'];
                        $data = $whereIn['data'];
                        if(array_key_exists('whereIn', $filter)) {
                            $model->whereIn($key, $data);
                        }
                    }
                    unset($filter['whereIn']);
                }
                $model->where($filter);
            }

            $count = $model->where(['deleted_at' => null])->get()->count();
            $pagesCount = ceil($count/$limit);
            $data = $model
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
                                        
            $total = SaleProduct::where(['deleted_at' => null])
                ->where($filter)
                ->select('sale_id',
                    \DB::raw('
                        sale_id as id,
                        sum(summ) as summ, 
                        sum(quantity) as quantity,
                        sum(summ_nds) as summ_nds,
                        sum(shipped) as shipped,
                        sum(remains_ship) as remains_ship,
                        sum(profit) as profit,
                        sum(shipment_summ) as shipment_summ,
                        sum(shipment_summ_nds) as shipment_summ_nds
                    '))
                ->groupBy('sale_id')
                ->first();
            

            return [
                'data_total' => [
                    'summ' => $total ? round($total->summ, 2) : 0,
                    'summ_nds' => $total ? round($total->summ_nds, 2) : 0,
                    'quantity' => $total ? round($total->quantity, 2) : 0,
                    'shipped' => $total ? round($total->shipped, 2) : 0,
                    'remains_ship' => $total ? round($total->remains_ship, 2) : 0,
                    'profit' => $total ? round($total->profit, 2) : 0,
                    'shipment_summ' => $total ? round($total->shipment_summ, 2) : 0,
                    'shipment_summ_nds' => $total ? round($total->shipment_summ_nds, 2) : 0,
                ],
                'data' => $data,
                'pagination' => [
                    'pagesCount' => $pagesCount,
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'count' => $count,
                ],
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
     
    public static function create($data){
        try {
            $purchases = [];

            if(array_key_exists('purchase_ids', $data)){
                $purchases = $data['purchase_ids'];
                unset($data['purchase_ids']);              
            }
            
            // if(array_key_exists('shipment_type', $data) &&
            //     $data['shipment_type'] === "from_factory") {    
            //     if(array_key_exists('purchase_ids', $data)) {
            //         $purchases = $data['purchase_ids'];
            //         unset($data['purchase_ids']);              
            //     }
            // }

            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
                $data['nds_rate'] = $ndsRate;
            }

            if(array_key_exists('quantity', $data)) {
                $data['remains_ship'] = $data['quantity'];
            }

            $result = SaleProduct::create($data);
            if(count($purchases) > 0) {
                $resultPurchases = SaleProductPurchaseService::deleteAndCreateArray(
                    $result['id'], $result['sale_id'], $data['shipment_type'], $purchases);

                $result['purchases'] = $resultPurchases;
            }
            return $result;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return SaleProduct::where(['id' => $id])->first();    
    }
    public static function update($id, $data){ 
        try {
            // if(array_key_exists('shipment_type', $data)
            //     && $data['shipment_type'] === "from_warehouse") {
            //     if(array_key_exists('purchase_ids', $data)) {
            //         $purchases = $data['purchase_ids'];
            //         unset($data['purchase_ids']);     
            //         SaleProductPurchaseService::deleteAndCreateArray(
            //             $id, 
            //             $data['sale_id'], 
            //             $data['shipment_type'], 
            //             $purchases
            //         );
            //     }
            // }
            // if(array_key_exists('shipment_type', $data) &&
            //     $data['shipment_type'] === "from_factory") {    
            //     if(array_key_exists('purchase_ids', $data)) {
            //         $purchases = $data['purchase_ids'];
            //         unset($data['purchase_ids']);
            //         SaleProductPurchaseService::deleteAndCreateArray(
            //             $id, 
            //             $data['sale_id'], 
            //             $data['shipment_type'], 
            //             $purchases
            //         );         
            //     }
            // }

            if(array_key_exists('purchase_ids', $data)) {
                $purchases = $data['purchase_ids'];
                unset($data['purchase_ids']);
                SaleProductPurchaseService::deleteAndCreateArray(
                    $id, 
                    $data['sale_id'], 
                    $data['shipment_type'], 
                    $purchases
                );         
            }
            

            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
                $data['nds_rate'] = $ndsRate;
            }

            if(array_key_exists('quantity', $data)) {
                $data['remains_ship'] = $data['quantity'];
            }
            
            if(array_key_exists('is_request_shipment', $data)) {
                if($data['is_request_shipment']) {     
                    $c = self::calculateCost($id, $forumla);
                    $data['cost'] = $c;
                    $data['cost_formula'] = $forumla;
                    $data['total_cost'] = $c;
                }
            }
            $model = SaleProduct::where('id', $id)->first()->update($data);
            return SaleProduct::where('id', $id)->first();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return SaleProduct::where('id', $id)->first()->update(['deleted_at' => now()]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return SaleProduct::where('id', $id)->first()->update(['deleted_at' => null]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = SaleProduct::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private static function calculateCost($id, &$forumla) {
        $saleProduct = SaleProduct::where('id', $id)->first();

        // throw new \Error(json_encode($saleProduct));

        if($saleProduct['shipment_type']==="from_warehouse") {
            
            $warehouseRemains = WarehouseRemains::select('id', 'cost', 'availability')
                ->whereIn('purchase_id', $saleProduct['purchase_ids'])
                ->where([ 
                    'warehouse_id' => $saleProduct['warehouse_id'],
                    'deleted_at' => null,
                    ])
                ->get()
                ->toArray();

            

            $cost = 0;
            $costAvailability = 0;
            $summCount = 0;
            ///
                $costAvailabilityStr = "";
                $summCountStr = "";
                $costAvailabilityNum = "";
                $summCountNum = "";
            //
            foreach($warehouseRemains as $item) {
                $costAvailability += $item['cost'] * $item['availability'];
                $summCount += $item['availability'];
                ///
                    $costAvailabilityStr.="+ОстакиСклада".$item['id'].".Себестоимость * ".
                        "ОстакиСклада".$item['id'].".Доступно";

                    $summCountStr.= "+ОстакиСклада".$item['id'].".Доступно";

                    $costAvailabilityNum.= " +".$item['cost']." * ".$item['availability'];
                    $summCountNum.=" +".$item['availability'];
                //
            }
            
            if($summCount != 0 && $costAvailability != 0) {
                $cost = $costAvailability / $summCount; 
            }
        
            $forumla = $costAvailabilityStr." / (".$summCountStr.")</br>". $costAvailabilityNum." / (".$summCountNum.")";
            
            return (float)$cost;
        }

        if($saleProduct['shipment_type'] === "from_factory") {

            $purchaseDeliveryAddress = PurchaseDeliveryAddress::where('id', $saleProduct->purchase_address_id)->first();
            $forumla = "Покупка".$purchaseDeliveryAddress['purchase_id'].
                ".АдресДоставки".$purchaseDeliveryAddress['id'].".Себестоимость<br>".$purchaseDeliveryAddress['cost'];            
            return (float)$purchaseDeliveryAddress->cost;   
        }
    }
}