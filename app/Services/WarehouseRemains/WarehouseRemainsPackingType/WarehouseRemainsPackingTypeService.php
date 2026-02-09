<?php

namespace App\Services\WarehouseRemains\WarehouseRemainsPackingType;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Sale\SaleProduct\SaleProduct;


// Тип фасовки имеющийся на складах
class WarehouseRemainsPackingTypeService
{
    
    private static function model() {
        return WarehouseRemains::join('directory_packing_types', 
            'directory_packing_types.id', '=', 
            'warehouse_remains.packing_type_id')
            ->select('packing_type_id',
                \DB::raw('
                    packing_type_id as id,    
                    sum(actual_quantity) as actual_quantity, 
                    sum(availability) as availability,
                    sum(reserve) as reserve   
                '))
            ->groupBy('packing_type_id');
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
                ->where('availability', '>', 0)
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
                    ->where('directory_packing_types.id', 'LIKE', "%$find%")
                    ->orWhere('directory_packing_types.name', 'ILIKE', "%$find%");
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
        try {
            $model = self::model();
            $model = self::filter($model, $requestAll);
        
            return $model->where('packing_type_id', $id)->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
   
}