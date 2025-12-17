<?php

namespace App\Services\Sale\SaleProduct;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleProduct\SaleProductPurchase\SaleProductPurchaseService;
use App\Services\Directory\Nds\NdsService;
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
                                        

            return [
                'data' => $data,
                'pagination' => [
                    'pagesCount' => $pagesCount,
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'count' => $count,
                ],
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     
    public static function create($data){
        try {
            $purchases = [];

            if(array_key_exists('shipment_type', $data)
                && $data['shipment_type'] === "from_warehouse"){
                if(array_key_exists('warehouse_remains_id', $data)){
                    $purchases['warehouse_remains_id'] = $data['warehouse_remains_id'];
                    unset($data['warehouse_remains_id']);              
                }
            }
            if(array_key_exists('shipment_type', $data) &&
                $data['shipment_type'] === "from_factory") {    
                if(array_key_exists('purchase_id', $data)) {
                    $purchases['purchase_id'] = $data['purchase_id'];
                    unset($data['purchase_id']);              
                }
            }

            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
                $data['nds_rate'] = $ndsRate;
            }

            $result = SaleProduct::create($data);
            if(count($purchases) > 0){
                $resultPurchases = SaleProductPurchaseService::deleteAndCreateArray(
                    $result['id'], $result['sale_id'], $data['shipment_type'], $purchases);

                $result['purchases'] = $resultPurchases;
            }
            return $result;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return SaleProduct::where(['id' => $id])->first();    
    }
    public static function update($id, $data){ 
        try {
             if(array_key_exists('shipment_type', $data)
                && $data['shipment_type'] === "from_warehouse"){
                if(array_key_exists('warehouse_remains_ids', $data)){
                    $purchases['warehouse_remains_id'] = $data['warehouse_remains_ids'];
                    unset($data['warehouse_remains_ids']);     
                    SaleProductPurchaseService::deleteAndCreateArray(
                        $id, $data['sale_id'], $data['shipment_type'], $purchases
                    );
                }
            }
            if(array_key_exists('shipment_type', $data) &&
                $data['shipment_type'] === "from_factory") {    
                if(array_key_exists('purchase_ids', $data)) {
                    $purchases['purchase_id'] = $data['purchase_ids'];
                    unset($data['purchase_ids']);
                    SaleProductPurchaseService::deleteAndCreateArray(
                        $id, $data['sale_id'], $data['shipment_type'], $purchases
                    );         
                }
            }

            
            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
                $data['nds_rate'] = $ndsRate;
            }

            SaleProduct::where('id', $id)->first()->update($data);

            return SaleProduct::where('id', $id)->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return SaleProduct::where('id', $id)->first()->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return SaleProduct::where('id', $id)->first()->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = SaleProduct::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}