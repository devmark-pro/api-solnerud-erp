<?php

namespace App\Services\WarehouseRemains\WarehouseRemains;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Sale\SaleProduct\SaleProduct;

class WarehouseRemainsService
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
            $model = WarehouseRemains::where(['deleted_at' => null]);
               // ->with([])
            
            $total = $model->get()->count();

            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);


            $totalModel = clone $model;
            
            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

            $data = $model
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            $dataTotal = $totalModel->where($filter)->where(['deleted_at' => null]);
            
            return [

                'data' => $data,
                'data_total' => [
                    'actual_quantity' => $dataTotal->sum('actual_quantity'),
                    'availability' => $dataTotal->sum('availability'),
                    'reserve' => $dataTotal->sum('reserve'),
                ],
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
            return WarehouseRemains::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public static function card($id, $type) {
        try {
            if($type!=='filters') {
                return WarehouseRemains::where(['id' => $id])->first();
            }

            $data = WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('nomenclature_id',
                    \DB::raw('
                        nomenclature_id as id,
                        sum(actual_quantity) as actual_quantity, 
                        sum(availability) as availability,
                        sum(reserve) as reserve
                    '))
                ->where(['deleted_at' => null])
                ->groupBy('nomenclature_id')
                ->first();
            
            $calculationCostArr = WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('availability', 'cost')
                ->where(['deleted_at'=> null])
                ->get()->toArray();
            
            $summCost = 0;
            $summAvail = 0;

            foreach ($calculationCostArr as $costItem){
                $summCost += $costItem['availability'] * $costItem['cost'];
                $summAvail += $costItem['availability'];
            }
            
            $cost = $summCost / $summAvail;

            $data['cost'] = $cost;

            $saleProduct = SaleProduct::where([
                    'nomenclature_id' => $id,
                    'shipment_type' => 'from_warehouse'
                ])
                ->select('nomenclature_id',
                    \DB::raw('
                        nomenclature_id as id,
                        sum(summ) as shipped_summ, 
                        sum(quantity) as shipped_quantity,
                        count(*) as shipped_count
                    '))
                ->groupBy('nomenclature_id')
                ->first();
                
            
            $data['shipped_summ'] = 0;
            $data['shipped_quantity'] = 0;
            $data['shipped_count'] = 0;

            if($saleProduct){
                $saleProductArr = $saleProduct->toArray();
                if(array_key_exists('shipped_summ', $saleProductArr)){
                    $data['shipped_summ'] = (float)$saleProductArr['shipped_summ'];
                }
                if(array_key_exists('shipped_quantity', $saleProductArr)){
                    $data['shipped_quantity'] = (float)$saleProductArr['shipped_quantity'];
                }
                if(array_key_exists('shipped_quantity', $saleProductArr)){
                    $data['shipped_count'] = (float)$saleProductArr['shipped_count'];
                }
            }
            $warehouses =  WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('warehouse_id', 
                    \DB::raw('sum(availability) as availability'))
                ->groupBy('warehouse_id')
                ->get();


            $packingTypes =  WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('packing_type_id', \DB::raw('sum(availability) as availability'))
                ->groupBy('packing_type_id')
                ->get();

            $data['warehouses']= $warehouses;
            $data['packing_types'] = $packingTypes;

            return $data;
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function update($id, $data){ 
        try {
            WarehouseRemains::where('id', $id)->first()->update($data);
            return WarehouseRemains::where('id', $id)
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return WarehouseRemains::where('id', $id)->first()->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return WarehouseRemains::where('id', $id)->fitst()->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = WarehouseRemains::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    private static function find($model, $requestAll){
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model->where('id', 'LIKE', "%$find%")
                 ->orWhere('name', 'ILIKE', "%$find%");       
        }
        return $model;
    }

    
    private static function filter($model, $requestAll){
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
            foreach($filter as $key => $item){
                if(is_array($item)) {
                    if(count($item)) {
                        $model->whereIn($key, $item);
                    }
                unset($filter[$key]);
                }
            }

            $model->where($filter);
        }
        return $model;
    }

}