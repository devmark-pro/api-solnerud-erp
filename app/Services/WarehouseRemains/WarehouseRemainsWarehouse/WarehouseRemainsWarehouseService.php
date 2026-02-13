<?php

namespace App\Services\WarehouseRemains\WarehouseRemainsWarehouse;
use App\Models\WarehouseRemains\WarehouseRemains;


// Тип фасовки имеющийся на складах
class WarehouseRemainsWarehouseService
{
    private static function model(){
        return WarehouseRemains::join('directory_warehouses', 
                'directory_warehouses.id', '=', 
                'warehouse_remains.warehouse_id')
                ->select('warehouse_id',
                    \DB::raw('
                        warehouse_id as id,    
                        sum(actual_quantity) as actual_quantity, 
                        sum(availability) as availability,
                        sum(reserve) as reserve   
                    '))
                ->where('availability', '>', 0)
                ->groupBy('warehouse_id');
    }
    public static function index($requestAll) {
        try {
            
            $limit = 30;
            $filter = [];
            $model = self::model();
            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);

            $data = $model
                ->limit($limit)
                ->get();

            return [
                'data' => $data,
            ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
                
            $model->where(function ($query) use ($find) {
                $query
                    ->where('directory_warehouses.id', 'LIKE', "%$find%")
                    ->orWhere('directory_warehouses.name', 'ILIKE', "%$find%"); 
                });
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
     
        
    public static function card($id, $requestAll) {
        try{
            $model = self::model();
            $model = self::filter($model, $requestAll);
            return $model->where('warehouse_id', $id)->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}