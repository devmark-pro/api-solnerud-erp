<?php

namespace App\Services\WarehouseRemains\WarehouseRemainsWarehouse;
use App\Models\WarehouseRemains\WarehouseRemains;


// Тип фасовки имеющийся на складах
class WarehouseRemainsWarehouseService
{
     public static function index($requestAll) {
        try {
            
            $limit = 30;
            $filter = [];

            $model = WarehouseRemains::join('directory_warehouses', 
                'directory_warehouses.id', '=', 
                'warehouse_remains.warehouse_id');

            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);

            $data = $model->select('warehouse_id',
                    \DB::raw('
                        warehouse_id as id,    
                        sum(actual_quantity) as actual_quantity, 
                        sum(availability) as availability,
                        sum(reserve) as reserve   
                    '))
                ->groupBy('warehouse_id')
                ->where('availability', '>', 0)
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
            $model
                ->where('directory_warehouses.id', 'LIKE', "%$find%")
                ->orWhere('directory_warehouses.name', 'ILIKE', "%$find%");       
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
     
        
    public static function card($id) { 
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
            ->groupBy('warehouse_id')
            ->where('warehouse_id', $id)   
            ->first();
    }
}