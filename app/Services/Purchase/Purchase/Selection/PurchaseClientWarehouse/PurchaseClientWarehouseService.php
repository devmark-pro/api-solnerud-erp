<?php

namespace App\Services\Purchase\Purchase\Selection\PurchaseClientWarehouse;
use App\Models\Purchase\Purchase;

class PurchaseClientWarehouseService
{
    private static function model() {
        
        return Purchase::join(
                'purchase_delivery_addresses', 
                'purchase_delivery_addresses.purchase_id', '=', 
                'purchases.id')
            ->join(
                'client_warehouses', 
                'purchase_delivery_addresses.client_warehouse_id', '=', 
                'client_warehouses.id'
            )->select(
                'client_warehouses.id',
                'client_warehouses.name',
                \DB::raw('
                    sum(purchase_delivery_addresses.actual_quantity) as availability   
                ')
            )->groupBy('client_warehouses.id');
       

    }

    public static function index($requestAll) {

        try {
            $limit = 30;
            $model = self::model()->where('purchase_delivery_addresses.actual_quantity', '>', 0);
            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);
            $data = $model->limit($limit)->get();

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
            ->where('purchase_delivery_addresses.client_warehouse_id', $id)
            ->first();
       
    }


    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model->where(function ($query) use ($find) {
                $query->where('client_warehouses.id', 'LIKE', "%$find%")
                ->orWhere('client_warehouses.name', 'ILIKE', "%$find%");
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
                        $model->whereIn('purchases.'.$key, $item);
                    }
                } else {
                    $filter['purchases.'.$key] = $item;
                }
                unset($filter[$key]);
            }

            $model->where($filter);
        }
        return $model;
    }
   
}