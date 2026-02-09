<?php

namespace App\Services\Purchase\Purchase\Selection\PurchaseCounterpartyWarehouse;
use App\Models\Purchase\Purchase;

class PurchaseCounterpartyWarehouseService
{
    private static function model() {
        
        return Purchase::join('counterparty_warehouses', 
                'counterparty_warehouses.id', '=', 
                'purchases.counterparty_warehouse_id')
            ->with('counterpartyWarehouse')
            ->select('counterparty_warehouse_id',
                \DB::raw('
                    counterparty_warehouse_id as id,
                    sum(count) as availability   
                '))
            ->groupBy('counterparty_warehouse_id');
    }


    public static function index($requestAll) {

        try {
            $limit = 30;
            $model = self::model();
            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);
            $data = $model
                ->limit($limit)
                ->where('count', '>', 0)
                ->get();

            return [
                'data' => $data,
            ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function card($id, $requestAll) { 

        $model = self::model();
        $model = self::filter($model, $requestAll);
           
        return $model
            ->where('purchases.counterparty_warehouse_id', $id)
            ->first();  
    }


    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model
                ->where('counterparty_warehouses.id', 'LIKE', "%$find%")
                ->orWhere('counterparty_warehouses.name', 'ILIKE', "%$find%");       
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
                        $model->whereIn('purchases.'.$key, $item);
                    }
                }else {
                    $filter['purchases.'.$key] = $item;
                }
                unset($filter[$key]);
            }

            $model->where($filter);
        }
        return $model;
    }
   
}