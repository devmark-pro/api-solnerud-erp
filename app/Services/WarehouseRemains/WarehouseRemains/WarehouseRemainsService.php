<?php

namespace App\Services\WarehouseRemains\WarehouseRemains;
use App\Models\WarehouseRemains\WarehouseRemains;

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

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->whereHas('nomenclature', function ($query) use ($find) {
                        $query->where('name', 'ILIKE', "%$find%");
                    })->orWhere('id', 'LIKE', "%$find%");
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

            $dataTotal = WarehouseRemains::where($filter)->where(['deleted_at' => null]);
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
            // return $type;
            if($type!=='filters') {
                return WarehouseRemains::where(['id' => $id])->first();
            }
            $data = WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('nomenclature_id',
                    \DB::raw('
                        nomenclature_id as id,
                        sum(actual_quantity) as actual_quantity, 
                        sum(availability) as availability,
                        sum(reserve) as reserve,
                        sum(cost) as cost
                    '))
                ->groupBy('nomenclature_id')
                ->first();

        
            $warehouses =  WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('warehouse_id', 
                    \DB::raw('sum(availability) as availability'))
                ->groupBy('warehouse_id')
                ->get();


            $packingTypes =  WarehouseRemains::where(['nomenclature_id' => $id])
                ->select('packing_type_id', 
                    \DB::raw('
                        sum(availability) as availability
                    ')
                    )
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
}