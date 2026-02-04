<?php

namespace App\Services\WarehouseRemains\WarehouseRemainsNomenclature;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Nomenclature;


// Товар имеющийся на складах
class WarehouseRemainsNomenclatureService
{
     public static function index($requestAll) {
        try {
            
            $limit = 30;
            $filter = [];

            $model = WarehouseRemains::join('nomenclatures', 
                'nomenclatures.id', '=', 
                'warehouse_remains.nomenclature_id');

            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);

            $data = $model->select('nomenclature_id',
                    \DB::raw('
                        nomenclature_id as id,    
                        sum(actual_quantity) as actual_quantity, 
                        sum(availability) as availability,
                        sum(reserve) as reserve   
                    '))
                ->groupBy('nomenclature_id')
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
                ->where('nomenclatures.id', 'LIKE', "%$find%")
                ->orWhere('nomenclatures.name', 'ILIKE', "%$find%");       
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
     
    public static function card($id) { 
        return WarehouseRemains::join('nomenclatures', 
            'nomenclatures.id', '=', 
            'warehouse_remains.nomenclature_id')
            ->select('nomenclature_id',
                \DB::raw('
                    nomenclature_id as id,    
                    sum(actual_quantity) as actual_quantity, 
                    sum(availability) as availability,
                    sum(reserve) as reserve   
                '))
            ->groupBy('nomenclature_id')
            ->where('nomenclature_id', $id)   
            ->first();
    }
   
}