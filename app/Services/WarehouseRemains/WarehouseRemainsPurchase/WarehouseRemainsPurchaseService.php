<?php

namespace App\Services\WarehouseRemains\WarehouseRemainsPurchase;
use App\Models\WarehouseRemains\WarehouseRemains;


// Тип фасовки имеющийся на складах
class WarehouseRemainsPurchaseService
{

    private static function model(){
        return  WarehouseRemains::join(
                'purchases', 
                'purchases.id', '=', 
                'warehouse_remains.purchase_id'
            )->select('purchase_id',
                    \DB::raw('
                        purchase_id as id,    
                        sum(actual_quantity) as actual_quantity, 
                        sum(availability) as availability,
                        sum(reserve) as reserve   
                    '))
            ->groupBy('purchase_id')
            ->where('availability', '>', 0)
            ->whereNull('warehouse_remains.deleted_at')
;
    }
    public static function index($requestAll) {
        try {
            
            $limit = 30;
            $model = self::model();
            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);
            
            $data = $model->limit($limit)
                ->get();
            return [
                'data' => $data,
            ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function card($id, $requestAll) {
        try {
            $model = self::model();
            $model = self::filter($model, $requestAll);
            return $model->where('purchase_id', $id)->first();
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
                    ->where('purchases.id', 'LIKE', "%$find%")
                    ->orWhere('purchases.name', 'ILIKE', "%$find%");    
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
            foreach($filter as $key => $item) {
                if(is_array($item)) {
                    if(count($item)) {
                        $model->whereIn('warehouse_remains.'.$key, $item);
                    }
                } else {
                    $filter['warehouse_remains.'.$key] = $item;
                }
                unset($filter[$key]);
            }
            $model->where($filter);
        }
        return $model;
    }
}