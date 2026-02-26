<?php

namespace App\Services\WarehouseRemains\WarehouseRemainsNomenclature;
use App\Models\WarehouseRemains\WarehouseRemains;
use App\Models\Nomenclature;


// Товар имеющийся на складах
class WarehouseRemainsNomenclatureService
{
    
    
    private static function model() {
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
            ->where('availability', '>', 0)
            ->whereNull('warehouse_remains.deleted_at')
            ->groupBy('nomenclature_id');

    }

    public static function index($requestAll) {
        try {
            
            $limit = 30;
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
                    ->where('nomenclatures.id', 'LIKE', "%$find%")
                    ->orWhere('nomenclatures.name', 'ILIKE', "%$find%");    
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
        $model = self::model();
        $model = self::filter($model, $requestAll);
        return $model->where('nomenclature_id', $id)->first();
    }
   
}